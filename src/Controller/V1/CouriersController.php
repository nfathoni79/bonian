<?php

namespace App\Controller\V1;


/**
 * Class CouriersController
 * @package App\Controller\V1
 * @property \AdminPanel\Model\Table\CourriersTable $Courriers
 */
class CouriersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Courriers');
    }


    public function index()
    {
        $data = $this->Courriers->find()
            ->all();

        $this->set(compact('data'));
    }
}
