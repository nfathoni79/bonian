<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * ProductPromotions Controller
 * @property \AdminPanel\Model\Table\ProductPromotionsTable $ProductPromotions
 *
 * @method \AdminPanel\Model\Entity\ProductPromotion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductPromotionsController extends AppController
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
            $data = $this->ProductPromotions->find('all')
                ->select();
            $data->contain(['Products']);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['ProductPromotions.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('productPromotions'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Promotion id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $productPromotion = $this->ProductPromotions->get($id, [
            'contain' => ['Products', 'Orders', 'ProductPromotionImages']
        ]);

        $this->set('productPromotion', $productPromotion);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productPromotion = $this->ProductPromotions->newEntity();
        if ($this->request->is('post')) {
            $productPromotion = $this->ProductPromotions->patchEntity($productPromotion, $this->request->getData());
            if ($this->ProductPromotions->save($productPromotion)) {
                $this->Flash->success(__('The product promotion has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product promotion could not be saved. Please, try again.'));
        }
        $products = $this->ProductPromotions->Products->find('list', ['limit' => 200]);
        $this->set(compact('productPromotion', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Promotion id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productPromotion = $this->ProductPromotions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productPromotion = $this->ProductPromotions->patchEntity($productPromotion, $this->request->getData());
            if ($this->ProductPromotions->save($productPromotion)) {
                $this->Flash->success(__('The product promotion has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product promotion could not be saved. Please, try again.'));
        }
        $products = $this->ProductPromotions->Products->find('list', ['limit' => 200]);
        $this->set(compact('productPromotion', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Promotion id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productPromotion = $this->ProductPromotions->get($id);
        try {
            if ($this->ProductPromotions->delete($productPromotion)) {
                $this->Flash->success(__('The product promotion has been deleted.'));
            } else {
                $this->Flash->error(__('The product promotion could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The product promotion could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
