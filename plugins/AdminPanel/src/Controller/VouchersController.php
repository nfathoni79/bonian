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


        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');

            $pagination = $this->request->getData('pagination');
            $sort = $this->request->getData('sort');
            $query = $this->request->getData('query');

            /** custom default query : select, where, contain, etc. **/
            $data = $this->Vouchers->find('all')
                ->select();

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['Vouchers.code_voucher LIKE' => '%' . $search .'%']);
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


        $this->set(compact('vouchers'));
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
                ->requirePresence('code_voucher')
                ->regex('code_voucher','/[^\s]+/', 'Format no whitespace')
                ->notBlank('code_voucher', 'Code voucher harus diisi');
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
            $validator
                ->requirePresence('tos')
                ->notBlank('tos', 'Syarat dan ketentuan wajib di isi');

            switch ($type) {
                case '1':
                    $validator
                        ->requirePresence('point')
                        ->numeric('point', 'gunakan format angka')
                        ->greaterThanOrEqual('point',0,'harus lebih besar daripada 0')
                        ->notBlank('point', 'Masukkan jumlah redeem point');
                break;
                case '2':
                    $category = new Validator();
                    $category
                        ->requirePresence('id')
                        ->notBlank('id', 'Atribut id harus diisi');

                    $category
                        ->requirePresence('name')
                        ->notBlank('name', 'Nama Kategori Tidak boleh kosong');

                    $validator->addNestedMany('categories', $category);
                break;
            }
            $error = $validator->errors($this->request->getData());
            if (empty($error)) {
                $voucher = $this->Vouchers->patchEntity($voucher, $this->request->getData());
                $voucher->slug = Text::slug($this->request->getData('name'));
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
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $voucher = $this->Vouchers->patchEntity($voucher, $this->request->getData());
            if ($this->Vouchers->save($voucher)) {
                $this->Flash->success(__('The voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The voucher could not be saved. Please, try again.'));
        }
       
        $this->set(compact('voucher'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Voucher id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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
}
