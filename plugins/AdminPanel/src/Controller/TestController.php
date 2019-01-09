<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * Test Controller
 * nevix
 * @property \AdminPanel\Model\Table\TestTable $Test
 *
 * @method \AdminPanel\Model\Entity\Test[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TestController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $test = $this->paginate($this->Test);

        $this->set(compact('test'));
    }

    /**
     * View method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $test = $this->Test->get($id, [
            'contain' => []
        ]);

        $this->set('test', $test);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $test = $this->Test->newEntity();
        if ($this->request->is('post')) {
            $test = $this->Test->patchEntity($test, $this->request->getData());
            if ($this->Test->save($test)) {
                $this->Flash->success(__('The test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }
        $this->set(compact('test'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $test = $this->Test->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $test = $this->Test->patchEntity($test, $this->request->getData());
            if ($this->Test->save($test)) {
                $this->Flash->success(__('The test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }
        $this->set(compact('test'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $test = $this->Test->get($id);
        if ($this->Test->delete($test)) {
            $this->Flash->success(__('The test has been deleted.'));
        } else {
            $this->Flash->error(__('The test could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
