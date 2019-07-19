<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\I18n\Time;

/**
 * Logs Controller
 * @property \AdminPanel\Model\Table\ActivityLogsTable ActivityLogs
 *
 */
class LogsController  extends AppController
{

    public function initialize()
    {
        parent::initialize();

    }

    public function index(){

        $start = (Time::now())->addDays(-29)->format('Y-m-d');
        $end = (Time::now())->format('Y-m-d');
        if ($date_range = $this->request->getData('date_range')) {
            //parse date range
            list($start, $end) = explode('/', $date_range);
            $start = (Time::parse(trim($start)))->format('Y-m-d');
            $end = (Time::parse(trim($end)))->format('Y-m-d');
        }


        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.ActivityLogs')
                ->contain([
                    'Users',
                ])
                ->where(['ActivityLogs.message != ' => ''])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Users.first_name LIKE' => '%' . $search .'%',
                        'ActivityLogs.message LIKE' => '%' . $search .'%',
                        'ActivityLogs.created_at LIKE' => '%' . $search .'%',
                        'ActivityLogs.action LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })
            ;

            if ($start && $end) {
                $datatable->where(function(\Cake\Database\Expression\QueryExpression $exp) use ($start, $end) {
                    return $exp->gte('ActivityLogs.created_at', $start . ' 00:00:00')
                        ->lte('ActivityLogs.created_at', $end . ' 23:59:59');
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

        $this->set(compact( 'start', 'end'));
    }
}
