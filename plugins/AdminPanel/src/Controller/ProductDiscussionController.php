<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Core\Configure;
use Cake\Validation\Validator;

/**
 * ProductGroups Controller
 * @property \AdminPanel\Model\Table\ProductDiscussionsTable $ProductDiscussions
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\CustomersTable $Customers
 *
 * @method \AdminPanel\Model\Entity\ProductGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductDiscussionController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.ProductDiscussions');
        $this->loadModel('AdminPanel.Products');
        $this->loadModel('AdminPanel.Customers');
    }


    public function index(){
        if ($this->DataTable->isAjax()) {
            $subquery = $this->ProductDiscussions->find()
                ->select(['id' => 'MAX(ProductDiscussions.id)'] )
                ->group(['product_id']);
            $datatable = $this->DataTable->adapter('AdminPanel.ProductDiscussions')
                ->contain([
                    'Products' => [
                        'ProductImages'
                    ]
                ])
                ->where(['ProductDiscussions.id IN ' => $subquery])
                ->order(['ProductDiscussions.created' => 'DESC','ProductDiscussions.read' => 'ASC']);

            $result = $datatable
                ->setSorting()
                ->getTable()
                ->map(function(\AdminPanel\Model\Entity\ProductDiscussion $row){
                    $conter = $this->ProductDiscussions->find()
                        ->where(['ProductDiscussions.product_id' => $row->product_id, 'ProductDiscussions.read' => 0 ])
                        ->count();
                    $row->count_unread = $conter;

                    return $row;
                })
                ->toArray();
            //set again datatable
            $datatable->setData($result);
            return $datatable->response();
        }
    }

    public function detail($product_id = null){

        $query = $this->ProductDiscussions->query();
        $query->update()
            ->set(['read' => 1])
            ->where([
                'product_id' => $product_id,
            ])
            ->execute();

        $discuss = $this->ProductDiscussions->find('threaded')
            ->contain([
                'Customers' => [
                    'fields' => [
                        'avatar',
                        'first_name',
                        'last_name',
                        'email'
                    ]
                ],
                'Users' => [
                    'fields' => [
                        'first_name'
                    ]
                ]
            ])
            ->where(['ProductDiscussions.product_id' => $product_id]);
        $discuss = $discuss->orderAsc('ProductDiscussions.id')->toArray();
        $product = $this->Products->find()
            ->contain([
                'ProductImages'
            ])
            ->where(['Products.id' => $product_id])
            ->first();

        $this->set(compact('product', 'discuss'));
    }




    public function add(){

        $this->disableAutoRender();
        $validator = new Validator();

        $validator->requirePresence('comment')
            ->notBlank('comment', 'Jawaban diskusi tidak boleh kosong');
        $validator->requirePresence('product_id')
            ->notBlank('product_id', 'produk tidak ditemukan') ;

        $error = $validator->errors($this->request->getData());
        if (empty($error)) {

            $allData = $this->request->getData();
            $entity = $this->ProductDiscussions->newEntity();
            $entity->set('customer_id', null);
            $entity->set('to_customer', null);
            $entity->set('user_id', $this->Auth->user('id'));
            $entity->set('is_admin', true);
            $this->ProductDiscussions->patchEntity($entity, $allData, [
                'fields' => [
                    'parent_id',
                    'product_id',
                    'to_customer',
                    'user_id',
                    'is_admin',
                    'comment',
                    'customer_id'
                ],
                ['validate' => false]
            ]);
            if($this->ProductDiscussions->save($entity)){
                $this->Flash->success(__('The discussion has been saved.'));
                /*SEND EMAIL TO USER*/
                $findProduct = $this->Products->find()
                    ->select(['name', 'slug'])
                    ->where(['Products.id' => $entity->get('product_id')])->first();
                $findCustomer = $this->Customers->find()
                    ->select(['username'])
                    ->where(['Customers.id' => $entity->get('to_customer')])->first();
                $this->Mailer
                    ->setVar([
                        'name' => $findCustomer->get('username'),
                        'message' => 'Balasan : "'.$entity->get('comment').'"<br><br>Diskusi produk telah di balas oleh administrator, silahkan memberikan balasan.<br>'.Configure::read('frontsite') .'products/detail/'.$findProduct->get('slug').'#tab-diskusi'
                    ])
                    ->send(
                        $entity->get('to_customer'),
                        'Diskusi produk '.$findProduct->get('name'),
                        'notification'
                    );

            }


        }
        $response['error'] = $error;
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($response));
    }

    public function delete(){

        $this->request->allowMethod(['post', 'put']);
        if ($discuss_id = $this->request->getData('id')) {
            $entity = $this->ProductDiscussions->find()
                ->where([
                    'customer_id' => $this->Authenticate->getId(),
                    'id' => $discuss_id
                ])
                ->first();

            if ($entity) {
                if (!$this->ProductDiscussions->delete($entity)) {
                    $this->setResponse($this->response->withStatus(406, 'Gagal menghapus komentar'));
                }
            }

        }

    }

}
