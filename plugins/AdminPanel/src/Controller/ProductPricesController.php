<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;

/**
 * ProductPricesMutations Controller
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\ProductOptionPricesTable $ProductOptionPrices
 * @property \AdminPanel\Model\Table\ActivityLogsTable $ActivityLogs
 * @property \AdminPanel\Model\Table\PriceSettingsTable $PriceSettings
 * @property \AdminPanel\Model\Table\PriceSettingDetailsTable $PriceSettingDetails
 *
 */
class ProductPricesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Products');
        $this->loadModel('AdminPanel.ProductOptionPrices');
        $this->loadModel('AdminPanel.ActivityLogs');
        $this->loadModel('AdminPanel.PriceSettings');
        $this->loadModel('AdminPanel.PriceSettingDetails');
    }

    public function preview($id = null){

        if ($this->DataTable->isAjax()) {

            $datatable = $this->DataTable->adapter('AdminPanel.PriceSettingDetails')
                ->contain([
                    'PriceSettings',
                    'Products',
                    'ProductOptionPrices' => [
                        'Products'
                    ],
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Products.name LIKE' => '%' . $search .'%',
                        'PriceSettingDetails.sku LIKE' => '%' . $search .'%',
                        'ProductOptionPrices.sku LIKE' => '%' . $search .'%',
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

    public function schedule(){

        if ($this->DataTable->isAjax()) {

            \Cake\I18n\FrozenTime::setJsonEncodeFormat('yyyy-MM-dd');
            \Cake\I18n\FrozenTime::setToStringFormat('yyyy-MM-dd');
            $datatable = $this->DataTable->adapter('AdminPanel.PriceSettings')
                ->contain([
                    'Users',
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'PriceSettings.schedule LIKE' => '%' . $search .'%',
                        'Users.first_name LIKE' => '%' . $search .'%',
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

    public function canceled($pid, $id = null){
        $priceSetting = $this->PriceSettingDetails->get($id, [
            'contain' => []
        ]);
        try {
//            $priceSetting = $this->PriceSettingDetails->patchEntity($priceSetting, [
//                'status' => '2'
//            ]);
            $priceSetting->set('status', 2);
            if ($this->PriceSettingDetails->save($priceSetting)) {
                $this->Flash->success(__('The price setting details has been saved.'));
            }else {
                $this->Flash->error(__('The option could not be saved. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The option could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'preview', $pid]);
    }

    public function cancel($id = null){
        $priceSetting = $this->PriceSettings->get($id, [
            'contain' => []
        ]);

        try {
            $priceSetting = $this->PriceSettings->patchEntity($priceSetting, [
                'status' => '2'
            ]);
            if ($this->PriceSettings->save($priceSetting)) {

                $query = $this->PriceSettingDetails->query();
                $query->update()
                    ->set(['status' => 2])
                    ->where(['price_setting_id' => $id])
                    ->execute();


                $this->Flash->success(__('The price setting details has been saved.'));
            }else {
                $this->Flash->error(__('The option could not be saved. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The option could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'schedule']);
    }

    public function validateUpload(){
        $this->disableAutoRender();

        $response = [];
        $validator = new Validator();
        $validator
            ->notBlank('schedule', 'tidak boleh kosong');
        $validator
//            ->notBlank('files', 'tidak boleh kosong')
            ->add('files', [
                'validExtension' => [
                    'rule' => ['extension',['csv']], // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('These files extension are allowed: .csv')
                ]
            ]);

        $allData = $this->request->getData();
        $error = $validator->errors($allData);
        if (empty($error)) {
            try {


                $entity = $this->PriceSettings->newEntity([
                    'user_id' => $this->Auth->user('id'),
                    'schedule' => $this->request->getData('schedule'),
                    'status' => 0,
                ]);


                $this->PriceSettings->getConnection()->begin();

                if ($this->PriceSettings->save($entity)) {
                    $idPriceSetting = $entity->get('id');
                    $data = $this->request->getData('files');
                    $file = $data['tmp_name'];
                    $handle = fopen($file, "r");
                    $count = 0;


                    $success = true;
                    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {

                        /* SKIP ROW 0*/
                        $count++;
                        if ($count == 1) {
                            continue;
                        }

                        /*0 : SKU , 1 : Type (Main/Varian), 2 : Price*/
                        switch (strtolower($row[1])) {
                            case 'main':

                                $findProduct = $this->Products->find()
                                    ->where(['Products.sku' => $row[0]])
                                    ->first();
                                if($findProduct){
                                    $id = $findProduct->get('id');
                                    $entityDetails = $this->PriceSettingDetails->newEntity([
                                        'price_setting_id' => $idPriceSetting,
                                        'sku' => $row[0],
                                        'product_id' => $id,
                                        'type' => 'Main',
                                        'price' => $row[2],
                                        'status' => 0,
                                    ]);
                                    if($this->PriceSettingDetails->save($entityDetails)){

                                    }else{
                                        $success = false;
                                        $this->Flash->error(__('Failed Unknown format on line '.$count));
                                        break;
                                    }
                                }else{
                                    $success = false;
                                    $this->Flash->error(__('Failed Unknown prodcut SKU : '.$row[0]));
                                    break;
                                }

                                break;
                            case 'varian':
                                $findProductOptionPrice = $this->ProductOptionPrices->find()
                                    ->where(['ProductOptionPrices.sku' => $row[0]])
                                    ->first();
                                if($findProductOptionPrice){
                                    $id = $findProductOptionPrice->get('id');

                                    $entityDetails = $this->PriceSettingDetails->newEntity([
                                        'price_setting_id' => $idPriceSetting,
                                        'sku' => $row[0],
                                        'product_option_price_id' => $id,
                                        'type' => 'Variant',
                                        'price' => $row[2],
                                        'status' => 0,
                                    ]);

                                    if($this->PriceSettingDetails->save($entityDetails)){

                                    }else{
                                        $success = false;
                                        $this->Flash->error(__('Failed Unknown format on line '.$count));
                                        break;
                                    }

                                }else{
                                    $success = false;
                                    $this->Flash->error(__('Failed Unknown product SKU : '.$row[0]));
                                    break;
                                }
                            break;
                        }


                    }

                    if($success){
                        $this->PriceSettings->getConnection()->commit();
                        $this->Flash->success(__('The product price schedule has been save.'));
                    }else{
                        $this->PriceSettings->getConnection()->rollback();
                    }

                }

            } catch(\Cake\ORM\Exception\PersistenceFailedException $e) {
                $this->PriceSettings->getConnection()->rollback();
            }


        }
        $response['error'] = $error;
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    public function validate(){

        $this->disableAutoRender();
        $response = [];
        $products = $this->request->getData('Products');
        $validator = new Validator();

        $productsValue = new Validator();
        $optionPrice = new Validator();
        foreach($products as $k => $vals){
            if(!empty($vals['id'])) {
                $products[$k]['price_sale'] = preg_replace('/[,.]/', '', $vals['price_sale']);
                foreach($vals['ProductOptionPrices'] as $x => $val){
                    if(!empty($val['id'])){
                        $products[$k]['ProductOptionPrices'][$x]['price'] =  preg_replace('/[,.]/', '', $val['price']);
                    }else{
                        unset($products[$k]['ProductOptionPrices'][$x]);
                    }
                }
            } else {
                unset($products[$k]);
            }
        }
        foreach($products as $k => $vals){
            if(!empty($vals['id'])) {
                $productsValue
                    ->notBlank('price_sale', 'tidak boleh kosong')
                    ->decimal('price_sale');
                foreach($vals['ProductOptionPrices'] as $x => $val){
                    if(!empty($val['id'])){
                        $optionPrice
                            ->notBlank('price', 'tidak boleh kosong')
                            ->decimal('price');
                    }
                }
            }
        }

        $productsValue->addNestedMany('ProductOptionPrices', $optionPrice);
        $validator->addNestedMany('Products', $productsValue);

        $allData = $this->request->getData();
        $allData['Products'] = $products;
        $error = $validator->errors($allData);
        if (empty($error)) {
            foreach($products as $vals){
                $id = $vals['id'];
                $product = $this->Products->get($id);
                $product = $this->Products->patchEntity($product, [
                    'price_sale' => $vals['price_sale']
                ] , ['validate' => false]);

                $this->Products->setLogMessageBuilder(function () use($product){
                    return 'Manajemen Harga - Perubahan Pada Main SKU : '.$product->get('sku');
                });
                if($this->Products->save($product)){
                    foreach($vals['ProductOptionPrices'] as $k => $val){
                        $productOptionPrices = $this->ProductOptionPrices->get($k);
                        $productOptionPrices = $this->ProductOptionPrices->patchEntity($productOptionPrices, [
                            'price' => $val['price']
                        ] , ['validate' => false]);
                        $this->ProductOptionPrices->setLogMessageBuilder(function () use($productOptionPrices){
                            return 'Manajemen Harga - Perubahan Pada SKU : '.$productOptionPrices->get('sku');
                        });
                        $this->ProductOptionPrices->save($productOptionPrices);
                    }
                }
            }
            $this->Flash->success(__('The product price has been update.'));


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
            $datatable = $this->DataTable->adapter('AdminPanel.ProductOptionPrices')
                ->contain([
                    'Products',
                    'ProductOptionValueLists' => [
                        'Options',
                        'OptionValues',
                    ]
                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Products.name LIKE' => '%' . $search .'%',
                        'Products.sku LIKE' => '%' . $search .'%',
                        'ProductOptionPrices.sku LIKE' => $search .'%',
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
}