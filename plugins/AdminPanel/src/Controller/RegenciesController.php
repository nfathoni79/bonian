<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * Regencies Controller
 *
 * @method \AdminPanel\Model\Entity\Regency[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RegenciesController extends AppController
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
            $data = $this->Regencies->find('all')
                ->select();

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['Regencies.name LIKE' => '%' . $search .'%']);
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
        $regencies = $this->paginate($this->Regencies);

        $this->set(compact('regencies'));
    }

    /**
     * View method
     *
     * @param string|null $id Regency id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $regency = $this->Regencies->get($id, [
            'contain' => []
        ]);

        $this->set('regency', $regency);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $regency = $this->Regencies->newEntity();
        if ($this->request->is('post')) {
            $regency = $this->Regencies->patchEntity($regency, $this->request->getData());
            if ($this->Regencies->save($regency)) {
                $this->Flash->success(__('The regency has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The regency could not be saved. Please, try again.'));
        }
        $this->set(compact('regency'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Regency id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $regency = $this->Regencies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $regency = $this->Regencies->patchEntity($regency, $this->request->getData());
            if ($this->Regencies->save($regency)) {
                $this->Flash->success(__('The regency has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The regency could not be saved. Please, try again.'));
        }
        $this->set(compact('regency'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Regency id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $regency = $this->Regencies->get($id);
        try {
            if ($this->Regencies->delete($regency)) {
                $this->Flash->success(__('The regency has been deleted.'));
            } else {
                $this->Flash->error(__('The regency could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The regency could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
