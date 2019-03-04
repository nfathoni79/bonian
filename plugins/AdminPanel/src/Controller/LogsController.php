<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
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
        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.ActivityLogs')
                ->contain([
                    'Users',
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Users.first_name LIKE' => '%' . $search .'%',
                        'ActivityLogs.created_at LIKE' => '%' . $search .'%',
                        'ActivityLogs.action LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })
            ;

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->toArray();

            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }
    }
}
