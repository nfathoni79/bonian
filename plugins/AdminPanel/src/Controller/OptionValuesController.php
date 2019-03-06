<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * OptionValues Controller
 * @property \AdminPanel\Model\Table\OptionValuesTable $OptionValues
 *
 * @method \AdminPanel\Model\Entity\OptionValue[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OptionValuesController extends AppController
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
            $data = $this->OptionValues->find('all')
                ->select();
            $data->contain(['Options']);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['OptionValues.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('optionValues'));
    }

    /**
     * View method
     *
     * @param string|null $id Option Value id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $optionValue = $this->OptionValues->get($id, [
            'contain' => ['Options', 'ProductOptionValues']
        ]);

        $this->set('optionValue', $optionValue);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $optionValue = $this->OptionValues->newEntity();
        if ($this->request->is('post')) {
            $optionValue = $this->OptionValues->patchEntity($optionValue, $this->request->getData());
            $this->OptionValues->setLogMessageBuilder(function () use($optionValue){
                return 'Manajemen Varian - penambahan varian : '.$optionValue->get('name');
            });
            if ($this->OptionValues->save($optionValue)) {
                $this->Flash->success(__('The option value has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The option value could not be saved. Please, try again.'));
        }
        $options = $this->OptionValues->Options->find('list', ['limit' => 200]);
        $this->set(compact('optionValue', 'options'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Option Value id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $optionValue = $this->OptionValues->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $optionValue = $this->OptionValues->patchEntity($optionValue, $this->request->getData());
            $this->OptionValues->setLogMessageBuilder(function () use($optionValue){
                return 'Manajemen Varian - perubahan varian : '.$optionValue->get('name');
            });
            if ($this->OptionValues->save($optionValue)) {
                $this->Flash->success(__('The option value has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The option value could not be saved. Please, try again.'));
        }
        $options = $this->OptionValues->Options->find('list', ['limit' => 200]);
        $this->set(compact('optionValue', 'options'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Option Value id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $optionValue = $this->OptionValues->get($id);
        try {
            $this->OptionValues->setLogMessageBuilder(function () use($optionValue){
                return 'Manajemen Varian - penghapusan varian : '.$optionValue->get('name');
            });
            if ($this->OptionValues->delete($optionValue)) {
                $this->Flash->success(__('The option value has been deleted.'));
            } else {
                $this->Flash->error(__('The option value could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The option value could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
