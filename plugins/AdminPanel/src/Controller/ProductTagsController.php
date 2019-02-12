<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * ProductTags Controller
 * @property \AdminPanel\Model\Table\ProductTagsTable $ProductTags
 *
 * @method \AdminPanel\Model\Entity\ProductTag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductTagsController extends AppController
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
            $data = $this->ProductTags->find('all')
                ->select();
            $data->contain(['Products', 'Tags']);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['ProductTags.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('productTags'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Tag id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $productTag = $this->ProductTags->get($id, [
            'contain' => ['Products', 'Tags']
        ]);

        $this->set('productTag', $productTag);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productTag = $this->ProductTags->newEntity();
        if ($this->request->is('post')) {
            $productTag = $this->ProductTags->patchEntity($productTag, $this->request->getData());
            if ($this->ProductTags->save($productTag)) {
                $this->Flash->success(__('The product tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product tag could not be saved. Please, try again.'));
        }
        $products = $this->ProductTags->Products->find('list', ['limit' => 200]);
        $tags = $this->ProductTags->Tags->find('list', ['limit' => 200]);
        $this->set(compact('productTag', 'products', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Tag id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productTag = $this->ProductTags->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productTag = $this->ProductTags->patchEntity($productTag, $this->request->getData());
            if ($this->ProductTags->save($productTag)) {
                $this->Flash->success(__('The product tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product tag could not be saved. Please, try again.'));
        }
        $products = $this->ProductTags->Products->find('list', ['limit' => 200]);
        $tags = $this->ProductTags->Tags->find('list', ['limit' => 200]);
        $this->set(compact('productTag', 'products', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Tag id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productTag = $this->ProductTags->get($id);
        try {
            if ($this->ProductTags->delete($productTag)) {
                $this->Flash->success(__('The product tag has been deleted.'));
            } else {
                $this->Flash->error(__('The product tag could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The product tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
