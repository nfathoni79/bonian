<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use AdminPanel\Model\Entity\Product;
use Cake\Core\Configure;
use Cake\Validation\Validator;
use Cake\Utility\Hash;
use function GuzzleHttp\Psr7\str;
use phpDocumentor\Reflection\Types\Integer;

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
 * @property \AdminPanel\Model\Table\BrandsTable $Brands
 * @property \AdminPanel\Model\Table\CategoryToBrandsTable $CategoryToBrands
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
        $this->loadModel('AdminPanel.Courriers');
        $this->loadModel('AdminPanel.ProductOptionValueLists');
        $this->loadModel('AdminPanel.Tags');
        $this->loadModel('AdminPanel.ProductWarranties');
        $this->loadModel('AdminPanel.Attributes');
        $this->loadModel('AdminPanel.Brands');
        $this->loadModel('AdminPanel.CategoryToBrands');

        $this->allowedFileType = [
            'image/jpg',
            'image/png',
            'image/jpeg'
        ];

    }

    function slug($str){
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        return $str;
    }


    public function import(){
        Configure::write('debug', 0);
        set_time_limit(600);
        if ($this->request->is('post')) {


            $this->Products->getConnection()->begin();

            $data = $this->request->getData('files');
            $file = $data['tmp_name'];
            $handle = fopen($file, "r");
            $count = 0;
            $success = true;
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $count++;
                if ($count == 1) {
                    continue;
                }
//				 debug($row);
//				exit;

                $categoryId = $this->ProductCategories->getIdByName($row[0]);

                if(empty($categoryId)){
                    $this->Flash->error(__('Terjadi kesalahan penginputan pada baris ke '. $count.',  kategori tidak ditemukan.'));
                    return $this->redirect(['action' => 'index']);
                    break;
                }
                if(count($row) != 25){
                    $this->Flash->error(__('Terjadi kesalahan penginputan pada baris ke '. $count.',  panjang format tidak sama.'));
                    return $this->redirect(['action' => 'index']);
                    break;
                }

                $data = [];
                $data['name'] = $row[1];
                $data['ProductMetaTags']['keyword'] = $row[2] ? $row[2] : '';
                $data['ProductMetaTags']['description'] = $row[3];
                $data['ProductToAttributes'] = [];

                $material = array_filter(array_map('trim',explode('|', $row[4])));
                foreach($material as $vals){
                    $data['ProductToAttributes'][] = $this->Attributes->getId($vals,$categoryId);
                }

                $data['brand_id'] = $this->Brands->getId(trim($row[5]),$categoryId);
                $data['model'] = trim($row[6]);
                $data['sku'] = $this->generateSku($categoryId, $data['brand_id']);

                $data['slug'] = $this->slug($row[1]);
                $stockStatus = ['INSTOCK' => 1, 'OUTOFFSTOCK' => 2];
                $data['product_stock_status_id'] = $stockStatus[trim($row[8])];
                $data['barcode'] = trim($row[9]);
                $data['price'] =  preg_replace('/[,.]/', '', trim($row[10]));
                $data['price_sale'] =  preg_replace('/[,.]/', '', trim($row[11]));
                $data['point'] =  preg_replace('/[,.]/', '', trim($row[12]));
                $data['supplier_code'] =  trim($row[13]);
                $data['ProductTags'] = [];

                $tags = array_filter(array_map('trim',explode(',', $row[14])));
                foreach($tags as $value){
                    $data['ProductTags'][] =  $this->Tags->getName($value);
                }

                $data['ProductToCourriers'] = [];
                $courier = array_filter(array_map('trim',explode(',', $row[15])));
                foreach($courier as $values){
                    $data['ProductToCourriers'][] = $this->Courriers->getId($values);
                }

                $data['type'] = strtolower(trim($row[16]));
                $data['video_url'] = trim($row[17]);
                $data['highlight'] = trim($row[18]);
                $data['highlight_text'] = strip_tags(trim($row[18]));
                $data['profile'] = trim($row[19]);

                $data['ProductOptionValueLists'] = [];
                $option = array_filter(array_map('trim',explode('|', $row[20])));
                $i = 1;
                foreach($option as $vals){
                    $data['ProductOptionValueLists'][$i] = $this->OptionValues->getId($vals);
                    $i++;
                }

                $optionPrice = array_filter(array_map('trim',explode('|', $row[21])));
                $data['ProductOptionPrices'] = [];
                for($i=0;$i<=count($option) -1;$i++){
                    $prices = preg_replace('/[,.]/', '', trim(@$optionPrice[$i]));
                    $data['ProductOptionPrices'][($i+1)]['expired'] = null;
                    $data['ProductOptionPrices'][($i+1)]['sku'] = $data['sku'].sprintf("%02d", ($i+1));
                    $data['ProductOptionPrices'][($i+1)]['price'] = $prices ? $prices : 0;
                }


                $weight = array_filter(array_map('trim',explode(':', $row[23])));

                $data['ProductOptionStocks'] = [];
                for($i=0;$i<=count($option) -1;$i++){
                    if($weight[0] = 'weight'){
                        $data['ProductOptionStocks'][($i+1)]['weight'] = $weight[1];
                        $data['ProductOptionStocks'][($i+1)]['length'] = '';
                        $data['ProductOptionStocks'][($i+1)]['width'] = '';
                        $data['ProductOptionStocks'][($i+1)]['height'] = '';
                    }else{
                        /* DEMENSION */
                        $demesion = array_filter(array_map('trim',explode('x', $weight[1])));
                        $data['ProductOptionStocks'][($i+1)]['weight'] = '';
                        $data['ProductOptionStocks'][($i+1)]['length'] = $demesion[0];
                        $data['ProductOptionStocks'][($i+1)]['width'] =  $demesion[1];
                        $data['ProductOptionStocks'][($i+1)]['height'] =  $demesion[2];
                    }
                }

                $branch = [];
                $branches = array_filter(array_map('trim',explode('|', $row[22])));
                $cityName = [];

                $branch_names = [];
                foreach($branches as $k => $vals){
                    $getBranch = array_map('trim',explode(':', $vals));
                    $supply = array_map('trim',explode(',', $getBranch[1]));
                    $cityName[] = $getBranch[0];

                    $branch_id = $this->Branches->getId($getBranch[0]);
                    $branch_names[$branch_id] = $supply;

                    foreach($supply as $ky => $val){
                        $branch[$k][$ky]['stock'] = $val;

                    }

                }




                foreach($data['ProductOptionStocks'] as $key_stock => $stock) {
                    foreach($branch_names as  $branch_id => $val){
                        $data['ProductOptionStocks'][$key_stock]['branches'][] = [
                            'stock' => array_shift($branch_names[$branch_id]),
                            'branch_id' => $branch_id
                        ];
                    }
                }




                $data['ProductImages'] = array_filter(array_map('trim',explode(',', $row[24])));

                foreach($data['ProductImages'] as $vals){
                    if($vals){
                        $format = explode('.',$vals);
                        if(strtolower(end($format)) == 'webp'){
                            $this->Flash->error(__('Terjadi kesalahan penginputan pada baris ke '. $count.',  Format gambar tidak sesuai.'));
                            return $this->redirect(['action' => 'index']);
                            break;
                        }

                        if(!@file_get_contents($vals)){
                            $this->Flash->error(__('Terjadi kesalahan penginputan pada baris ke '. $count.',  data gagal di download '.$vals));
                            return $this->redirect(['action' => 'index']);
                            break;
                        }

                    }
                }

                /* END DATA */

                $validator = new Validator();

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
                    ->requirePresence('type')
                    ->notBlank('type', 'tidak boleh kosong');

                $validator
                    ->requirePresence('ProductToCourriers')
                    ->hasAtLeast('ProductToCourriers', 1, __d('AdminPanel', __d('AdminPanel','pilihan minimal 1 kurir')));

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

                $productPrice
                    ->requirePresence('sku')
                    ->notBlank('sku', 'tidak boleh kosong');

                $productSize = new Validator();
                $validator->addNestedMany('ProductOptionPrices', $productPrice);
                foreach($data['ProductOptionStocks'] as $vals){
                    if(!empty($vals['weight'])){
                        $productSize
                            ->notBlank('weight');
                    }else{
                        $productSize
                            ->notBlank('length');
                        $productSize
                            ->notBlank('width');
                        $productSize
                            ->notBlank('height');
                    }
                }


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

                $error = $validator->errors($data);


                if (empty($error)) {


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

                    $this->Products->save($productEntity);


                    foreach($data['ProductImages'] as $vals){

                        $tmpfname = tempnam(sys_get_temp_dir(), "FOO");

                        //$handle = fopen($tmpfname, "w+");
                        //fwrite($handle, file_get_contents($vals));
                        //fclose($handle);
                        file_put_contents($tmpfname, file_get_contents($vals));


                        $img = get_headers($vals, 1);
                        $size = getimagesize($vals);
                        $saveImage['product_id'] = $productEntity->get('id'); // replace nanti
                        $saveImage['idx'] = 0;
                        $saveImage['name']['tmp_name'] = $tmpfname;
                        $saveImage['name']['error'] = 0;
                        $saveImage['name']['name'] = 'sembarang.jpg';
                        $saveImage['name']['type'] = $size['mime'];
                        $saveImage['name']['size'] = intval($img["Content-Length"]);


                        $entityImage = $this->ProductImageSizes->ProductImages->newEntity();
                        $this->ProductImageSizes->ProductImages->patchEntity($entityImage, $saveImage);
                        $this->ProductImageSizes->ProductImages->save($entityImage);
                        unlink($tmpfname);
                    }

                    $getProductToCategory = null;
                    $getProductToCategory = $this->ProductToCategories->find()
                        ->where([
                            'ProductToCategories.product_id' => $productEntity->get('id')
                        ])
                        ->first();

                    $productToCategoryEntity = $this->ProductToCategories->newEntity();
                    $productToCategoryEntity = !empty($getProductToCategory) ? $getProductToCategory :  $productToCategoryEntity;

                    $this->ProductToCategories->patchEntity($productToCategoryEntity, [
                        'product_id' => $productEntity->get('id'),
                        'product_category_id' => $categoryId
                    ]);

                    $this->ProductToCategories->save($productToCategoryEntity);


                    $getData = $data;

                    foreach(['price', 'price_sale', 'point'] as $val) {
                        $getData[$val] = preg_replace('/[,.]/', '', $getData[$val]);
                    }

                    $getData['highlight_text'] = strip_tags($getData['highlight']);
                    $getData['slug'] = $getData['slug'].'-'.$getData['sku'];

                    $this->Products->patchEntity($productEntity, $getData, ['validate' => false]);

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
                            ->patchEntity($metaTagEntity, $getData['ProductMetaTags']);

                        $this
                            ->Products
                            ->ProductMetaTags
                            ->save($metaTagEntity);

                        //product tags
                        if ($product_tags = $data['ProductTags']) {
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
                        if ($attributes = $getData['ProductToAttributes']) {

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
                                        foreach($attribute as $a => $v) {
                                            if ($val->get('attribute_id') == $v) {
                                                unset($attribute[$a]);
                                            }
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
                        if ($couriers = $getData['ProductToCourriers']) {
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


                        if ($option_prices = $getData['ProductOptionPrices']) {
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

                                if (!$saveOptionPrice) {
                                    $response['error']['ProductOptionPrices'][$key] = $OptionPriceEntity->getErrors();
                                    //debug($response);exit;
                                    //debug($option_prices);exit;
                                    //debug($OptionPriceEntity->getErrors());
                                    //exit;
                                }

                                $idx++;
                            }

                            /**
                             * @var \AdminPanel\Model\Entity\ProductOptionPrice[] $getOptionPriceEntity
                             */
                            $getOptionPriceEntity = $this
                                ->Products
                                ->ProductOptionPrices
                                ->find()
                                ->where([
                                    'product_id' => $productEntity->get('id'),
                                ]);

                            /**
                             * @var \AdminPanel\Model\Entity\ProductOptionPrice[] $OptionPriceEntity
                             */
                            $OptionPriceEntity = [];
                            foreach($getOptionPriceEntity as $val) {
                                $OptionPriceEntity[$val->get('idx')] = $val;
                            }
                            unset($getOptionPriceEntity);



                            if ($option_value_lists = $getData['ProductOptionValueLists']) {
                                $idx = 1;
                                foreach($option_value_lists as $k => $lists) {

                                    foreach($lists as $option_id => $option_value_id) {
                                        if (!isset($OptionPriceEntity[$idx])) continue;
                                        $getValueList = $this
                                            ->ProductOptionValueLists
                                            ->find()
                                            ->where([
                                                'product_option_price_id' => $OptionPriceEntity[$idx]->get('id'),
                                                'option_id' => $option_id
                                            ])
                                            ->first();

                                        $OptionValueListEntity = !empty($getValueList) ? $getValueList : $this
                                            ->ProductOptionValueLists
                                            ->newEntity([
                                                'product_option_price_id' => $OptionPriceEntity[$idx]->get('id'),
                                                'option_id' => $option_id
                                            ]);

                                        $this
                                            ->ProductOptionValueLists
                                            ->patchEntity($OptionValueListEntity, ['option_value_id' => $option_value_id]);

                                        $this
                                            ->ProductOptionValueLists
                                            ->save($OptionValueListEntity);


                                    }
                                    $idx++;
                                }
                            }

                            if ($option_stocks = $getData['ProductOptionStocks']) {
                                $idx = 1;
                                foreach($option_stocks as $key => $stock) {

                                    if (isset($stock['branches'])) {
                                        foreach($stock['branches'] as $i => $branch) {
                                            if (!isset($OptionPriceEntity[$idx])) continue;
                                            $stock['branch_id'] = $branch['branch_id'];
                                            $stock['stock'] = $branch['stock'];

                                            $getOptionStock = $this
                                                ->Products
                                                ->ProductOptionStocks
                                                ->find()
                                                ->where([
                                                    'product_id' => $productEntity->get('id'),
                                                    'product_option_price_id' => $OptionPriceEntity[$idx]->get('id'),
                                                    'branch_id' => $stock['branch_id']
                                                ])
                                                ->first();


                                            $OptionStockEntity = !empty($getOptionStock) ? $getOptionStock : $this
                                                ->Products
                                                ->ProductOptionStocks
                                                ->newEntity([
                                                    'product_id' => $productEntity->get('id'),
                                                    'product_option_price_id' => $OptionPriceEntity[$idx]->get('id')
                                                ]);


                                            $this
                                                ->Products
                                                ->ProductOptionStocks
                                                ->patchEntity($OptionStockEntity, $stock, ['validate' => true]);


                                            $saveStock = $this
                                                ->Products
                                                ->ProductOptionStocks
                                                ->save($OptionStockEntity);

                                            if (!$saveStock) {
                                                $response['error']['ProductOptionStocks'][$key]['branches'][$i] = $OptionStockEntity->getErrors();
                                            }
                                        }
                                    }
                                    $idx++;
                                }
                            }
                        }

                        $getStocks = $this->Products->ProductOptionStocks->find()
                            ->where([
                                'product_id' => $productEntity->get('id')
                            ]);
                        foreach($getStocks as $stock) {
                            $productStockEntity = $this
                                ->Products
                                ->ProductStockMutations
                                ->newEntity([
                                    'product_id' => $productEntity->get('id'),
                                    'branch_id' => $stock->get('branch_id'),
                                    'product_option_stock_id' => $stock->get('id'),
                                    'product_stock_mutation_type_id' => 1, //TODO
                                    'description' => 'initial stock',
                                    'amount' => $stock->get('stock'),
                                    'balance' => $stock->get('stock'),
                                ]);
                            $this
                                ->Products
                                ->ProductStockMutations
                                ->save($productStockEntity);
                        }



                    }

                }else{
                    $success = false;
                    $this->Flash->error(__('Failed error on row product name : '.$row[1]));
//                    debug($error);
					foreach($error as $field => $value){
						$newError = $field .' Tidak boleh kosong atau format tidak sah atau tidak terdaftar';
//						foreach($value as $val){
//							if(is_array($val)){
//							    foreach($val as $vals){
//                                    $newError .= ' '.$vals;
//                                }
//                            }else{
//                                $newError .= ' '.$val;
//                            }
//						}
						$this->Flash->error($newError);
					}
					
                    break;
                }

            }
            if($success){
                $this->Products->getConnection()->commit();
                $this->Flash->success(__('The product price has been save.'));
            }else{
                $this->Products->getConnection()->rollback();
            }
            $this->redirect(['action' => 'index']);
        }

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
            $data->where(['Products.sku != ' => 'NULL']);

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
                    ->requirePresence('type')
                    ->notBlank('type', 'tidak boleh kosong');

                $validator
                    ->requirePresence('ProductToCourriers')
                    ->hasAtLeast('ProductToCourriers', 1, __d('AdminPanel', __d('AdminPanel','pilihan minimal 1 kurir')));

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

                $productPrice
                    ->requirePresence('sku')
                    ->notBlank('sku', 'tidak boleh kosong');

                $productSize = new Validator();
                $validator->addNestedMany('ProductOptionPrices', $productPrice);
				foreach($this->request->getData('ProductOptionStocks') as $vals){
					if(!empty($vals['weight'])){ 
						$productSize
							->notBlank('weight');
					}else{ 
						$productSize
							->notBlank('length');
						$productSize
							->notBlank('width');
						$productSize
							->notBlank('height');
					} 
				} 


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

                    $getData = $this->request->getData();

                    foreach(['price', 'price_sale', 'point'] as $val) {
                        $getData[$val] = preg_replace('/[,.]/', '', $getData[$val]);
                    }

                    $getData['highlight_text'] = strip_tags($getData['highlight']);
                    $getData['slug'] = $getData['slug'].'-'.$getData['sku'];

                    $this->Products->patchEntity($productEntity, $getData, ['validate' => false]);

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
                                ->newEntity([
                                    'product_id' => $productEntity->get('id'),
                                    'keyword' =>$this->request->getData('ProductMetaTags.keyword'),
                                    'description' =>$this->request->getData('ProductMetaTags.description')
                                ]);

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
                                        foreach($attribute as $a => $v) {
                                            if ($val->get('attribute_id') == $v) {
                                                unset($attribute[$a]);
                                            }
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

                                if (!$saveOptionPrice) {
                                    $response['error']['ProductOptionPrices'][$key] = $OptionPriceEntity->getErrors();
                                    //debug($response);exit;
                                    //debug($option_prices);exit;
                                    //debug($OptionPriceEntity->getErrors());
                                    //exit;
                                }

                                $idx++;
                            }

                            /**
                             * @var \AdminPanel\Model\Entity\ProductOptionPrice[] $getOptionPriceEntity
                             */
                            $getOptionPriceEntity = $this
                                ->Products
                                ->ProductOptionPrices
                                ->find()
                                ->where([
                                    'product_id' => $productEntity->get('id'),
                                ]);

                            /**
                             * @var \AdminPanel\Model\Entity\ProductOptionPrice[] $OptionPriceEntity
                             */
                            $OptionPriceEntity = [];
                            foreach($getOptionPriceEntity as $val) {
                                $OptionPriceEntity[$val->get('idx')] = $val;
                            }
                            unset($getOptionPriceEntity);



                            if ($option_value_lists = $this->request->getData('ProductOptionValueLists')) {
                                $idx = 1;
                                foreach($option_value_lists as $k => $lists) {

                                    foreach($lists as $option_id => $option_value_id) {
                                        if (!isset($OptionPriceEntity[$idx])) continue;
                                        $getValueList = $this
                                            ->ProductOptionValueLists
                                            ->find()
                                            ->where([
                                                'product_option_price_id' => $OptionPriceEntity[$idx]->get('id'),
                                                'option_id' => $option_id
                                            ])
                                            ->first();

                                        $OptionValueListEntity = !empty($getValueList) ? $getValueList : $this
                                            ->ProductOptionValueLists
                                            ->newEntity([
                                                'product_option_price_id' => $OptionPriceEntity[$idx]->get('id'),
                                                'option_id' => $option_id
                                            ]);

                                        $this
                                            ->ProductOptionValueLists
                                            ->patchEntity($OptionValueListEntity, ['option_value_id' => $option_value_id]);

                                        $this
                                            ->ProductOptionValueLists
                                            ->save($OptionValueListEntity);


                                    }
                                    $idx++;
                                }
                            }

                            if ($option_stocks = $this->request->getData('ProductOptionStocks')) {
                                $idx = 1;
                                foreach($option_stocks as $key => $stock) {

                                    if (isset($stock['branches'])) {
                                        foreach($stock['branches'] as $i => $branch) {
                                            if (!isset($OptionPriceEntity[$idx])) continue;
                                            $stock['branch_id'] = $branch['branch_id'];
                                            $stock['stock'] = $branch['stock'];

                                            $getOptionStock = $this
                                                ->Products
                                                ->ProductOptionStocks
                                                ->find()
                                                ->where([
                                                    'product_id' => $productEntity->get('id'),
                                                    'product_option_price_id' => $OptionPriceEntity[$idx]->get('id'),
                                                    'branch_id' => $stock['branch_id']
                                                ])
                                                ->first();


                                            $OptionStockEntity = !empty($getOptionStock) ? $getOptionStock : $this
                                                ->Products
                                                ->ProductOptionStocks
                                                ->newEntity([
                                                    'product_id' => $productEntity->get('id'),
                                                    'product_option_price_id' => $OptionPriceEntity[$idx]->get('id')
                                                ]);


                                            $this
                                                ->Products
                                                ->ProductOptionStocks
                                                ->patchEntity($OptionStockEntity, $stock, ['validate' => true]);


                                            $saveStock = $this
                                                ->Products
                                                ->ProductOptionStocks
                                                ->save($OptionStockEntity);

                                            if (!$saveStock) {
                                                $response['error']['ProductOptionStocks'][$key]['branches'][$i] = $OptionStockEntity->getErrors();
                                            }
                                        }
                                    }
                                    $idx++;
                                }
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

                            //processing and insert stock
                            /**
                             * @var \AdminPanel\Model\Entity\ProductOptionStock[] $getStocks
                             */
                            $getStocks = $this->Products->ProductOptionStocks->find()
                                ->where([
                                    'product_id' => $productEntity->get('id')
                                ]);
                            foreach($getStocks as $stock) {
                                $productStockEntity = $this
                                    ->Products
                                    ->ProductStockMutations
                                    ->newEntity([
                                        'product_id' => $productEntity->get('id'),
                                        'branch_id' => $stock->get('branch_id'),
                                        'product_option_stock_id' => $stock->get('id'),
                                        'product_stock_mutation_type_id' => 1, //TODO
                                        'description' => 'initial stock',
                                        'amount' => $stock->get('stock'),
                                        'balance' => $stock->get('stock'),
                                    ]);
                                $this
                                    ->Products
                                    ->ProductStockMutations
                                    ->save($productStockEntity);
                            }


                            $this->Flash->success(__('The product has been saved.'));
                        }
                    }

                }
                break;

        }

        //global response error
        $response['error'] = !isset($response['error']) ? $validator->errors($this->request->getData()) : $response['error'];
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

            $size = getimagesize($file['tmp_name']);

            $width = $size[0];
            $height = $size[1];

            $min_image_size = [
                'width' => 500,
                'height' => 500
            ];

            if ($width < $min_image_size['width'] && $height < $min_image_size['height']) {
                $out['error'] = __d('AdminPanel', sprintf('minimal width %s dan height %s', $min_image_size['width'], $min_image_size['height']));
                $Response = $Response->withStatus('401');
                return $Response
                    ->withStringBody(json_encode($out));
            }

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

            /*
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
            }*/

            $getBrands = $this->Brands->find()
                ->where(['Brands.product_category_id' => $cat, 'Brands.name' => $name ])
                ->first();

            if ($getBrands) {
                $categoryBrands = $this->CategoryToBrands->find()
                    ->where([
                        'product_category_id' => $cat,
                        'brand_id' => $getBrands->get('id')
                    ])
                    ->first();
                if (!$categoryBrands) {
                    $CategoryToBrandsEntity = $this->CategoryToBrands->newEntity([
                        'product_category_id' => $cat,
                        'brand_id' => $getBrands->get('id'),
                    ]);
                    if ($this->CategoryToBrands->save($CategoryToBrandsEntity)) {
                        $data = ['id' => $CategoryToBrandsEntity->get('brand_id'), 'name' => $name];
                        $respon = ['is_error' => false, 'message' => 'Brands berhasil didaftarkan', 'data' => $data];
                    }
                }

            } else {
                $newEntity = $this->Brands->newEntity([
                    'name' => $this->request->getData('name')
                ]);

                if($this->Brands->save($newEntity)) {
                    $CategoryToBrandsEntity = $this->CategoryToBrands->newEntity([
                        'product_category_id' => $cat,
                        'brand_id' => $newEntity->get('id'),
                    ]);
                    if ($this->CategoryToBrands->save($CategoryToBrandsEntity)) {
                        $data = ['id' => $newEntity->get('id'), 'name' => $name];
                        $respon = ['is_error' => false, 'message' => 'Brands berhasil didaftarkan', 'data' => $data];
                    } else {
                        $respon = ['is_error' => true, 'message' => 'Gagal menyimpan data / pilihan sudah terdaftar'];
                    }

                }else{
                    $respon = ['is_error' => true, 'message' => 'Gagal menyimpan data / pilihan sudah terdaftar'];
                }
            }





        }else{
            $respon = ['is_error' => true, 'message' => 'Gagal menyimpan data'];
        }
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($respon));
    }

    public function preview($id, $type = null){
        $this->viewBuilder()->setLayout('AdminPanel.blank');

        $product = $this->Products->find()
            ->contain([
                'ProductToCategories' => [
                    'ProductCategories'
                ],
                'ProductMetaTags',
                'Brands',
                'ProductTags' => [
                    'Tags'
                ],
                'ProductToCourriers' => [
                    'Courriers'
                ],
                'ProductWarranties',
                'ProductStockStatuses',
                'ProductStatuses',
                'ProductImages',
                'ProductAttributes' => [
                    'Attributes'
                ],
                'ProductOptionPrices' => [
                    'ProductOptionValueLists' => [
                        'Options',
                        'OptionValues',
                    ],
                    'ProductOptionStocks' => [
                        'Branches'
                    ]

                ],
            ])
            ->where(['Products.id' => $id])
            ->map(function (\AdminPanel\Model\Entity\Product $row){
                $row->keyword = @$row->product_meta_tags[0]->keyword;
                $row->description = @$row->product_meta_tags[0]->description;
                $row->category = $row->product_to_categories[0]->product_category->name;
                $row->brand = $row->brand->name;
                $tags = [];
                foreach($row->product_tags as $k => $vals){
                    $tags[$k] = $vals->tag->name;
                }
                $row->tags = $tags;
                $couriers = [];
                foreach($row->product_to_courriers as $k => $vals){
                    $couriers[$k] = $vals->courrier->name;
                }
                $row->couriers = $couriers;
                $row->warranty = $row->product_warranty->name;
                $row->stock_status = $row->product_stock_status->name;
                $row->status = $row->product_status->name;
                $main = [];
                foreach($row->product_images as $k => $vals){
                    $main[$vals['idx']][] =  $vals['name'];
                }
                $row->main_image = $main[0];
                foreach($row->product_option_prices as  $k=> $vals){
                    $row->product_option_prices[$k]->image = $main[$vals['idx']];
                }
                $listAttribute = [];
                foreach($row->product_attributes as $k => $vals){
                    $listAttribute[$this->Attributes->getName($vals['attribute_name_id'])][] = $vals['attribute']['name'];
                }
                $row->attributes = $listAttribute;


                unset($row->product_attributes);
                unset($row->product_images);
                unset($row->product_status);
                unset($row->product_stock_status);
                unset($row->product_warranty);
                unset($row->product_to_courriers);
                unset($row->product_tags);
                unset($row->product_meta_tags);
                unset($row->product_to_categories);
                return $row;
            })
            ->first()
            ->toArray();
        $this->set(compact('product'));

        if($type == 1){
            $this->render('preview');
        }else{
            $this->render('preview_bottom');
        }
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
                case 'removeImage':
                    try {
                        $productImageEntity = $this->Products->ProductImages->get($this->request->getData('image_id'));
                        $response['data'] = $this->Products->ProductImages->delete($productImageEntity);
                    } catch(\Exception $e) {}


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


        $lastId = ($this->Products->find()->select('id')->last() == null) ? 0 : ($this->Products->find()->select('id')->last()->id );

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

        $this->set(compact('product', 'productStockStatuses', 'productWeightClasses', 'productStatuses','courriers','options', 'parent_categories', 'product_tags','product_warranties','lastId'));
    }


    public function getAttributeAndBrand(){
        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');
            $listAttribute = $this->Attributes->find('threaded')
                ->where(['Attributes.product_category_id' => $this->request->getData('categories.0')])
                ->toArray();
            /*$listBrands = $this->Brands->find('list')
                ->where(['Brands.product_category_id' => $this->request->getData('categories.0')])
                ->toArray();*/

            $listBrands = $this->CategoryToBrands->find('list', [
                'keyField' => 'brand_id',
                'valueField' => function(\AdminPanel\Model\Entity\CategoryToBrand $row) {
                    return $row->get('brand')->name;
                }
            ])->contain([
                'Brands'
            ])
            ->where([
                'CategoryToBrands.product_category_id' => $this->request->getData('categories.0')
            ])
            ->group('brand_id')
            ->toArray();

            $listdata = ['attribute' => $listAttribute,'brand' => $listBrands];
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
            'contain' => [
                'ProductToCourriers',
                'ProductStatuses'
            ]
        ]);

        if ($this->request->is('ajax')) {
            $response = [];
            $validator = new Validator();

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
                //->requirePresence('brand_id')
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
                ->requirePresence('type')
                ->notBlank('type', 'tidak boleh kosong');

            $validator
                ->requirePresence('ProductToCourriers')
                ->hasAtLeast('ProductToCourriers', 1, __d('AdminPanel', __d('AdminPanel','pilihan minimal 1 kurir')));

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

            $productPrice
                ->requirePresence('sku')
                ->notBlank('sku', 'tidak boleh kosong');

            $validator->addNestedMany('ProductOptionPrices', $productPrice);


            $productSize = new Validator();
			
			
			foreach($this->request->getData('ProductOptionStocks') as $vals){
				if(!empty($vals['weight'])){ 
					$productSize
						->notBlank('weight');
				}else{ 
					$productSize
						->notBlank('length');
					$productSize
						->notBlank('width');
					$productSize
						->notBlank('height');
				} 
			}  


            //added nested validation on branches -> 0 -> branch_id
            $branches = new Validator();
            $branches
                //->requirePresence('branch_id')
                ->notBlank('branch_id');
            $branches
                //->requirePresence('stock')
                ->notBlank('stock');

            $productSize->addNestedMany('branches', $branches);

            $validator->addNestedMany('ProductOptionStocks', $productSize);

            $error = $validator->errors($this->request->getData());
			
            if (empty($error)) {
                $getData = $this->request->getData();

                foreach(['price', 'price_sale', 'point'] as $val) {
                    $getData[$val] = preg_replace('/[,.]/', '', $getData[$val]);
                }
				 
				$getData['highlight_text'] = strip_tags($getData['highlight']);
//                $getData['slug'] = $getData['slug'].'-'.$getData['sku'];
                $this->Products->patchEntity($product, $getData, ['validate' => false]);
                if ($this->Products->save($product)) {


                    //processing save ProductMetaTags
                    $getMetaTag = $this->Products->ProductMetaTags->find()
                        ->where([
                            'product_id' => $product->get('id')
                        ])
                        ->first();

                    $metaTagEntity = !empty($getMetaTag) ?
                        $getMetaTag :
                        $this
                            ->Products
                            ->ProductMetaTags
                            ->newEntity(['product_id' => $product->get('id')]);

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
                                'product_id' => $product->get('id')
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
                            $productTagEntity = $this->Products->ProductTags->newEntity(['product_id' => $product->get('id')]);
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
                                'product_id' => $product->get('id')
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
                                    foreach($attribute as $a => $v) {
                                        if ($val->get('attribute_id') == $v) {
                                            unset($attribute[$a]);
                                        }
                                    }
                                } else {
                                    $this->Products->ProductAttributes->delete($val);
                                }
                            }


                            foreach($attribute as $attribute_id) {
                                $parent = $this->Attributes->find('path', ['for' => $attribute_id])->first();

                                $productAttributeEntity = $this->Products->ProductAttributes->newEntity([
                                    'product_id' => $product->get('id'),
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
                    } else {
                        /**
                         * @var \AdminPanel\Model\Entity\ProductAttribute[] $getProductAttributes
                         */
                        $getProductAttributes = $this->Products->ProductAttributes->find()
                            ->where([
                                'product_id' => $product->get('id')
                            ]);
                        foreach($getProductAttributes as $val) {
                            $this->Products->ProductAttributes->delete($val);
                        }
                    }

                    //save product to couriers
                    if ($couriers = $this->request->getData('ProductToCourriers')) {
                        /**
                         * @var \AdminPanel\Model\Entity\ProductToCourrier[] $getCourriers
                         */
                        $getCourriers = $this->Products->ProductToCourriers->find()
                            ->where([
                                'product_id' => $product->get('id')
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
                            $courierEntity = $this->Products->ProductToCourriers->newEntity(['product_id' => $product->get('id')]);
                            $this->Products->ProductToCourriers->patchEntity($courierEntity, ['courrier_id' => $val]);
                            $this->Products->ProductToCourriers->save($courierEntity);
                        }
                    }

                    if ($option_prices = $this->request->getData('ProductOptionPrices')) {
                        // $idx = 1;
 
                        foreach($option_prices as $key => $price) {

                            // $price['idx'] = $idx;
                            $getOptionPrice = $this
                                ->Products
                                ->ProductOptionPrices
                                ->find()
                                ->where([
                                    'id' => $price['id'],
                                    // 'idx' => $idx
                                ])
                                ->first();

                            $OptionPriceEntity = !empty($getOptionPrice) ? $getOptionPrice : $this
                                ->Products
                                ->ProductOptionPrices
                                ->newEntity(['product_id' => $product->get('id')]);

                            $this
                                ->Products
                                ->ProductOptionPrices
                                ->patchEntity($OptionPriceEntity, $price);

                            $saveOptionPrice = $this
                                ->Products
                                ->ProductOptionPrices
                                ->save($OptionPriceEntity);

                            if (!$saveOptionPrice) {
                                $response['error']['ProductOptionPrices'][$key] = $OptionPriceEntity->getErrors();
                                //debug($response);exit;
                                //debug($option_prices);exit;
                                //debug($OptionPriceEntity->getErrors());
                                //exit;
                            }

                            // $idx++;
                        }

                        /**
                         * @var \AdminPanel\Model\Entity\ProductOptionPrice[] $getOptionPriceEntity
                         */
                        $getOptionPriceEntity = $this
                            ->Products
                            ->ProductOptionPrices
                            ->find()
                            ->where([
                                'product_id' => $product->get('id'),
                            ]);

                        /**
                         * @var \AdminPanel\Model\Entity\ProductOptionPrice[] $OptionPriceEntity
                         */
                        $OptionPriceEntity = [];
                        foreach($getOptionPriceEntity as $val) {
                            $OptionPriceEntity[$val->get('idx')] = $val;
                        }
                        unset($getOptionPriceEntity);




                        if ($option_value_lists = $this->request->getData('ProductOptionValueLists')) {
                            $idx = count($OptionPriceEntity); //1;
                            //debug($option_value_lists);exit;
                            foreach($option_value_lists as $k => $lists) {

                                foreach($lists as $option_id => $option_value_id) {
                                    if (!isset($OptionPriceEntity[$idx])) continue;

                                    $getValueList = $this
                                        ->ProductOptionValueLists
                                        ->find()
                                        ->where([
                                            'product_option_price_id' => $OptionPriceEntity[$idx]->get('id'),
                                            'option_id' => $option_id
                                        ])
                                        ->first();


                                    $OptionValueListEntity = !empty($getValueList) ? $getValueList : $this
                                        ->ProductOptionValueLists
                                        ->newEntity([
                                            'product_option_price_id' => $OptionPriceEntity[$idx]->get('id'),
                                            'option_id' => $option_id
                                        ]);

                                    $this
                                        ->ProductOptionValueLists
                                        ->patchEntity($OptionValueListEntity, ['option_value_id' => $option_value_id]);

                                    $this
                                        ->ProductOptionValueLists
                                        ->save($OptionValueListEntity);


                                }
                                $idx++;
                            }
                        }

                        if ($option_stocks = $this->request->getData('ProductOptionStocks')) {
                            $idx = 1;
                            foreach($option_stocks as $key => $stock) {

                                if (isset($stock['branches'])) {
                                    foreach($stock['branches'] as $i => $branch) {
                                        if (!isset($OptionPriceEntity[$idx])) continue;

                                        $getOptionStock = $this
                                            ->Products
                                            ->ProductOptionStocks
                                            ->find();

                                        if (isset($branch['id'])) {
                                            $getOptionStock
                                                ->where([
                                                    'id' => $branch['id']
                                                ]);
                                            $getOptionStock = $getOptionStock->first();
                                        } else {
                                            $stock['branch_id'] = $branch['branch_id'];
                                            $stock['stock'] = $branch['stock'];
                                            /*$getOptionStock
                                                ->where([
                                                    'product_id' => $product->get('id'),
                                                    'product_option_price_id' => $OptionPriceEntity[$idx]->get('id'),
                                                    'branch_id' => $stock['branch_id']
                                                ]);
                                            $getOptionStock = $getOptionStock->first();
                                            */
                                            $getOptionStock = null;
                                        }







                                        $OptionStockEntity = !empty($getOptionStock) ? $getOptionStock : $this
                                            ->Products
                                            ->ProductOptionStocks
                                            ->newEntity([
                                                'product_id' => $product->get('id'),
                                                'product_option_price_id' => $OptionPriceEntity[$idx]->get('id')
                                            ]);

                                        //debug($OptionStockEntity);


                                        $this
                                            ->Products
                                            ->ProductOptionStocks
                                            ->patchEntity($OptionStockEntity, $stock, ['validate' => true]);


                                        $saveStock = $this
                                            ->Products
                                            ->ProductOptionStocks
                                            ->save($OptionStockEntity);

                                        if (!$saveStock) {
                                            $response['error']['ProductOptionStocks'][$key]['branches'][$i] = $OptionStockEntity->getErrors();
                                        }
                                    }
                                }
                                $idx++;
                            }
                        }
                    }

                    if ($option_price_delete = $this->request->getData('OptionPriceToDelete')) {
                        foreach($option_price_delete as $product_option_price_id) {
                            //TODO using soft delete later
                            //find entity
                            $getProductOptionPrices = $this->Products->ProductOptionPrices->find()
                                ->where([
                                    'ProductOptionPrices.id' => $product_option_price_id
                                ])
                                ->first();
                            if ($getProductOptionPrices) {
                                $idx = $getProductOptionPrices->get('idx');
                                if($this->Products->ProductOptionPrices->delete($getProductOptionPrices)) {
                                    //delete image too
                                    $getProductImages = $this->Products->ProductImages->find()
                                        ->where([
                                            'product_id' => $product->get('id'),
                                            'idx' => $idx
                                        ])
                                        ->first();
                                    if ($getProductImages) {
                                        $this->Products->ProductImages->delete($getProductImages);
                                    }
                                }
                            }
                        }
                    }

                    $this->Flash->success(__('The product has been saved.'));

                }
            }



            $response['error'] = !isset($response['error']) ? $validator->errors($this->request->getData()) : $response['error'];
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($response));

        } else if ($this->request->is(['patch', 'post', 'put'])) {
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
        $options = $this->Options->find('list')
            ->orderAsc('id')
            ->toArray();

        $parent_categories = $this->ProductCategories->find('list')
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->isNull('parent_id');
            })->toArray();
        //debug($parent_categories->toArray());

        /**
         * @var \AdminPanel\Model\Entity\ProductToCategory[] $productToCategories
         */
        $productToCategories = $this->Products->ProductToCategories->find()
            ->select(['product_category_id'])
            ->where([
                'product_id' => $product->get('id')
            ])
            ->toArray();

        $product_categories = [];
        foreach($productToCategories as $val) {
            array_push($product_categories, $val->get('product_category_id'));
        }

        $product_category_path = $this->ProductCategories->find('path', ['for' => $product_categories[0]])
            ->select('name')
            ->toArray();


        /*$brands = $this->Products->Brands->find('list')
            ->where([
                'product_category_id IN' => $product_categories
            ])
            ->toArray();*/

        $brands = $this->CategoryToBrands->find('list', [
            'keyField' => 'brand_id',
            'valueField' => function(\AdminPanel\Model\Entity\CategoryToBrand $row) {
                return $row->get('brand') ? $row->get('brand')->name : '-';
            }
        ])->contain([
            'Brands'
        ])
        ->group('brand_id')
        ->toArray();


        $get_product_tag_selected = $this->Products->ProductTags->find()
            ->select()
            ->where([
                'product_id' => $product->get('id')
            ])
            ->toArray();

        $product_tag_selected  = Hash::extract($get_product_tag_selected, '{n}.tag_id');

        $list_attributes = $this->Attributes->find('threaded')
            ->where(['Attributes.product_category_id IN ' => $product_categories])
            ->toArray();

        $get_product_attribute_checked =$this->Products->ProductAttributes->find()
            ->where([
                'product_id' => $product->get('id')
            ])
            ->toArray();
        $product_attribute_checked  = Hash::extract($get_product_attribute_checked, '{n}.attribute_id');

        $product_tags = $this->Tags->find('list')->toArray();
        $product_warranties = $this->ProductWarranties->find('list')->toArray();

        $get_product_option_prices = $this->Products->ProductOptionPrices->find()
            ->where([
                'product_id' => $product->get('id')
            ])
            ->contain([
                'ProductOptionStocks',
                'ProductOptionValueLists' => [
                    'sort' => ['Options.id' => 'ASC'],
                    'Options'
                ]
            ])
            ->orderAsc('idx')
            ->toArray();

        $list_options = Hash::extract($get_product_option_prices, '0.product_option_value_lists.{n}.option_id');


        /**
         * @var \AdminPanel\Model\Entity\OptionValue[] $get_option_lists
         */
        $get_option_lists = [];
        if (count($list_options) > 0) {
            $get_option_lists = $this->OptionValues->find()
                ->where([
                    'option_id IN' =>  $list_options
                ])
                ->toArray();
        }


        $select_options = [];
        foreach($get_option_lists as $val) {
            if (!isset($select_options[$val->get('option_id')])) {
                $select_options[$val->get('option_id')] = [];
            }
            $select_options[$val->get('option_id')][$val->get('id')] = $val->get('name');
        }

        $branches = $this->Branches->find('list')->toArray();

        /**
         * @var \AdminPanel\Model\Entity\ProductImage[] $get_product_images
         */
        $get_product_images = $this->Products->ProductImages->find()
            ->where([
                'product_id' => $product->get('id')
            ])
            ->toArray();

        $product_images = [];
        foreach($get_product_images as $key => $val) {
            if (!array_key_exists($val->get('idx'), $product_images)) {
                $product_images[$val->get('idx')] = [];
            }
            $product_images[$val->get('idx')][] = $val;
        }

        $meta_tags = $this->Products->ProductMetaTags->find()
            ->where([
                'product_id' => $product->get('id')
            ])
            ->first();

        $product_to_courriers  = Hash::extract($product['product_to_courriers'], '{n}.courrier_id');



            //debug($list_options);
        //debug($get_product_option_prices);
        //exit;



        $this->set(compact(
            'product',
            'productStockStatuses',
            'productWeightClasses',
            'productStatuses',
            'courriers',
            'options',
            'parent_categories',
            'product_tags',
            'product_warranties',
            'brands',
            'product_tag_selected',
            'list_attributes',
            'product_attribute_checked',
            'get_product_option_prices',
            'list_options',
            'select_options',
            'branches',
            'product_images',
            'meta_tags',
            'product_to_courriers',
            'product_category_path'
        ));
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

    public function indexpick(){


        if ($this->DataTable->isAjax()) {
            $datatable = $this->DataTable->adapter('AdminPanel.Products')
                ->contain([

                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Products.name LIKE' => '%' . $search .'%',
                        'Products.sku LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })->where(['Products.name !=' => '','Products.product_status_id' =>1]);

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->toArray();

            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }

    }

    public function setPrimaryImage($id)
    {
        $images = $this->Products->ProductImages->find()
            ->where([
                'product_id' => $id
            ])
            ->orderAsc('idx');

        if ($this->request->is('post')) {
            if ($product_images = $this->request->getData('ProductImages')) {
                $product_image_id = $product_images['primary'];

                $this->Products->ProductImages->query()
                    ->update()
                    ->set([
                        'primary' => 0
                    ])
                    ->where([
                        'product_id' => $id,
                        'id !=' => $product_image_id
                    ])
                    ->execute();

                $this->Products->ProductImages->query()
                    ->update()
                    ->set([
                        'primary' => 1
                    ])
                    ->where([
                        'product_id' => $id,
                        'id' => $product_image_id
                    ])
                    ->execute();

            }
            return $this->redirect(['action' => 'index']);
        }


        $this->set(compact('images'));
    }
}
