<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * Reports Controller
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\ProductRatingsTable $ProductRatings
 *
 * @method \AdminPanel\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReportsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Products');
        $this->loadModel('AdminPanel.ProductRatings');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function review()
    {
        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.Products')
                ->select([
                    'id',
                    'name',
                    'rating_count',
                    'modified',
                ])
                ->contain([
                    'ProductRatings'
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Products.name LIKE' => '%' . $search .'%',
                        'Products.modified LIKE' => '%' . $search .'%',
                        'Products.rating_count LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })
                ->where(['Products.rating_count > ' => 0])
            ;

            $result = $datatable
                ->setSorting()
                ->getTable()->map(function (\AdminPanel\Model\Entity\Product $row) {
                    $row->count_review = count($row->product_ratings);
                    return $row;
                })
                ->toArray();
            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }
    }

    public function listReview($id = null){

        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.ProductRatings')
                ->contain([
                    'Customers' => [
                        'fields' => [
                            'id',
                            'first_name',
                            'last_name',
                        ]
                    ]
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Customers.first_name LIKE' => '%' . $search .'%',
                        'Customers.last_name LIKE' => '%' . $search .'%',
                        'ProductRatings.comment LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })
                ->where(['ProductRatings.product_id' => $id]);

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->toArray();
            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }


    }


    public function deleteReview($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rating = $this->ProductRatings->get($id);
        try {
            if ($this->ProductRatings->delete($rating)) {
                $this->Flash->success(__('The product review has been deleted.'));
            } else {
                $this->Flash->error(__('The product review  could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The product review  could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'review']);
    }

}
