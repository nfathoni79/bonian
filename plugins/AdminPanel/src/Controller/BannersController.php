<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;

/**
 * Banners Controller
 * @property \AdminPanel\Model\Table\BannersTable $Banners
 * @property \AdminPanel\Model\Table\ProductCategoriesTable $ProductCategories
 *
 * @method \AdminPanel\Model\Entity\Banner[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BannersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Banners');
        $this->loadModel('AdminPanel.ProductCategories');
    }

    public function validate(){
        $this->autoRender = false;
        $banners = $this->request->getData('Banners');
        $validator = new Validator();

        $bannerValue = new Validator();
        foreach($banners as $k => $vals){
            if(!empty($vals['id'])) {
            } else {
                unset($banners[$k]);
            }
        }
        foreach($banners as $k => $vals){
            if(!empty($vals['id'])) {
                $bannerValue
                    ->notBlank('status', 'tidak boleh kosong');
            }
        }
        $validator->addNestedMany('Banners', $bannerValue);

        $allData['Banners'] = $banners;
        $error = $validator->errors($allData);
        if (empty($error)) {

            foreach($banners as $vals){
                $id = $vals['id'];
                $details = $this->Banners->get($id);
                $details->set('status', $vals['status']);
                $this->Banners->save($details);
            }
            $this->Flash->success(__('The banners has been saved.'));
        }
        $response['error'] = $error;
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.Banners')
                ->contain([
                    'ProductCategories'
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Banners.name LIKE' => '%' . $search .'%',
                        'Banners.position LIKE' => '%' . $search .'%',
                        'Banners.type LIKE' => '%' . $search .'%',
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
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

    public function add()
    {
        $banner = $this->Banners->newEntity();
        if ($this->request->is('post')) {
            if(!empty($this->request->getData('product_category_id'))){
                $this->request->data['position'] = 'Product List By Category';
            }

            $banner = $this->Banners->patchEntity($banner, $this->request->getData());
            if ($this->Banners->save($banner)) {
                $this->Flash->success(__('The banner has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The banner could not be saved. Please, try again.'));
        }
        $productCategories = $this->ProductCategories->find('list')->where(['parent_id IS' => NULL]);
        $this->set(compact('banner', 'productCategories'));
    }



    /**
     * Delete method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
//        $this->request->allowMethod(['post', 'delete']);
        $banner = $this->Banners->get($id);
        try {
            if ($this->Banners->delete($banner)) {
                $this->Flash->success(__('The banner has been deleted.'));
            } else {
                $this->Flash->error(__('The banner could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The banner could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
