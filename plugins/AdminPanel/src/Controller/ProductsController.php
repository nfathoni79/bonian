<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;

/**
 * Products Controller
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\CourriersTable $Courriers
 * @property \AdminPanel\Model\Table\OptionsTable $Options
 * @property \AdminPanel\Model\Table\OptionValuesTable $OptionValues
 * @property \AdminPanel\Model\Table\BranchesTable $Branches
 *
 * @method \AdminPanel\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Courriers');
        $this->loadModel('AdminPanel.Options');
        $this->loadModel('AdminPanel.OptionValues');
        $this->loadModel('AdminPanel.Branches');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response
     */
    public function index()
    {


        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');

            $pagination = $this->request->getData('pagination');
            $sort = $this->request->getData('sort');
            $query = $this->request->getData('query');

            /** custom default query : select, where, contain, etc. **/
            $data = $this->Products->find('all')
                ->select();
            $data->contain(['ProductStockStatuses', 'ProductWeightClasses', 'ProductStatuses']);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['Products.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('products'));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $product = $this->Products->get($id, [
            'contain' => ['ProductStockStatuses', 'ProductWeightClasses', 'ProductStatuses', 'OrderProducts', 'ProductAttributes', 'ProductDeals', 'ProductDiscounts', 'ProductImages', 'ProductMetaTags', 'ProductOptionValues', 'ProductStockMutations', 'ProductToCategories']
        ]);

        $this->set('product', $product);
    }


    public function validationWizard($step = 1)
    {
        $this->disableAutoRender();
        $validator = new Validator();

        switch ($step) {
            case '1':

                break;
            case '2':
                $validator
                    ->requirePresence('name')
                    ->notBlank('name', 'tidak boleh kosong');

                //$validator
                //    ->requirePresence('title')
                //    ->notBlank('title', 'tidak boleh kosong');

                $validator
                    ->requirePresence('slug')
                    ->notBlank('slug', 'tidak boleh kosong');

                $validator
                    ->requirePresence('condition')
                    ->notBlank('condition', 'tidak boleh kosong');

                $meta = new Validator();
                $meta
                    ->requirePresence('keyword')
                    ->notBlank('keyword', 'tidak boleh kosong');

                $validator->addNested('ProductMetaTags', $meta);

                $validator
                    ->requirePresence('model')
                    ->notBlank('model', 'tidak boleh kosong');

                $validator
                    ->requirePresence('sku')
                    ->notBlank('sku', 'tidak boleh kosong');

                //$validator
                //    ->requirePresence('code')
                //    ->notBlank('code', 'tidak boleh kosong');

                $validator
                    ->requirePresence('price')
                    ->notBlank('price', 'tidak boleh kosong');

                $validator
                    ->requirePresence('ProductToCourriers')
                    ->hasAtLeast('ProductToCourriers', 2, __d('AdminPanel', __d('AdminPanel','pilihan minimal 2 kurir')));

                $productOption = new Validator();

                $productOption
                    ->notBlank('warna', 'tidak boleh kosong');

                $productOption
                    ->notBlank('ukuran', 'tidak boleh kosong');

                $validator->addNestedMany('ProductOptionValues', $productOption);

                $productPrice = new Validator();
                $productPrice
                    ->requirePresence('price')
                    ->numeric('price', 'tidak boleh kosong');

                $validator->addNestedMany('ProductOptionPrices', $productPrice);
                break;

            case '3':

                break;

        }

        $error = $validator->errors($this->request->getData());
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($error));
    }


    public function upload()
    {
        $this->disableAutoRender();
        $error = [];
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($error));
    }


    public function addOptions(){
        $this->disableAutoRender();
        $validator = new Validator();
        $validator
            ->notBlank('name', 'tidak boleh kosong');
        $error = $validator->errors($this->request->getData());
        if(empty($error)){

            $code = $this->request->getData('code_attribute');
            $name = $this->request->getData('name');

            $getOptions = $this->Options->find()
                ->where(['Options.name' => $code])
                ->first();


            if($getOptions){

                $idOptions = $getOptions->get('id');
                $newEntity = $this->OptionValues->newEntity();
                $newEntity = $this->OptionValues->patchEntity($newEntity,$this->request->getData());
                $newEntity->set('option_id', $idOptions);
                $newEntity->set('name', $name);

                if($this->OptionValues->save($newEntity)){
                    $data = ['id' => $newEntity->get('id'), 'name' => $name];
                    $respon = ['is_error' => false, 'message' => 'Atribute berhasil didaftarkan', 'data' => $data];
                }else{
                    $respon = ['is_error' => true, 'message' => 'Gagal menyimpan data / pilihan sudah terdaftar'];
                }
            }else{
                $respon = ['is_error' => true, 'message' => 'Gagal menyimpan data / opsi utama tidak tersedia'];
            }
        }else{
            $respon = ['is_error' => true, 'message' => 'Gagal menyimpan data'];
        }
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($respon));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {
            debug($this->request->getData());
            exit;
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $productStockStatuses = $this->Products->ProductStockStatuses->find('list', ['limit' => 200]);
        $productWeightClasses = $this->Products->ProductWeightClasses->find('list', ['limit' => 200]);
        $productStatuses = $this->Products->ProductStatuses->find('list', ['limit' => 200]);
        $courriers = $this->Courriers->find('list')->toArray();
        $options = $this->Options->find('list')->toArray();



        $this->set(compact('product', 'productStockStatuses', 'productWeightClasses', 'productStatuses','courriers','options'));
    }

    public function getoptionvalues(){


        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $options = $this->Options->find('list')->toArray();
            $listOptions = [];
            foreach($options as $k => $vals){
                $optionValues = $this->OptionValues->find()
                    ->where(['OptionValues.option_id' => $k])
                    ->toArray();
                $listOptions[$vals] = $optionValues;
            }

            return $this->response->withType('application/json')
                ->withStringBody(json_encode($listOptions));
        }
    }
    public function getListBranch(){


        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $options = $this->Branches->find('list')->toArray();

            return $this->response->withType('application/json')
                ->withStringBody(json_encode($options));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $productStockStatuses = $this->Products->ProductStockStatuses->find('list', ['limit' => 200]);
        $productWeightClasses = $this->Products->ProductWeightClasses->find('list', ['limit' => 200]);
        $productStatuses = $this->Products->ProductStatuses->find('list', ['limit' => 200]);
        $this->set(compact('product', 'productStockStatuses', 'productWeightClasses', 'productStatuses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        try {
            if ($this->Products->delete($product)) {
                $this->Flash->success(__('The product has been deleted.'));
            } else {
                $this->Flash->error(__('The product could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
