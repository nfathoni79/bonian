<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;
use Cake\Utility\Text;

/**
 * Vouchers Controller
 * @property \AdminPanel\Model\Table\VouchersTable $Vouchers
 * @property \AdminPanel\Model\Table\ProductCategoriesTable $ProductCategories
 * @property \AdminPanel\Model\Table\VoucherDetailsTable $VoucherDetails
 *
 * @method \AdminPanel\Model\Entity\Voucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VouchersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.ProductCategories');
        $this->loadModel('AdminPanel.Vouchers');
        $this->loadModel('AdminPanel.VoucherDetails');

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {


        if ($this->DataTable->isAjax()) {

            $datatable = $this->DataTable->adapter('AdminPanel.Vouchers')
                ->select([])
//                ->contain([
//                    'Products' => [
//                        'Brands',
//                        'ProductToCategories' => [
//                            'ProductCategories'
//                        ]
//                    ],
//                    'ProductOptionPrices',
//                    'Branches',
//                ])
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Vouchers.code_voucher LIKE' => '%' . $search .'%',
                        'Vouchers.date_start LIKE' => '%' . $search .'%',
                        'Vouchers.date_end LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })
                ->getRequestColumn(1, function($request, \Cake\ORM\Query $table) {
                    if (!empty($request['search']['value'])) {
                        $type_id = $request['search']['value'];
                        $table->where([
                            'Vouchers.type' => $type_id
                        ]);
                    }
                })
                ->getRequestColumn(2, function($request, \Cake\ORM\Query $table) {
                    if (!empty($request['search']['value'])) {
                        $codeVoucher = $request['search']['value'];
                        $table->where([
                            'Vouchers.code_voucher' => $codeVoucher
                        ]);
                    }
                })
            ;

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->map(function (\AdminPanel\Model\Entity\Voucher $row) {
                    $type = ['1' => 'Penukaran Point', '2' => 'Seleksi Kategori', '3' => 'Private Voucher'];
                     $row->type_text = $type[$row->type];
                    return $row;
                })
                ->toArray();




            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }


        $voucherType = ['1' => 'Penukaran Point', '2' => 'Seleksi Kategori', '3' => 'Private Voucher'];
        $this->set(compact('voucherType'));
    }

    public function picker()
    {


        if ($this->DataTable->isAjax()) {

            $datatable = $this->DataTable->adapter('AdminPanel.Vouchers')
                ->select([]) 
                ->search(function ($search, \Cake\Database\Expression\QueryExpression $exp) {
                    $orConditions = $exp->or_([
                        'Vouchers.code_voucher LIKE' => '%' . $search .'%',
                        'Vouchers.date_start LIKE' => '%' . $search .'%',
                        'Vouchers.date_end LIKE' => '%' . $search .'%',
                    ]);
                    return $exp
                        ->add($orConditions);
                })
                ->getRequestColumn(1, function($request, \Cake\ORM\Query $table) {
                    if (!empty($request['search']['value'])) {
                        $type_id = $request['search']['value'];
                        $table->where([
                            'Vouchers.type' => $type_id
                        ]);
                    }
                })
                ->getRequestColumn(2, function($request, \Cake\ORM\Query $table) {
                    if (!empty($request['search']['value'])) {
                        $codeVoucher = $request['search']['value'];
                        $table->where([
                            'Vouchers.code_voucher' => $codeVoucher
                        ]);
                    }
                })
				->where(['Vouchers.type' => 2])
            ;

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->map(function (\AdminPanel\Model\Entity\Voucher $row) {
                    $type = ['1' => 'Penukaran Point', '2' => 'Seleksi Kategori', '3' => 'Private Voucher'];
                     $row->type_text = $type[$row->type];
                    return $row;
                })
                ->toArray();




            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }


        $voucherType = ['1' => 'Penukaran Point', '2' => 'Seleksi Kategori', '3' => 'Private Voucher'];
        $this->set(compact('voucherType'));
    }



    /**
     * View method
     *
     * @param string|null $id Voucher id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $voucher = $this->Vouchers->get($id, [
            'contain' => ['Orders']
        ]);

        if ($voucher) {
            $type = $voucher->get('type');
            $type_name = ($type == 1) ? 'Diskon (%)' : 'Potongan Harga';
            $voucher->type = $type_name;

            $status = $voucher->get('status');
            $voucher->status = ($status == 1) ? 'Aktif' : 'Tidak Aktif';
        }

        $this->set('voucher', $voucher);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $voucher = $this->Vouchers->newEntity();

        if ($this->request->is(['ajax'])) {
            $this->disableAutoRender();
            $response = [];
            $type = $this->request->getData('type');
            $validator = new Validator();

            $validator
                ->requirePresence('name')
                ->notBlank('name', 'Judul Promosi harus diisi');
            $validator
                ->requirePresence('date_start')
                ->notBlank('date_start', 'Schedule awal harus di isi');
            $validator
                ->requirePresence('date_end')
                ->notBlank('date_end', 'Schedule akhir harus di isi');

            $validator
                ->requirePresence('percent')
                ->numeric('percent', 'gunakan format angka')
                ->greaterThanOrEqual('percent',0,'harus lebih besar daripada 0')
                ->lessThanOrEqual('percent', 100, 'maksimum 100 persen')
                ->notBlank('percent', 'Masukkan jumlah diskon');
            $validator
                ->requirePresence('value')
                ->numeric('value', 'gunakan format angka')
                ->greaterThanOrEqual('value',0,'harus lebih besar daripada 0')
                ->notBlank('value', 'Masukkan jumlah nilai maksimum voucher');
            $validator
                ->requirePresence('qty')
                ->numeric('qty', 'gunakan format angka')
                ->greaterThanOrEqual('qty',0,'harus lebih besar daripada 0')
                ->notBlank('qty', 'Masukkan jumlah kuota');

            switch ($type) {
                case '1':
                    $validator
                        ->requirePresence('point')
                        ->numeric('point', 'gunakan format angka')
                        ->greaterThanOrEqual('point',0,'harus lebih besar daripada 0')
                        ->notBlank('point', 'Masukkan jumlah redeem point');
                    $validator
                        ->requirePresence('code_voucher')
                        ->regex('code_voucher','/[^\s]+/', 'Format no whitespace')
                        ->notBlank('code_voucher', 'Code voucher harus diisi');
                break;
                case '2':

                    $validator
                        ->requirePresence('code_voucher')
                        ->regex('code_voucher','/[^\s]+/', 'Format no whitespace')
                        ->notBlank('code_voucher', 'Code voucher harus diisi');
                    $validator
                        ->requirePresence('tos')
                        ->notBlank('tos', 'Syarat dan ketentuan wajib di isi');

                    $category = new Validator();
                    $category
                        ->requirePresence('id')
                        ->notBlank('id', 'Atribut id harus diisi');

                    $category
                        ->requirePresence('name')
                        ->notBlank('name', 'Nama Kategori Tidak boleh kosong');

                    $validator->addNestedMany('categories', $category);
                break;
                case '3':

                    $validator
                        ->requirePresence('prefix')
                        ->regex('prefix','/^[a-z]{2}$/i', '2 karakter prefix')
                        ->notBlank('prefix', 'Prefix harus diisi');
                    $validator
                        ->requirePresence('jumlah')
                        ->numeric('jumlah', 'gunakan format angka')
                        ->greaterThanOrEqual('jumlah',0,'harus lebih besar daripada 0')
                        ->notBlank('jumlah', 'Jumlah voucher harus diisi');

//                    $validator
//                        ->requirePresence('files')
//                        ->add('files', [
//                            'validExtension' => [
//                                'rule' => ['extension',['csv']], // default  ['gif', 'jpeg', 'png', 'jpg']
//                                'message' => __('These files extension are allowed: .csv')
//                            ]
//                        ]);
                break;
            }
            $error = $validator->errors($this->request->getData());
            if (empty($error)) {


                switch ($type) {

                    case '1':
                        $voucher = $this->Vouchers->patchEntity($voucher, $this->request->getData());
                        $voucher->slug = Text::slug(strtolower($this->request->getData('name')));
                        $voucher->stock = $this->request->getData('qty');
                        $this->Vouchers->save($voucher);
                        $this->Flash->success(__('Konfigurasi voucher berhasil disimpan'));
                        break;
                    case '2':

                        $voucher = $this->Vouchers->patchEntity($voucher, $this->request->getData());
                        $voucher->slug = Text::slug(strtolower($this->request->getData('name')));
                        $voucher->stock = $this->request->getData('qty');
                        if ($this->Vouchers->save($voucher)) {

                            if ($categories = $this->request->getData('categories')) {
                                foreach($categories as $category) {
                                    $categoryEntity = $this->VoucherDetails->newEntity([
                                        'voucher_id' => $voucher->get('id'),
                                        'product_category_id' => $category['id']
                                    ]);
                                    $this->VoucherDetails->save($categoryEntity);
                                }
                            }
                            $this->Flash->success(__('Konfigurasi voucher berhasil disimpan'));
                        }

                        break;

                    case '3':

                        /* Import data */
                        $prefix = $this->request->getData('prefix');
                        $jumlah = $this->request->getData('jumlah');

                        try {

                            $success = true;
                            $this->Vouchers->getConnection()->begin();

                            for($i=0;$i<=($jumlah -1);$i++){
                                $codeVoucher = $prefix . $this->randomNumber(8);

                                /* CHECK TO DB EXSIST */
                                $find = $this->Vouchers->find()
                                    ->where(['code_voucher' => $codeVoucher])
                                    ->first();
                                if(empty($find)){
                                    $entity = $this->Vouchers->newEntity([
                                        'name' => $this->request->getData('name'),
                                        'slug' => Text::slug(strtolower($this->request->getData('name'))),
                                        'code_voucher' => $codeVoucher,
                                        'date_start' => $this->request->getData('date_start'),
                                        'date_end' => $this->request->getData('date_end'),
                                        'qty' => 1,
                                        'stock' => 1,
                                        'type' => 3,
                                        'point' => 0,
                                        'percent' => $this->request->getData('percent'),
                                        'value' => $this->request->getData('value'),
                                        'status' => 1,
                                    ]);

                                    if($this->Vouchers->save($entity)){

                                    }else{
                                        $this->Flash->error(__('Gagal menyimpan konfigurasi, duplikasi kode produk '.$row[0]));
                                        $success = false;
                                        break;
                                    }
                                }else{
                                    $this->Flash->error(__('Gagal menyimpan konfigurasi, duplikasi kode produk '.$row[0]));
                                    $success = false;
                                    break;
                                }
                            }

                            if($success){
                                $this->Vouchers->getConnection()->commit();
                                $this->Flash->success(__('Konfigurasi voucher berhasil disimpan'));
                            }else{
                                $this->Vouchers->getConnection()->rollback();
                            }
                        }catch(\Cake\ORM\Exception\PersistenceFailedException $e) {
                            $this->Vouchers->getConnection()->rollback();
                        }


                        break;
                }

            }

            $response['error'] = $error;
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($response));
        }

        $parent_categories = $this->ProductCategories->find('list')
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->isNull('parent_id');
            })->toArray();
        $this->set(compact('voucher','parent_categories'));
    }

    private function randomNumber($length) {
        $result = '';

        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    /**
     * Edit method
     *
     * @param string|null $id Voucher id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $voucher = $this->Vouchers->get($id, [
            'contain' => [
                'VoucherDetails' => [
                    'ProductCategories'
                ]
            ]
        ]);


        if ($this->request->is('ajax')) {
            $response = [];
            $validator = new Validator();

            $error = $validator->errors($this->request->getData());

            $type = $this->request->getData('type');
            $validator = new Validator();

            $validator
                ->requirePresence('name')
                ->notBlank('name', 'Judul Promosi harus diisi');
            $validator
                ->requirePresence('date_start')
                ->notBlank('date_start', 'Schedule awal harus di isi');
            $validator
                ->requirePresence('date_end')
                ->notBlank('date_end', 'Schedule akhir harus di isi');

            $validator
                ->requirePresence('percent')
                ->numeric('percent', 'gunakan format angka')
                ->greaterThanOrEqual('percent',0,'harus lebih besar daripada 0')
                ->lessThanOrEqual('percent', 100, 'maksimum 100 persen')
                ->notBlank('percent', 'Masukkan jumlah diskon');
            $validator
                ->requirePresence('value')
                ->numeric('value', 'gunakan format angka')
                ->greaterThanOrEqual('value',0,'harus lebih besar daripada 0')
                ->notBlank('value', 'Masukkan jumlah nilai maksimum voucher');
            $validator
                ->requirePresence('qty')
                ->numeric('qty', 'gunakan format angka')
                ->greaterThanOrEqual('qty',0,'harus lebih besar daripada 0')
                ->notBlank('qty', 'Masukkan jumlah kuota');

            switch ($type) {
                case '1':
                    $validator
                        ->requirePresence('point')
                        ->numeric('point', 'gunakan format angka')
                        ->greaterThanOrEqual('point',0,'harus lebih besar daripada 0')
                        ->notBlank('point', 'Masukkan jumlah redeem point');
                    $validator
                        ->requirePresence('code_voucher')
                        ->regex('code_voucher','/[^\s]+/', 'Format no whitespace')
                        ->notBlank('code_voucher', 'Code voucher harus diisi');
                    break;
                case '2':

                    $validator
                        ->requirePresence('code_voucher')
                        ->regex('code_voucher','/[^\s]+/', 'Format no whitespace')
                        ->notBlank('code_voucher', 'Code voucher harus diisi');
                    $validator
                        ->requirePresence('tos')
                        ->notBlank('tos', 'Syarat dan ketentuan wajib di isi');

                    $category = new Validator();
                    $category
                        ->requirePresence('id')
                        ->notBlank('id', 'Atribut id harus diisi');

                    $category
                        ->requirePresence('name')
                        ->notBlank('name', 'Nama Kategori Tidak boleh kosong');

                    $validator->addNestedMany('categories', $category);
                    break;
                case '3':

                    $validator
                        ->requirePresence('files')
                        ->add('files', [
                            'validExtension' => [
                                'rule' => ['extension',['csv']], // default  ['gif', 'jpeg', 'png', 'jpg']
                                'message' => __('These files extension are allowed: .csv')
                            ]
                        ]);
                    break;
            }
            $error = $validator->errors($this->request->getData());
            if (empty($error)) {

                switch ($type) {

                    case '1':
                        $voucher = $this->Vouchers->patchEntity($voucher, $this->request->getData());

                        $voucher->slug = Text::slug(strtolower($this->request->getData('name')));
                        $voucher->stock = $this->request->getData('qty');
                        $this->Vouchers->save($voucher);
                        $this->Flash->success(__('Konfigurasi voucher berhasil disimpan'));
                        break;
                    case '2':

                        $voucher = $this->Vouchers->patchEntity($voucher, $this->request->getData());
                        $voucher->slug = Text::slug(strtolower($this->request->getData('name')));
                        $voucher->stock = $this->request->getData('qty');
                        $voucher->id = $voucher->get('id');
                        if ($this->Vouchers->save($voucher)) {

                            if ($categories = $this->request->getData('categories')) {

                                foreach($categories as $category) {

                                    $categoryEntity = $this->VoucherDetails->find()
                                        ->where([
                                            'id' => $category['idx']
                                        ])
                                        ->first();

                                    if ($categoryEntity) {
                                        $this->VoucherDetails->patchEntity($categoryEntity, [
                                            'voucher_id' => $voucher->get('id'),
                                            'product_category_id' => $category['id']
                                        ]);
                                    } else {
                                        $categoryEntity = $this->VoucherDetails->newEntity([
                                            'voucher_id' => $voucher->get('id'),
                                            'product_category_id' => $category['id']
                                        ]);
                                    }

                                    $this->VoucherDetails->save($categoryEntity);

                                }
                            }
                            $this->Flash->success(__('Konfigurasi voucher berhasil disimpan'));
                        }

                        break;

                    case '3':

                        /* Import data */
                        try {

                            $data = $this->request->getData('files');
                            $file = $data['tmp_name'];
                            $handle = fopen($file, "r");
                            $success = true;
                            $this->Vouchers->getConnection()->begin();

                            $count = 0;
                            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {

                                /* SKIP ROW 0*/
                                $count++;
                                if ($count == 1) {
                                    continue;
                                }

                                /* CHECK TO DB EXSIST */
                                $find = $this->Vouchers->find()
                                    ->where(['code_voucher' => trim($row[0])])
                                    ->first();
                                if(empty($find)){
                                    $entity = $this->Vouchers->newEntity([
                                        'id' => $voucher->get('id'),
                                        'name' => $this->request->getData('name'),
                                        'slug' => Text::slug(strtolower($this->request->getData('name'))),
                                        'code_voucher' => trim($row[0]),
                                        'date_start' => $this->request->getData('date_start'),
                                        'date_end' => $this->request->getData('date_end'),
                                        'qty' => 1,
                                        'stock' => 1,
                                        'type' => 3,
                                        'point' => 0,
                                        'percent' => $this->request->getData('percent'),
                                        'value' => $this->request->getData('value'),
                                        'status' => 1,
                                    ]);

                                    if($this->Vouchers->save($entity)){

                                    }else{
                                        $this->Flash->error(__('Gagal menyimpan konfigurasi, duplikasi kode produk '.$row[0]));
                                        $success = false;
                                        break;
                                    }
                                }else{
                                    $this->Flash->error(__('Gagal menyimpan konfigurasi, duplikasi kode produk '.$row[0]));
                                    $success = false;
                                    break;
                                }
                            }

                            if($success){
                                $this->Vouchers->getConnection()->commit();
                                $this->Flash->success(__('Konfigurasi voucher berhasil disimpan'));
                            }else{
                                $this->Vouchers->getConnection()->rollback();
                            }

                        } catch(\Cake\ORM\Exception\PersistenceFailedException $e) {
                            $this->Vouchers->getConnection()->rollback();
                        }

                        break;
                }

            }
            $response['error'] = !isset($response['error']) ? $validator->errors($this->request->getData()) : $response['error'];
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($response));

        }
//        else if ($this->request->is(['patch', 'post', 'put'])) {
//            $voucher = $this->Vouchers->patchEntity($voucher, $this->request->getData());
//            if ($this->Vouchers->save($voucher)) {
//                $this->Flash->success(__('The voucher has been saved.'));
//
//                return $this->redirect(['action' => 'index']);
//            }
//            $this->Flash->error(__('The voucher could not be saved. Please, try again.'));
//        }

        $parent_categories = $this->ProductCategories->find('list')
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->isNull('parent_id');
            })->toArray();
        $this->set(compact('voucher','parent_categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Voucher id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function getCategoryPath($categoryId =  null){

        $this->viewBuilder()->setLayout('ajax');
        $product_category_path = $this->ProductCategories->find('path', ['for' => $categoryId])
            ->select('id')
            ->toArray();

        return $this->response->withType('application/json')
            ->withStringBody(json_encode($product_category_path));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $voucher = $this->Vouchers->get($id);
        try {
            if ($this->Vouchers->delete($voucher)) {
                $this->Flash->success(__('The voucher has been deleted.'));
            } else {
                $this->Flash->error(__('The voucher could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deleteVoucherDetails($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $voucher = $this->VoucherDetails->get($id);
        try {
            if ($this->VoucherDetails->delete($voucher)) {
                $this->Flash->success(__('The voucher has been deleted.'));
            } else {
                $this->Flash->error(__('The voucher could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
