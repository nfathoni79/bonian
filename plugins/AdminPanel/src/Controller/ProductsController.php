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
 * @property \AdminPanel\Model\Table\ProductOptionValueListsTable $ProductOptionValueLists
 * @property \AdminPanel\Model\Table\ProductWarrantiesTable $ProductWarranties
 * @property \AdminPanel\Model\Table\AttributesTable $Attributes
 * @property \AdminPanel\Model\Table\BrandsTable Brands
 * @property \AdminPanel\Model\Table\TagsTable $Tags
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
        $this->loadModel('AdminPanel.ProductOptionValueLists');
        $this->loadModel('AdminPanel.Tags');
        $this->loadModel('AdminPanel.ProductWarranties');
        $this->loadModel('AdminPanel.Attributes');
        $this->loadModel('AdminPanel.Brands');

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
            $data->contain(['ProductStockStatuses', 'ProductWeightClasses', 'ProductStatuses', 'ProductImages']);

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


    /**
     * @param $category_id
     * @param $brand_id
     * @return string
     */
    protected function generateSku($category_id, $brand_id)
    {
        $this->disableAutoRender();
        /**
         * @var \AdminPanel\Model\Entity\ProductCategory[] $paths
         */
        $paths = $this->ProductCategories->find('path', ['for' => $category_id])->toArray();
        $codeSku = [];
        array_push($codeSku, $brand_id);
        foreach($paths as $key => $path) {
            if ($key == 0) {
                array_push($codeSku, $path->get('id'));
            }
            if (count($paths) == $key + 1) {
                array_push($codeSku, str_pad($path->get('id'), 3, '0', STR_PAD_LEFT));
            }
        }
        array_push($codeSku, date('m'));
        array_push($codeSku, str_pad(rand(1, 999), 4, 0, STR_PAD_LEFT));
        return join('', $codeSku);
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
                        'price_sale' => 0,
                        'weight' => 0,
                        'product_weight_class_id' => 1, // 1 mean gram
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
                    ->requirePresence('brand_id')
                    ->notBlank('brand_id', 'tidak boleh kosong');

                //$validator
                //    ->requirePresence('condition')
                //    ->notBlank('condition', 'tidak boleh kosong');

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
                    ->notBlank('sku', 'tidak boleh kosong')
                    ->add('sku', 'unique', [
                        'rule' => function($value) {
                            return $this->Products->find()
                                ->select(['sku'])
                                ->where(['sku' => $value])
                                ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                                    return $exp->notEq('id', $this->request->getData('id'));
                                })
                                ->count() == 0;
                        },
                        'message' => 'sku sudah terdaftar'
                    ]);

                //$validator
                //    ->requirePresence('code')
                //    ->notBlank('code', 'tidak boleh kosong');

                $validator
                    ->requirePresence('price')
                    ->notBlank('price', 'tidak boleh kosong');

                $validator
                    ->requirePresence('point')
                    ->notBlank('point', 'tidak boleh kosong');

                $validator
                    ->requirePresence('price_sale')
                    ->notBlank('price_sale', 'tidak boleh kosong');

                $validator
                    ->requirePresence('ProductToCourriers')
                    ->hasAtLeast('ProductToCourriers', 2, __d('AdminPanel', __d('AdminPanel','pilihan minimal 2 kurir')));

                $productOption = new Validator();

                /*$productOption
                    ->notBlank('warna', 'tidak boleh kosong');

                $productOption
                    ->notBlank('ukuran', 'tidak boleh kosong');*/

                //dynamic validation from table options
                $getOption = $this->Options->find('list');
                foreach($getOption as $option_id => $option_name) {
                    $productOption
                        ->notBlank($option_id, 'tidak boleh kosong');
                }

                $validator->addNestedMany('ProductOptionValueLists', $productOption);

                $productPrice = new Validator();
                $productPrice
                    ->requirePresence('price')
                    ->numeric('price', 'tidak boleh kosong');

                $validator->addNestedMany('ProductOptionPrices', $productPrice);


                $productSize = new Validator();
                $productSize
                    ->notBlank('weight');


                //added nested validation on branches -> 0 -> branch_id
                $branches = new Validator();
                $branches
                    ->requirePresence('branch_id')
                    ->notBlank('branch_id');
                $branches
                    ->requirePresence('stock')
                    ->notBlank('stock');

                $productSize->addNestedMany('branches', $branches);

                $validator->addNestedMany('ProductOptionStocks', $productSize);

                $error = $validator->errors($this->request->getData());

                if (empty($error)) {

                    $productEntity = $this->Products->find()
                        ->where([
                            'Products.id' => $this->request->getData('id')
                        ])
                        ->first();

                    $this->Products->patchEntity($productEntity, $this->request->getData(), ['validate' => false]);

                    //debug($productEntity);

                    if ($this->Products->save($productEntity)) {

                        //processing save ProductMetaTags
                        $getMetaTag = $this->Products->ProductMetaTags->find()
                            ->where([
                                'product_id' => $productEntity->get('id')
                            ])
                            ->first();

                        $metaTagEntity = !empty($getMetaTag) ?
                            $getMetaTag :
                            $this
                                ->Products
                                ->ProductMetaTags
                                ->newEntity(['product_id' => $productEntity->get('id')]);

                        $this
                            ->Products
                            ->ProductMetaTags
                            ->patchEntity($metaTagEntity, $this->request->getData('ProductMetaTags'));

                        $this
                            ->Products
                            ->ProductMetaTags
                            ->save($metaTagEntity);

                        //product tags
                        if ($product_tags = $this->request->getData('ProductTags')) {
                            /**
                             * @var \AdminPanel\Model\Entity\ProductTag[] $getProductTag
                             */
                            $getProductTag = $this->Products->ProductTags->find()
                                ->where([
                                    'product_id' => $productEntity->get('id')
                                ]);

                            //remove exists if not in request
                            foreach($getProductTag as $tags) {
                                if (!in_array($tags->get('tag_id'), $product_tags)) {
                                    $this->Products->ProductTags->delete($tags);
                                } else {
                                    $key = array_search($tags->get('tag_id'), $product_tags);
                                    if ($key >= 0) {
                                        unset($product_tags[$key]);
                                    }
                                }
                            }
                            foreach($product_tags as $tag_id) {
                                $productTagEntity = $this->Products->ProductTags->newEntity(['product_id' => $productEntity->get('id')]);
                                if (!is_numeric($tag_id)) {
                                    //save new data to tags and product_tags
                                    $tagEntity = $this->Tags->newEntity(['name' => $tag_id]);
                                    if ($this->Tags->save($tagEntity)) {
                                        $tag_id = $tagEntity->get('id');
                                    } else {
                                        $tag_id = null;
                                    }

                                }
                                if ($tag_id) {
                                    $this->Products->ProductTags->patchEntity($productTagEntity, ['tag_id' => $tag_id]);
                                    $this->Products->ProductTags->save($productTagEntity);
                                }


                            }
                        }

                        //save product to attribute
                        if ($attributes = $this->request->getData('ProductToAttributes')) {

                            //exists product attribute
                            /**
                             * @var \AdminPanel\Model\Entity\ProductAttribute[] $getProductAttributes
                             */
                            $getProductAttributes = $this->Products->ProductAttributes->find()
                                ->where([
                                    'product_id' => $productEntity->get('id')
                                ]);

                            //loop attribute request data
                            $attribute_requests = [];
                            foreach($attributes as $key => $attribute) {
                                foreach($attribute as $attribute_id) {
                                    array_push($attribute_requests, $attribute_id);
                                }
                            }



                            foreach($attributes as $key => $attribute) {

                                foreach($getProductAttributes as $val) {
                                    if (in_array($val->get('attribute_id'), $attribute_requests)) {
                                        $key = array_search($val->get('attribute_id'), $attribute);
                                        if ($key >= 0) {
                                            unset($attribute[$key]);
                                        }
                                    } else {
                                        $this->Products->ProductAttributes->delete($val);
                                    }
                                }

                                foreach($attribute as $attribute_id) {
                                    $parent = $this->Attributes->find('path', ['for' => $attribute_id])->first();

                                    $productAttributeEntity = $this->Products->ProductAttributes->newEntity([
                                        'product_id' => $productEntity->get('id'),
                                        'attribute_name_id' => $parent->get('id')
                                    ]);

                                    $this
                                        ->Products
                                        ->ProductAttributes
                                        ->patchEntity($productAttributeEntity, ['attribute_id' => $attribute_id], ['validate' => false]);

                                    $this
                                        ->Products
                                        ->ProductAttributes
                                        ->save($productAttributeEntity);


                                }
                            }
                        }

                        //save product to couriers
                        if ($couriers = $this->request->getData('ProductToCourriers')) {
                            /**
                             * @var \AdminPanel\Model\Entity\ProductToCourrier[] $getCourriers
                             */
                            $getCourriers = $this->Products->ProductToCourriers->find()
                                ->where([
                                    'product_id' => $productEntity->get('id')
                                ]);

                            //remove exists if not in request
                            foreach($getCourriers as $courier) {
                                if (!in_array($courier->get('courrier_id'), $couriers)) {
                                    $this->Products->ProductToCourriers->delete($courier);
                                } else {
                                    $key = array_search($courier->get('courrier_id'), $couriers);
                                    if ($key >= 0) {
                                        unset($couriers[$key]);
                                    }
                                }
                            }

                            //insert new request
                            foreach($couriers as $val) {
                                $courierEntity = $this->Products->ProductToCourriers->newEntity(['product_id' => $productEntity->get('id')]);
                                $this->Products->ProductToCourriers->patchEntity($courierEntity, ['courrier_id' => $val]);
                                $this->Products->ProductToCourriers->save($courierEntity);
                            }
                        }


                        if ($option_prices = $this->request->getData('ProductOptionPrices')) {
                            $idx = 1;
                            foreach($option_prices as $key => $price) {

                                $price['idx'] = $idx;
                                $getOptionPrice = $this
                                    ->Products
                                    ->ProductOptionPrices
                                    ->find()
                                    ->where([
                                        'product_id' => $productEntity->get('id'),
                                        'idx' => $idx
                                    ])
                                    ->first();

                                $OptionPriceEntity = !empty($getOptionPrice) ? $getOptionPrice : $this
                                    ->Products
                                    ->ProductOptionPrices
                                    ->newEntity(['product_id' => $productEntity->get('id')]);

                                $this
                                    ->Products
                                    ->ProductOptionPrices
                                    ->patchEntity($OptionPriceEntity, $price);

                                $saveOptionPrice = $this
                                    ->Products
                                    ->ProductOptionPrices
                                    ->save($OptionPriceEntity);

                                if ($saveOptionPrice) {
                                    if ($option_stocks = $this->request->getData('ProductOptionStocks')) {
                                        foreach($option_stocks as $k => $stock) {
                                            if (isset($stock['branches'])) {
                                                foreach($stock['branches'] as $branch) {

                                                    $stock['branch_id'] = $branch['branch_id'];
                                                    $stock['stock'] = $branch['stock'];

                                                    $getOptionStock = $this
                                                        ->Products
                                                        ->ProductOptionStocks
                                                        ->find()
                                                        ->where([
                                                            'product_id' => $productEntity->get('id'),
                                                            'product_option_price_id' => $OptionPriceEntity->get('id'),
                                                            'branch_id' => $stock['branch_id']
                                                        ])
                                                        ->first();


                                                    $OptionStockEntity = !empty($getOptionStock) ? $getOptionStock : $this
                                                        ->Products
                                                        ->ProductOptionStocks
                                                        ->newEntity([
                                                            'product_id' => $productEntity->get('id'),
                                                            'product_option_price_id' => $OptionPriceEntity->get('id')
                                                        ]);

                                                    $this
                                                        ->Products
                                                        ->ProductOptionStocks
                                                        ->patchEntity($OptionStockEntity, $stock, ['validate' => false]);

                                                    $this
                                                        ->Products
                                                        ->ProductOptionStocks
                                                        ->save($OptionStockEntity);
                                                }
                                            }

                                        }
                                    }

                                    if ($option_value_lists = $this->request->getData('ProductOptionValueLists')) {
                                        foreach($option_value_lists as $k => $lists) {

                                            foreach($lists as $option_id => $option_value_id) {

                                                $getValueList = $this
                                                    ->ProductOptionValueLists
                                                    ->find()
                                                    ->where([
                                                        'product_option_price_id' => $OptionPriceEntity->get('id'),
                                                        'option_id' => $option_id
                                                    ])
                                                    ->first();

                                                $OptionValueListEntity = !empty($getValueList) ? $getValueList : $this
                                                    ->ProductOptionValueLists
                                                    ->newEntity([
                                                        'product_option_price_id' => $OptionPriceEntity->get('id'),
                                                        'option_id' => $option_id
                                                    ]);

                                                $this
                                                    ->ProductOptionValueLists
                                                    ->patchEntity($OptionValueListEntity, ['option_value_id' => $option_value_id]);

                                                $this
                                                    ->ProductOptionValueLists
                                                    ->save($OptionValueListEntity);


                                            }

                                        }
                                    }
                                }

                                $idx++;
                            }
                        }



                    }

                    //debug($productEntity->getErrors());
                }

                break;

            case '3':

                $validator = new Validator();

                $error = $validator->errors($this->request->getData());
                if (empty($error)) {

                    $productEntity = $this->Products->find()
                        ->where([
                            'Products.id' => $this->request->getData('id')
                        ])
                        ->first();
                    if ($productEntity) {
                        $this->Products->patchEntity($productEntity, $this->request->getData(), ['validate' => false]);
                        if ($this->Products->save($productEntity)) {
                            $this->Products->ProductImages->updateAll(['primary' => 0], ['product_id' => $productEntity->get('id')]);
                            $primaryImage = $this->request->getData('ProductImages');
                            $productImageEntity = $this->Products->ProductImages->find()
                                ->where([
                                    'id' => $primaryImage['primary']
                                ])
                                ->first();
                            if ($productImageEntity) {
                                $this->Products->ProductImages->patchEntity($productImageEntity, ['primary' => 1]);
                                $this->Products->ProductImages->save($productImageEntity);
                            }
                            $this->Flash->success(__('The product has been saved.'));
                        }
                    }

                }
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
                $out['data'] = [
                    'original_name' => $file['name'],
                    'name' => $entity->get('name'),
                    'image_id' => $entity->get('id')
                ];
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


    public function addBrands(){
        $this->disableAutoRender();
        $validator = new Validator();
        $validator
            ->notBlank('name', 'tidak boleh kosong');
        $error = $validator->errors($this->request->getData());
        if(empty($error)){
            $cat = $this->request->getData('code_cat');
            $name = $this->request->getData('name');

            $getBrands = $this->Brands->find()
                ->where(['Brands.product_category_id' => $cat, 'Brands.name' => $name ])
                ->first();


            if(empty($getBrands)){
                $newEntity = $this->Brands->newEntity();
                $newEntity = $this->Brands->patchEntity($newEntity,$this->request->getData());
                $newEntity->set('product_category_id', $cat);
                $newEntity->set('name', $name);

                if($this->Brands->save($newEntity)){
                    $data = ['id' => $newEntity->get('id'), 'name' => $name];
                    $respon = ['is_error' => false, 'message' => 'Brands berhasil didaftarkan', 'data' => $data];
                }else{
                    $respon = ['is_error' => true, 'message' => 'Gagal menyimpan data / pilihan sudah terdaftar'];
                }
            }else{
                $respon = ['is_error' => true, 'message' => 'Brand telah terdaftar'];
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
        if ($this->request->is('ajax')) {
            $response = [];
            switch ($this->request->getData('action')) {
                case 'getSku':
                    /**
                     * @var \AdminPanel\Model\Entity\ProductToCategory $getCategory
                     */
                    $getCategory = $this->Products->ProductToCategories->find()
                        ->select(['product_category_id'])
                        ->where(['product_id' => $this->request->getData('product_id')])
                        ->first();
                    $response['data'] = $this->generateSku($getCategory->get('product_category_id'), $this->request->getData('brand_id'));
                    break;
            }
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($response));
        }
        else if ($this->request->is('post')) {
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

        $product_tags = $this->Tags->find('list')->toArray();
        $product_warranties = $this->ProductWarranties->find('list')->toArray();

        $this->set(compact('product', 'productStockStatuses', 'productWeightClasses', 'productStatuses','courriers','options', 'parent_categories', 'product_tags','product_warranties'));
    }


    public function getAttributeAndBrand(){
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $listAttribute = $this->Attributes->find('threaded')
                ->where(['Attributes.product_category_id' => $this->request->getData('categories.0')])
                ->toArray();
            $listBrands = $this->Brands->find('list')
                ->where(['Brands.product_category_id' => $this->request->getData('categories.0')])
                ->toArray();
            $listdata = ['attribute' => $listAttribute,'brand' => $listBrands,];
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($listdata));
        }
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
        $courriers = $this->Courriers->find('list')->toArray();
        $options = $this->Options->find('list')->toArray();

        $parent_categories = $this->ProductCategories->find('list')
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->isNull('parent_id');
            })->toArray();
        //debug($parent_categories->toArray());

        $product_tags = $this->Tags->find('list')->toArray();
        $product_warranties = $this->ProductWarranties->find('list')->toArray();

        $this->set(compact('product', 'productStockStatuses', 'productWeightClasses', 'productStatuses','courriers','options', 'parent_categories', 'product_tags','product_warranties'));
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
