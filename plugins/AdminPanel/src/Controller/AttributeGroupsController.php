<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * AttributeGroups Controller
 * @property \AdminPanel\Model\Table\AttributeGroupsTable $AttributeGroups
 *
 * @method \AdminPanel\Model\Entity\AttributeGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AttributeGroupsController extends AppController
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
            $data = $this->AttributeGroups->find('all')
                ->select();

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['AttributeGroups.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('attributeGroups'));
    }

    /**
     * View method
     *
     * @param string|null $id Attribute Group id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $attributeGroup = $this->AttributeGroups->get($id, [
            'contain' => ['Attributes']
        ]);

        $this->set('attributeGroup', $attributeGroup);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attributeGroup = $this->AttributeGroups->newEntity();
        if ($this->request->is('post')) {
            $attributeGroup = $this->AttributeGroups->patchEntity($attributeGroup, $this->request->getData());
            if ($this->AttributeGroups->save($attributeGroup)) {
                $this->Flash->success(__('The attribute group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The attribute group could not be saved. Please, try again.'));
        }
        $this->set(compact('attributeGroup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Attribute Group id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $attributeGroup = $this->AttributeGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attributeGroup = $this->AttributeGroups->patchEntity($attributeGroup, $this->request->getData());
            if ($this->AttributeGroups->save($attributeGroup)) {
                $this->Flash->success(__('The attribute group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The attribute group could not be saved. Please, try again.'));
        }
        $this->set(compact('attributeGroup'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Attribute Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attributeGroup = $this->AttributeGroups->get($id);
        try {
            if ($this->AttributeGroups->delete($attributeGroup)) {
                $this->Flash->success(__('The attribute group has been deleted.'));
            } else {
                $this->Flash->error(__('The attribute group could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The attribute group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
