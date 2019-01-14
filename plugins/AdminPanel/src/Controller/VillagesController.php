<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * Villages Controller
 * @property \AdminPanel\Model\Table\VillagesTable $Villages
 *
 * @method \AdminPanel\Model\Entity\Village[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VillagesController extends AppController
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
            $data = $this->Villages->find('all')
                ->select();
            $data->contain(['Districts']);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['Villages.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('villages'));
    }

    /**
     * View method
     *
     * @param string|null $id Village id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $village = $this->Villages->get($id, [
            'contain' => ['Districts', 'CustomerAddresses']
        ]);

        $this->set('village', $village);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $village = $this->Villages->newEntity();
        if ($this->request->is('post')) {
            $village = $this->Villages->patchEntity($village, $this->request->getData());
            if ($this->Villages->save($village)) {
                $this->Flash->success(__('The village has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The village could not be saved. Please, try again.'));
        }
        $districts = $this->Villages->Districts->find('list', ['limit' => 200]);
        $this->set(compact('village', 'districts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Village id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $village = $this->Villages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $village = $this->Villages->patchEntity($village, $this->request->getData());
            if ($this->Villages->save($village)) {
                $this->Flash->success(__('The village has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The village could not be saved. Please, try again.'));
        }
        $districts = $this->Villages->Districts->find('list', ['limit' => 200]);
        $this->set(compact('village', 'districts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Village id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $village = $this->Villages->get($id);
        try {
            if ($this->Villages->delete($village)) {
                $this->Flash->success(__('The village has been deleted.'));
            } else {
                $this->Flash->error(__('The village could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The village could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
