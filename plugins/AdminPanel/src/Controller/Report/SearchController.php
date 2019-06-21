<?php
namespace AdminPanel\Controller\Report;

use AdminPanel\Controller\AppController;
use Cake\Database\Expression\QueryExpression;
use Cake\I18n\Time;

/**
 * Reports Controller
 * @property \AdminPanel\Model\Table\SearchTermsTable $SearchTerms
 * @property \AdminPanel\Model\Table\SearchStatsTable $SearchStats
 * @property \AdminPanel\Model\Table\SearchCategoriesTable $SearchCategories
 *
 */
class SearchController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.SearchTerms');
        $this->loadModel('AdminPanel.SearchStats');
        $this->loadModel('AdminPanel.SearchCategories');
    }


    public function index()
    {
        $start = (Time::now())->addDays(-29)->format('Y-m-d');
        $end = (Time::now())->format('Y-m-d');

        if ($date_range = $this->request->getData('date_range')) {
            //parse date range
            list($start, $end) = explode('/', $date_range);
            $start = (Time::parse(trim($start)))->format('Y-m-d');
            $end = (Time::parse(trim($end)))->format('Y-m-d');
        }


        if ($this->DataTable->isAjax()) {


            $sub = $this->SearchStats->find();
            $sub = $sub
                ->select([
                    'id' => $sub->func()->max('SearchStats.id')
                ]);

            if ($start && $end) {
                $sub->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($start, $end) {
                    return $exp->gte('SearchStats.created', $start . ' 00:00:00')
                        ->lte('SearchStats.created', $end . ' 23:59:59');
                });
            }
            $sub->group('SearchStats.search_term_id');


            $categories = $this->SearchCategories->find();

            $categories = $categories
                ->select([
                    'id' => $sub->func()->max('SearchCategories.id'),
                    'search_term_id' => 'SearchCategories.search_term_id'
                ]);

            if ($start && $end) {
                $categories->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($start, $end) {
                    return $exp->gte('SearchCategories.created', $start . ' 00:00:00')
                        ->lte('SearchCategories.created', $end . ' 23:59:59');
                });
            }
            $categories->group('SearchCategories.search_term_id');



            $datatable = $this->DataTable->adapter('AdminPanel.SearchStats')
                ->select([
                    'SearchStats.id',
                    'words' => 'SearchTerms.words',
                    'total' => 'SearchStats.total',
                    'category_name' => 'ProductCategories.name',
                    'hits' => 'SearchTerms.hits',
                    'created' => 'SearchStats.created',
                    'search_term_id' => 'SearchStats.search_term_id'
                ])
                ->leftJoin(['SearchTerms' => 'search_terms'], [
                    'SearchTerms.id = SearchStats.search_term_id'
                ])
                ->innerJoin(['SearchStat' => $sub], [
                    'SearchStats.id = SearchStat.id'
                ])
                ->leftJoin(['SearchCategory' => $categories], [
                    'SearchStats.search_term_id = SearchCategory.search_term_id'
                ])
                ->leftJoin(['SearchCategories' => 'search_categories'], [
                    'SearchCategories.id = SearchCategory.id'
                ])
                ->leftJoin(['ProductCategories' => 'product_categories'], [
                    'ProductCategories.id = SearchCategories.product_category_id'
                ])
                //->leftJoinWith('SearchTerms.SearchCategories.ProductCategories')
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'SearchTerms.words LIKE' => '%' . $search .'%'
                    ]);
                    return $exp
                        ->add($orConditions);
                })
                ->getRequestColumn(3, function($request, \Cake\ORM\Query $table) {
                    if (!empty($request['search']['value'])) {
                        $branch_id = $request['search']['value'];
                        $table->where([
                            'ProductOptionStocks.branch_id' => $branch_id
                        ]);
                    }
                })
                ->group('SearchStats.search_term_id');

            if ($start && $end) {
                $datatable->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($start, $end) {
                    return $exp->gte('SearchStats.created', $start . ' 00:00:00')
                        ->lte('SearchStats.created', $end . ' 23:59:59');
                });
            }



            $result = $datatable
                ->setSorting()
                ->getTable()
                ->toArray();




            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }

        $this->set(compact('start', 'end'));
    }



}
