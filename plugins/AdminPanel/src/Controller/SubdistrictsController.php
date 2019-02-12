<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * Subdistricts Controller
 * @property \AdminPanel\Model\Table\SubdistrictsTable $Subdistricts
 *
 * @method \AdminPanel\Model\Entity\Subdistrict[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubdistrictsController extends AppController
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
            $data = $this->Subdistricts->find('all')
                ->select();
            $data->contain(['Cities']);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['Subdistricts.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('subdistricts'));
    }

    /**
     * View method
     *
     * @param string|null $id Subdistrict id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $subdistrict = $this->Subdistricts->get($id, [
            'contain' => ['Cities', 'Branches', 'CustomerAddreses']
        ]);

        $this->set('subdistrict', $subdistrict);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subdistrict = $this->Subdistricts->newEntity();
        if ($this->request->is('post')) {
            $subdistrict = $this->Subdistricts->patchEntity($subdistrict, $this->request->getData());
            if ($this->Subdistricts->save($subdistrict)) {
                $this->Flash->success(__('The subdistrict has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subdistrict could not be saved. Please, try again.'));
        }
        $cities = $this->Subdistricts->Cities->find('list', ['limit' => 200]);
        $this->set(compact('subdistrict', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Subdistrict id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subdistrict = $this->Subdistricts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subdistrict = $this->Subdistricts->patchEntity($subdistrict, $this->request->getData());
            if ($this->Subdistricts->save($subdistrict)) {
                $this->Flash->success(__('The subdistrict has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subdistrict could not be saved. Please, try again.'));
        }
        $cities = $this->Subdistricts->Cities->find('list', ['limit' => 200]);
        $this->set(compact('subdistrict', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subdistrict id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subdistrict = $this->Subdistricts->get($id);
        try {
            if ($this->Subdistricts->delete($subdistrict)) {
                $this->Flash->success(__('The subdistrict has been deleted.'));
            } else {
                $this->Flash->error(__('The subdistrict could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The subdistrict could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
