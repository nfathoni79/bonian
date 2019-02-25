<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * GameWheels Controller
 * @property \AdminPanel\Model\Table\GameWheelsTable $GameWheels
 *
 * @method \AdminPanel\Model\Entity\GameWheel[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GameWheelsController extends AppController
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
            $data = $this->GameWheels->find('all')
                ->select();

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['GameWheels.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('gameWheels'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Game Wheel id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gameWheel = $this->GameWheels->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gameWheel = $this->GameWheels->patchEntity($gameWheel, $this->request->getData());
            if ($this->GameWheels->save($gameWheel)) {
                $this->Flash->success(__('The game wheel has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The game wheel could not be saved. Please, try again.'));
        }
        $this->set(compact('gameWheel'));
    }

}
