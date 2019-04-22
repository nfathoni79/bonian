<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;

/**
 * Dashboard Controller
 *
 * @property \AdminPanel\Model\Table\DigitalsTable $Digitals
 * @property \AdminPanel\Model\Table\DigitalDetailsTable $DigitalDetails
 * @method \AdminPanel\Model\Entity\Dashboard[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DigitalsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Digitals');
        $this->loadModel('AdminPanel.DigitalDetails');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(){
        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.Digitals')
                ->contain([
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Digitals.name LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                });

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->toArray();

            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }
    }

    /**
     * Details method
     *
     * @return \Cake\Http\Response|void
     */
    public function detail($id = null){
        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.DigitalDetails')
                ->contain([
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'DigitalDetails.name LIKE' => '%' . $search .'%',
                        'DigitalDetails.denom LIKE' => '%' . $search .'%',
                        'DigitalDetails.operator LIKE' => '%' . $search .'%',
                        'DigitalDetails.price LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                });

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->toArray();

            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }
    }

    /**
     * Change Status method
     *
     * @return \Cake\Http\Response|void
     */
    public function change(){
        $this->autoRender = false;
        $digitalDetail = $this->DigitalDetails->get($this->request->getData('id'));
        try{
            $digitalDetail->set('status', $this->request->getData('stts'));
            if ($this->DigitalDetails->save($digitalDetail)) {
                $this->Flash->success(__('The product digital details has been saved.'));
                $result = ['is_success' => true];
            }else {
                $this->Flash->error(__('The product digital could not be saved. Please, try again.'));
                $result = ['is_success' => false];
            }
        }catch (Exception $e) {
            $this->Flash->error(__('The product digitals could not be change. Please, try again.'));

            $result = ['is_success' => false];
        }
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($result));
    }


    public function validate(){
        $this->autoRender = false;
        $digitalDetail = $this->request->getData('DigitalDetails');
        $validator = new Validator();

        $digitalValue = new Validator();
        foreach($digitalDetail as $k => $vals){
            if(!empty($vals['id'])) {
                $digitalDetail[$k]['denom'] = preg_replace('/[,.]/', '', $vals['denom']);
                $digitalDetail[$k]['price'] = preg_replace('/[,.]/', '', $vals['price']);
            } else {
                unset($digitalDetail[$k]);
            }
        }
        foreach($digitalDetail as $k => $vals){
            if(!empty($vals['id'])) {
                $digitalValue
                    ->notBlank('denom', 'tidak boleh kosong')
                    ->decimal('denom');
                $digitalValue
                    ->notBlank('price', 'tidak boleh kosong')
                    ->decimal('price');
                $digitalValue
                    ->notBlank('name', 'tidak boleh kosong');
                $digitalValue
                    ->notBlank('code', 'tidak boleh kosong');
                $digitalValue
                    ->notBlank('operator', 'tidak boleh kosong');
                $digitalValue
                    ->notBlank('status', 'tidak boleh kosong');
            }
        }
        $validator->addNestedMany('DigitalDetails', $digitalValue);

        $allData['DigitalDetails'] = $digitalDetail;
        $error = $validator->errors($allData);
        if (empty($error)) {

            foreach($digitalDetail as $vals){
                $id = $vals['id'];
                $details = $this->DigitalDetails->get($id);
                $details->set('code', $vals['code']);
                $details->set('name', $vals['name']);
                $details->set('denom', $vals['denom']);
                $details->set('price', $vals['price']);
                $details->set('operator', $vals['operator']);
                $details->set('point', $vals['point']);
                $details->set('status', $vals['status']);
                $this->DigitalDetails->save($details);
            }
            $this->Flash->success(__('The product digital details has been saved.'));
        }
        $response['error'] = $error;
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    public function add(){


        $digitalDetail = $this->DigitalDetails->newEntity();
        if ($this->request->is('post')) {
            $digital = $this->request->getData();
            $validator = new Validator();

            $this->request->data['denom'] = preg_replace('/[,.]/', '', $digital['denom']);
            $this->request->data['price'] = preg_replace('/[,.]/', '', $digital['price']);

//            $validator
//                ->scalar('name')
//                ->maxLength('name', 50)
//                ->requirePresence('name', 'create')
//                ->allowEmptyString('name', false);
//
//            $validator
//                ->requirePresence('denom')
//                ->numeric('denom', 'tidak boleh kosong');
//
//            $validator
//                ->requirePresence('operator')
//                ->notBlank('operator', 'tidak boleh kosong')
//                ->add('operator', 'unique', [
//                    'rule' => function($value) {
//                        return $this->DigitalDetails->find()
//                                ->select(['operator'])
//                                ->where(['operator' => $value])
//                                ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
//                                    return $exp->notEq('denom', $this->request->getData('denom'));
//                                })
//                                ->count() == 0;
//                    },
//                    'message' => 'produk sudah terdaftar'
//                ]);
//
//
//
//            $error = $validator->errors($digital);
//            if (empty($error)) {
                $digitalDetail = $this->DigitalDetails->patchEntity($digitalDetail, $this->request->getData());
                $digitalDetail->set('digital_id', 1);
                if ($this->DigitalDetails->save($digitalDetail)) {
                    $this->Flash->success(__('New pulsa has been saved.'));
                    return $this->redirect(['action' => 'detail', 1]);
                }
//            }else{
                $this->Flash->error(__('New pulsa product could not be saved. Please, try again.'));
//            }
        }
        $this->set(compact('digitalDetail'));

    }


}
