<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;

/**
 * Brands Controller
 * @property \AdminPanel\Model\Table\BrandsTable $Brands
 * @property \AdminPanel\Model\Table\ProductCategoriesTable ProductCategories
 *
 * @method \AdminPanel\Model\Entity\Brand[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BrandsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.ProductCategories');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {


        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');

            $pagination = $this->request->getData('pagination');
            $sort = $this->request->getData('sort');
            $query = $this->request->getData('query');

            /** custom default query : select, where, contain, etc. **/
            $data = $this->Brands->find('all')
                ->select();
            $data->contain(['ProductCategories', 'ParentBrands']);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['Brands.name LIKE' => '%' . $search .'%']);
                }
                $data->where($query);
            }

            if (isset($sort['field']) && isset($sort['sort'])) {
                $data->order([$sort['field'] => $sort['sort']]);
            }

            if (isset($pagination['perpage']) && is_numeric($pagination['perpage'])) {
                $data->limit($pagination['perpage']);
            }
            if (isset($pagination['page']) && is_numeric($pagination['page'])) {
                $data->page($pagination['page']);
            }

            $total = $data->count();

            $result = [];
            $result['data'] = $data->toArray();


            $result['meta'] = array_merge((array) $pagination, (array) $sort);
            $result['meta']['total'] = $total;


            return $this->response->withType('application/json')
            ->withStringBody(json_encode($result));
        }


        $this->set(compact('brands'));
    }

    /**
     * View method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $brand = $this->Brands->get($id, [
            'contain' => ['ProductCategories', 'ParentBrands', 'ChildBrands', 'Products']
        ]);

        $this->set('brand', $brand);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $brand = $this->Brands->newEntity();

        if ($this->request->is(['ajax'])) {
            $this->disableAutoRender();
            $response = [];
            $validator = new Validator();

            $validator
                ->requirePresence('product_category_id')
                ->hasAtLeast('product_category_id', 1, __d('AdminPanel', __d('AdminPanel','Silahkan pilih kategori')));


            $brandDetail = new Validator();

            $brandDetail
                ->requirePresence('value')
                ->hasAtLeast('value', 1, 'Tidak boleh kosong');

            $validator->addNestedMany('attribute', $brandDetail);


            if (empty($error)) {
                $product_category_id = $this->request->getData('product_category_id.0');

                if ($brands = $this->request->getData('brand')) {

                    foreach($brands as $brand) {
                        foreach($brand['value'] as $child) {
                            $brandChildEntity = $this->Brands->newEntity([
                                'product_category_id' => $product_category_id,
                                'name' => $child,
                                'parent_id' => null
                            ]);
                            $this->Brands->save($brandChildEntity);
                        }
                    }
//                    if ($attributeEntity->get('id')) {
                        $this->Flash->success(__('The brand has been saved.'));
//                    }

                }
            }

            $response['error'] = $validator->errors($this->request->getData());
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($response));
        }
        /*
        $brand = $this->Brands->newEntity();
        if ($this->request->is('post')) {
            $brand = $this->Brands->patchEntity($brand, $this->request->getData());
            if ($this->Brands->save($brand)) {
                $this->Flash->success(__('The brand has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The brand could not be saved. Please, try again.'));
        }
        */
        $productCategories = $this->Brands->ProductCategories->find('list', ['limit' => 200]);
        $parentBrands = $this->Brands->ParentBrands->find('list', ['limit' => 200]);
        $this->set(compact('brand', 'productCategories', 'parentBrands'));

    }

    /**
     * Edit method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $brand = $this->Brands->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $brand = $this->Brands->patchEntity($brand, $this->request->getData());
            if ($this->Brands->save($brand)) {
                $this->Flash->success(__('The brand has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The brand could not be saved. Please, try again.'));
        }
//        $productCategories = $this->Brands->ProductCategories->find('list', ['limit' => 200]);
        $productCategories = $this->Brands->ProductCategories->find('treeList', [
            'keyPath' => 'id',
            'valuePath' => 'name',
            'spacer' => '&nbsp;&nbsp;&nbsp;'
        ]);
        $parentBrands = $this->Brands->ParentBrands->find('list', ['limit' => 200]);
        $this->set(compact('brand', 'productCategories', 'parentBrands'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $brand = $this->Brands->get($id);
        try {
            if ($this->Brands->delete($brand)) {
                $this->Flash->success(__('The brand has been deleted.'));
            } else {
                $this->Flash->error(__('The brand could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The brand could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function import(){

        if ($this->request->is('post')) {

            $data = $this->request->getData('files');
            $file = $data['tmp_name'];
            $handle = fopen($file, "r");
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $findMainCategory = $this->ProductCategories->find()
                    ->where(['ProductCategories.name' => $row[2]])
                    ->first();
                if($findMainCategory){
                    if(!empty($row[3])){
                        $explode = explode(',', $row[3]);
                        foreach($explode as $val){
                            $newEntity = $this->Brands->newEntity();
                            $newEntity = $this->Brands->patchEntity($newEntity, $this->request->getData());
                            $newEntity->set('parent_id', null);
                            $newEntity->set('product_category_id', $findMainCategory->get('id'));
                            $newEntity->set('name', trim($val));
                            $this->Brands->save($newEntity);
                        }
                    }
                }
            }
            $this->Flash->success(__('Success import file'));
            $this->redirect(['action' => 'index']);
        }

    }

}
