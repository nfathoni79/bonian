<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Validation\Validator;

/**
 * ProductGroups Controller
 * @property \AdminPanel\Model\Table\ProductDiscussionsTable $ProductDiscussions
 * @property \AdminPanel\Model\Table\ProductsTable $Products
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
                ->order(['ProductDiscussions.created' => 'DESC']);

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

        $validator = new Validator();

        $validator->requirePresence('comment')
            ->notBlank('comment', 'Pertanyaan diskusi tidak boleh kosong');
        $validator->requirePresence('product_id')
            ->notBlank('product_id', 'produk tidak ditemukan') ;

        $error = $validator->errors($this->request->getData());
        if (empty($error)) {

            $allData = $this->request->getData();
            $entity = $this->ProductDiscussions->newEntity();
            $this->ProductDiscussions->patchEntity($entity, $allData, [
                'fields' => [
                    'parent_id',
                    'product_id',
                    'comment'
                ]
            ]);
            $entity->set('customer_id', $this->Authenticate->getId());
            if(!$this->ProductDiscussions->save($entity)) {
                $this->setResponse($this->response->withStatus(406, 'Failed to add address'));
                $error = $entity->getErrors();
            }

        }
        if ($error) {
            $this->setResponse($this->response->withStatus(406, 'Failed to add address'));
        }

        $this->set(compact('error'));
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
