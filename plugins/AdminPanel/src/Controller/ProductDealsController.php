<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * ProductDeals Controller
 * @property \AdminPanel\Model\Table\ProductDealsTable $ProductDeals
 *
 * @method \AdminPanel\Model\Entity\ProductDeal[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductDealsController extends AppController
{

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
            $data = $this->ProductDeals->find('all')
                ->select();

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['ProductDeals.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('productDeals'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Deal id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $productDeal = $this->ProductDeals->get($id, [
            'contain' => ['ProductDealDetails']
        ]);

        $this->set('productDeal', $productDeal);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productDeal = $this->ProductDeals->newEntity();
        if ($this->request->is('post')) {
            $productDeal = $this->ProductDeals->patchEntity($productDeal, $this->request->getData());
            if ($this->ProductDeals->save($productDeal)) {
                $this->Flash->success(__('The product deal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product deal could not be saved. Please, try again.'));
        }
        $this->set(compact('productDeal'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Deal id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productDeal = $this->ProductDeals->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productDeal = $this->ProductDeals->patchEntity($productDeal, $this->request->getData());
            if ($this->ProductDeals->save($productDeal)) {
                $this->Flash->success(__('The product deal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product deal could not be saved. Please, try again.'));
        }
        $this->set(compact('productDeal'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Deal id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productDeal = $this->ProductDeals->get($id);
        try {
            if ($this->ProductDeals->delete($productDeal)) {
                $this->Flash->success(__('The product deal has been deleted.'));
            } else {
                $this->Flash->error(__('The product deal could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The product deal could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
