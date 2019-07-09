<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use Cake\Database\Expression\QueryExpression;
use Cake\Database\Query;

/**
 * Faqs Controller
 * @property \AdminPanel\Model\Table\FaqsTable $Faqs
 *
 * @method \AdminPanel\Model\Entity\Faq[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FaqsController extends AppController
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
            $data = $this->Faqs->find('all')
                ->select();
            $data->contain(['FaqCategories']);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
//                    $data->where(['Faqs.name LIKE' => '%' . $search .'%']);

                    $data->where(function (QueryExpression $exp, Query $query) use($search) {
                        $orConditions = $exp->or_([
                            'FaqCategories.name LIKE' => '%' . $search .'%',
                            'Faqs.judul LIKE' => '%' . $search .'%',
                        ]);
                        return $exp
                            ->add($orConditions);
                    });

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


        $this->set(compact('faqs'));
    }

    /**
     * View method
     *
     * @param string|null $id Faq id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $faq = $this->Faqs->get($id, [
            'contain' => ['FaqCategories']
        ]);

        $this->set('faq', $faq);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $faq = $this->Faqs->newEntity();
        if ($this->request->is('post')) {
            $faq = $this->Faqs->patchEntity($faq, $this->request->getData());
            if ($this->Faqs->save($faq)) {
                $this->Flash->success(__('The faq has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The faq could not be saved. Please, try again.'));
        }
        $faqCategories = $this->Faqs->FaqCategories->find('list', ['limit' => 200]);
        $this->set(compact('faq', 'faqCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Faq id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $faq = $this->Faqs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $faq = $this->Faqs->patchEntity($faq, $this->request->getData());
            if ($this->Faqs->save($faq)) {
                $this->Flash->success(__('The faq has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The faq could not be saved. Please, try again.'));
        }
        $faqCategories = $this->Faqs->FaqCategories->find('list', ['limit' => 200]);
        $this->set(compact('faq', 'faqCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Faq id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $faq = $this->Faqs->get($id);
        try {
            if ($this->Faqs->delete($faq)) {
                $this->Flash->success(__('The faq has been deleted.'));
            } else {
                $this->Flash->error(__('The faq could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The faq could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
