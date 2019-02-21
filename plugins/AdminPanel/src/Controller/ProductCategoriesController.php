<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;

/**
 * ProductCategories Controller
 * @property \AdminPanel\Model\Table\ProductCategoriesTable $ProductCategories
 *
 * @method \AdminPanel\Model\Entity\ProductCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductCategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.ProductCategories');
    }


    public function index()
    {


        if ($this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('ajax');

            $pagination = $this->request->getData('pagination');
            $sort = $this->request->getData('sort');
            $query = $this->request->getData('query');

            /** custom default query : select, where, contain, etc. **/
            $data = $this->ProductCategories->find('all')
                ->select();
            $data->contain(['ParentProductCategories']);

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
                    $data->where(['ProductCategories.name LIKE' => '%' . $search .'%']);
                    $data->where(['ParentProductCategories.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('productCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $productCategory = $this->ProductCategories->get($id, [
            'contain' => ['ParentProductCategories', 'ChildProductCategories', 'ProductToCategories']
        ]);

        $this->set('productCategory', $productCategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productCategory = $this->ProductCategories->newEntity();
        if ($this->request->is('post')) {
            debug($this->request->getData());
            exit;
            $productCategory = $this->ProductCategories->patchEntity($productCategory, $this->request->getData());
            if ($this->ProductCategories->save($productCategory)) {
                $this->Flash->success(__('The product category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product category could not be saved. Please, try again.'));
        }
        $parentProductCategories = $this->ProductCategories->ParentProductCategories->find('list', ['limit' => 200, 'order' => 'ParentProductCategories.lft ASC']);
        $this->set(compact('productCategory', 'parentProductCategories'));
    }


    public function import(){
        if ($this->request->is('post')) {

            $data = $this->request->data['files'];
            $file = $data['tmp_name'];
            $handle = fopen($file, "r");
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
//                0 main, 1 submain, 2 subsubmain, 3 desctioption
                for($i=0;$i<=3;$i++){
                    switch ($i) {
                        case 0:
                            $findMainCategory = $this->ProductCategories->find()
                            ->where(['ProductCategories.name' => $row[0]])
                            ->first();
                            if(empty($findMainCategory)){
                                $newEntity = $this->ProductCategories->newEntity();
                                $newEntity = $this->ProductCategories->patchEntity($newEntity, $this->request->getData());
                                $newEntity->set('parent_id', null);
                                $newEntity->set('name', $row[$i]);
                                $newEntity->set('slug', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row[$i]))));
                                $newEntity->set('description', '-');
                                $this->ProductCategories->save($newEntity);
                            }
                        break;
                        case 1:
                            $findMainCategory = $this->ProductCategories->find()
                            ->where(['ProductCategories.name' => $row[0]])
                            ->first();
                            if(!empty($findMainCategory)){
                                $newEntity = $this->ProductCategories->newEntity();
                                $newEntity = $this->ProductCategories->patchEntity($newEntity, $this->request->getData());
                                $newEntity->set('parent_id', $findMainCategory->get('id'));
                                $newEntity->set('name', $row[$i]);
                                $newEntity->set('slug', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row[$i]))));
                                $newEntity->set('description', '-');
                                $this->ProductCategories->save($newEntity);
                            }
                        break;
                        case 2:
                            $findMainCategory = $this->ProductCategories->find()
                            ->where(['ProductCategories.name' => $row[1]])
                            ->first();
                            if(!empty($findMainCategory)){
                                $newEntity = $this->ProductCategories->newEntity();
                                $newEntity = $this->ProductCategories->patchEntity($newEntity, $this->request->getData());
                                $newEntity->set('parent_id', $findMainCategory->get('id'));
                                $newEntity->set('name', $row[$i]);
                                $newEntity->set('slug', strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row[$i]))));
                                $newEntity->set('description', '-');
                                $this->ProductCategories->save($newEntity);
                            }
                        break;
                    }
                }

            }
            $this->Flash->success(__('Success import file'));
            $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productCategory = $this->ProductCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productCategory = $this->ProductCategories->patchEntity($productCategory, $this->request->getData());
            if ($this->ProductCategories->save($productCategory)) {
                $this->Flash->success(__('The product category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product category could not be saved. Please, try again.'));
        }
        //$parentProductCategories = $this->ProductCategories->ParentProductCategories->find('list', ['limit' => 2000]);
        $parentProductCategories = $this->ProductCategories->ParentProductCategories->find('treeList', [
            'keyPath' => 'id',
            'valuePath' => 'name',
            'spacer' => '&nbsp;&nbsp;&nbsp;'
        ]);
        $this->set(compact('productCategory', 'parentProductCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productCategory = $this->ProductCategories->get($id);
        try {
            if ($this->ProductCategories->delete($productCategory)) {
                $this->Flash->success(__('The product category has been deleted.'));
            } else {
                $this->Flash->error(__('The product category could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The product category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
