<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use AdminPanel\Model\Entity\Product;
use Cake\Validation\Validator;

/**
 * Products Controller
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\CourriersTable $Courriers
 * @property \AdminPanel\Model\Table\OptionsTable $Options
 * @property \AdminPanel\Model\Table\OptionValuesTable $OptionValues
 * @property \AdminPanel\Model\Table\BranchesTable $Branches
 * @property \AdminPanel\Model\Table\ProductImageSizesTable $ProductImageSizes
 * @property \AdminPanel\Model\Table\ProductCategoriesTable $ProductCategories
 * @property \AdminPanel\Model\Table\ProductToCategoriesTable $ProductToCategories
 *
 * @method \AdminPanel\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{

    protected $allowedFileType = [];

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Courriers');
        $this->loadModel('AdminPanel.Options');
        $this->loadModel('AdminPanel.OptionValues');
        $this->loadModel('AdminPanel.Branches');
        $this->loadModel('AdminPanel.ProductImageSizes');
        $this->loadModel('AdminPanel.ProductCategories');
        $this->loadModel('AdminPanel.ProductToCategories');

        $this->allowedFileType = [
            'image/jpg',
            'image/png',
            'image/jpeg'
        ];
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
        $response = [];
        $validator = new Validator();

        /**
         * @var \AdminPanel\Model\Entity\Product $productEntity
         */
        $productEntity = null;

        /**
         * @var \AdminPanel\Model\Entity\ProductToCategory $productToCategoryEntity
         */
        $productToCategoryEntity = $this->ProductToCategories->newEntity();

        switch ($step) {
            case '1':
                $validator
                    ->requirePresence('product_category_id')
                    ->hasAtLeast('product_category_id', 1, __d('AdminPanel', __d('AdminPanel','Silahkan pilih kategori')));

                //process insert new product here
                $error = $validator->errors($this->request->getData());

                if (empty($error)) {

                    $getProduct = null;
                    if ($this->request->getData('id')) {
                        $getProduct = $this->Products->find()
                            ->where([
                                'Products.id' => $this->request->getData('id')
                            ])
                            ->first();
                    }


                    $productEntity = !empty($getProduct) ? $getProduct : $this->Products->newEntity([
                        'name' => '',
                        'qty' => 0,
                        'product_stock_status_id' => 1, //TODO for this
                        'shipping' => 1,
                        'price' => 0,
                        'price_discount' => 0,
                        'weight' => 0,
                        'product_weight_class_id' => null,
                        'product_status_id' => 2,
                        'highlight' => '',
                        'condition' => '', //TODO default value not null
                        'profile' => ''
                    ], ['validate' => false]); //disable validation rule


                    $product_category_id = $this->request->getData('product_category_id');
                    if ($this->Products->save($productEntity)) {

                        $getProductToCategory = null;
                        if ($this->request->getData('id')) {
                            $getProductToCategory = $this->ProductToCategories->find()
                                ->where([
                                    'ProductToCategories.product_id' => $this->request->getData('id')
                                ])
                                ->first();
                        }

                        $productToCategoryEntity = !empty($getProductToCategory) ? $getProductToCategory :  $productToCategoryEntity;

                        $this->ProductToCategories->patchEntity($productToCategoryEntity, [
                            'product_id' => $productEntity->get('id'),
                            'product_category_id' => $product_category_id[0]
                        ]);

                        $this->ProductToCategories->save($productToCategoryEntity);

                        $response['data'] = $productEntity;
                    }
                }

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

                $error = $validator->errors($this->request->getData());

                if (empty($error)) {

                    $productEntity = $this->Products->find()
                        ->where([
                            'Products.id' => $this->request->getData('id')
                        ])
                        ->first();



                    $this->Products->patchEntity($productEntity, $this->request->getData(), ['validate' => false]);

                    //debug($productEntity);

                    $this->Products->save($productEntity);

                    //debug($productEntity->getErrors());
                }

                break;

            case '3':

                break;

        }

        //global response error
        $response['error'] = $validator->errors($this->request->getData());
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    public function getCategory()
    {
        $this->disableAutoRender();
        $this->request->allowMethod('Post');
        $parent_id = $this->request->getData('parent_id');
        $parent_categories = [];
        if ($parent_id) {
            $parent_categories = $this->ProductCategories->find('list')
                ->where([
                    'parent_id' => $parent_id
                ])->toArray();
        }
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($parent_categories));
    }


    public function upload()
    {
        $this->request->allowMethod('post');
        $this->disableAutoRender();

        $file = $this->request->getData('name');

        $Response = $this->response->withType('application/json');

        $out = [];
        $out['error'] = '';
        $out['data'] = $file;

        $mime = mime_content_type($file['tmp_name']);

        if (in_array($mime, $this->allowedFileType)) {
            $entity = $this->ProductImageSizes->ProductImages->newEntity();

            $this->ProductImageSizes->ProductImages->patchEntity($entity, $this->request->getData());


            if ($this->ProductImageSizes->ProductImages->save($entity)) {

                $Response = $Response->withStatus('200');
            } else {
                $out['error'] = __d('AdminPanel', 'Gagal upload');
                $out['message'] = $entity->getErrors();

                $Response = $Response->withStatus('401');
            }
        } else {
            $out['error'] = __d('AdminPanel', 'file harus jpg, png');
            $Response = $Response->withStatus('401');
        }


        return $Response
            ->withStringBody(json_encode($out));
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

        $parent_categories = $this->ProductCategories->find('list')
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->isNull('parent_id');
            })->toArray();
        //debug($parent_categories->toArray());

        $this->set(compact('product', 'productStockStatuses', 'productWeightClasses', 'productStatuses','courriers','options', 'parent_categories'));
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
