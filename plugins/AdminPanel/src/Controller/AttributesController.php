<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController;
use AdminPanel\Model\Entity\Attribute;
use Cake\Core\Configure;
use Cake\Validation\Validator;

/**
 * Attributes Controller
 * @property \AdminPanel\Model\Table\AttributesTable $Attributes
 * @property \AdminPanel\Model\Table\ProductCategoriesTable $ProductCategories
 *
 * @method \AdminPanel\Model\Entity\Attribute[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AttributesController extends AppController
{


    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.ProductCategories');
    }

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
            $data = $this->ProductCategories->find('all')
                ->select();
            $data->contain(['ParentProductCategories']);
//            $data->contain(['ParentAttributes', 'ProductCategories']);

            $data->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->isNotNull('ProductCategories.parent_id');
            });

            if ($query && is_array($query)) {
                if (isset($query['generalSearch'])) {
                    $search = $query['generalSearch'];
                    unset($query['generalSearch']);
                    /**
                        custom field for general search
                        ex : 'Users.email LIKE' => '%' . $search .'%'
                    **/
//                    $data->where(['Attributes.name LIKE' => '%' . $search .'%']);
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


        $this->set(compact('attributes'));
    }

    public function getCategory()
    {
        $this->disableAutoRender();
        $this->request->allowMethod('Post');
        $parent_id = $this->request->getData('parent_id');
        $parent_categories = [];
        if ($parent_id) {
            $parent_categories = $this->ProductCategories->find('list')
                ->where([
                    'parent_id' => $parent_id
                ])->toArray();
        }
        return $this->response->withType('application/json')
            ->withStringBody(json_encode($parent_categories));
    }

    /**
     * View method
     *
     * @param string|null $id Attribute id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $attribute = $this->Attributes->get($id, [
            'contain' => ['ParentAttributes', 'ProductCategories', 'ChildAttributes', 'ProductAttributes']
        ]);

        $this->set('attribute', $attribute);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attribute = $this->Attributes->newEntity();
        /*if ($this->request->is('post')) {
            $attribute = $this->Attributes->patchEntity($attribute, $this->request->getData());
            if ($this->Attributes->save($attribute)) {
                $this->Flash->success(__('The attribute has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The attribute could not be saved. Please, try again.'));
        }*/

        if ($this->request->is(['ajax'])) {
            $this->disableAutoRender();
            $response = [];
            $validator = new Validator();

            $validator
                ->requirePresence('product_category_id')
                ->hasAtLeast('product_category_id', 1, __d('AdminPanel', __d('AdminPanel','Silahkan pilih kategori')));


            $attributeDetail = new Validator();
            $attributeDetail
                ->requirePresence('name')
                ->notBlank('name', 'Atribut nama harus diisi');

            $attributeDetail
                ->requirePresence('value')
                ->hasAtLeast('value', 1, 'Tidak boleh kosong');

            $validator->addNestedMany('attribute', $attributeDetail);

            $error = $validator->errors($this->request->getData());
            if (empty($error)) {
                $product_category_id = $this->request->getData('product_category_id.0');

                if ($attributes = $this->request->getData('attribute')) {
                    foreach($attributes as $attribute) {
                        $attributeEntity = $this->Attributes->newEntity([
                            'product_category_id' => $product_category_id,
                            'name' => $attribute['name'],
                            'parent_id' => null
                        ]);

                        $this->Attributes->setLogMessageBuilder(function () use($attributeEntity){
                            return 'Manajemen Atribut - Penambahan atribut : '.$attributeEntity->get('name');
                        });

                        if ($this->Attributes->save($attributeEntity)) {
                            foreach($attribute['value'] as $child) {
                                $attributeChildEntity = $this->Attributes->newEntity([
                                    'product_category_id' => $product_category_id,
                                    'name' => $child,
                                    'parent_id' => $attributeEntity->get('id')
                                ]);
                                $this->Attributes->setLogMessageBuilder(function () use($attributeChildEntity){
                                    return 'Manajemen Atribut - Penambahan atribut : '.$attributeChildEntity->get('name');
                                });
                                $this->Attributes->save($attributeChildEntity);
                            }

                        }
                    }
                    if ($attributeEntity->get('id')) {
                        $this->Flash->success(__('The attribute has been saved.'));
                    }

                }
            }

            $response['error'] = $error;
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($response));
        }


        $parentAttributes = $this->Attributes->ParentAttributes->find('list', ['limit' => 200]);
        //$productCategories = $this->Attributes->ProductCategories->find('list', ['limit' => 200]);

        $productCategories = $this->Attributes->ProductCategories->find('list')
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->isNull('parent_id');
            })->toArray();

        $this->set(compact('attribute', 'parentAttributes', 'productCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Attribute id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function preview($category = null){
        if ($this->request->is(['ajax'])) {
            $this->disableAutoRender();
            $attribute = $this->Attributes->find()
                ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                    return $exp->isNull('parent_id');
                });
            $attribute = $attribute->where(['Attributes.product_category_id' => $category]);

            return $this->response->withType('application/json')
                ->withStringBody(json_encode($attribute));
        }
    }

    public function edit($id , $category = null)
    {
        $attribute = $this->Attributes->get($id, [
            'contain' => []
        ]);

        /*
        if ($this->request->is(['patch', 'post', 'put'])) {
            $attribute = $this->Attributes->patchEntity($attribute, $this->request->getData());
            if ($this->Attributes->save($attribute)) {
                $this->Flash->success(__('The attribute has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The attribute could not be saved. Please, try again.'));
        }
        */

        if ($this->request->is('ajax')) {
            $this->disableAutoRender();

            $response = [];
            $validator = new Validator();

            $validator
                ->requirePresence('product_category_id')
                ->hasAtLeast('product_category_id', 1, __d('AdminPanel', __d('AdminPanel','Silahkan pilih kategori')));


            $attributeDetail = new Validator();
            $attributeDetail
                ->requirePresence('name')
                ->notBlank('name', 'Atribut nama harus diisi');



            $validator->addNestedMany('attribute', $attributeDetail);


            if (empty($error)) {
                $product_category_id = $this->request->getData('product_category_id.0');

                $attribute = $this->Attributes->patchEntity($attribute, [
                    'product_category_id' => $product_category_id,
                    'name' => $this->request->getData('name'),
                ]);

                $this->Attributes->setLogMessageBuilder(function () use($attribute){
                    return 'Manajemen Atribut - Perubahan atribut : '.$attribute->get('name');
                });

                if ($this->Attributes->save($attribute)) {

                    if ($attributes = $this->request->getData('attribute')) {

                        //populate request child id
                        $attributeLists = [];
                        foreach($attributes as $val) {
                            array_push($attributeLists, $val['id']);
                        }

                        //get exists list from db
                        /**
                         * @var \AdminPanel\Model\Entity\Attribute[] $lists
                         */
                        $lists = $this->Attributes->find()
                            ->where([
                                'parent_id' => $id
                            ]);

                        foreach($lists as $val) {
                            if(!in_array($val->get('id'), $attributeLists)) {
                                $this->Attributes->delete($val);
                            }
                        }


                        foreach($attributes as $val) {

                            $getChild = $this->Attributes->find()
                                ->where(['id' => $val['id']])
                                ->first();

                            $childEntity = !empty($getChild) ? $getChild : $this->Attributes->newEntity([
                                'product_category_id' => $product_category_id,
                                'parent_id' => $id
                            ]);

                            $this->Attributes->patchEntity($childEntity, ['name' => $val['name']]);

                            $this->Attributes->save($childEntity);
                        }
                    }

                    $this->Flash->success(__('The attribute has been saved.'));
                }

            }

            $response['error'] = $validator->errors($this->request->getData());
            return $this->response->withType('application/json')
                ->withStringBody(json_encode($response));

        }

        //$parentAttributes = $this->Attributes->ParentAttributes->find('list', ['limit' => 200]);

        $productCategories = $this->Attributes->ProductCategories->find('list')
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->isNull('parent_id');
            })->toArray();

        /**
         * @var \AdminPanel\Model\Entity\ProductCategory[] $path
         */
        $path = $this->Attributes->ProductCategories->find('path', ['for' => $attribute->get('product_category_id')])->toArray();
        $levels = $selected =  [];
        $levels[1] = $productCategories;
        foreach($path as $key => $val) {
            $selected[$key + 1] = $val->get('id');
            $levels[$key + 2] = $this->Attributes->ProductCategories->find('list')
                ->where([
                    'parent_id' => $val->get('id')
                ])->toArray();
        }
        $levels = array_filter($levels);

        /**
         * get value list from parent
         */

        $childValues = $this->Attributes->find('list')
            ->where(['parent_id' => $id, 'product_category_id' => $category])
            ->toArray();



        $this->set(compact('attribute', 'productCategories', 'levels', 'selected', 'childValues'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Attribute id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attribute = $this->Attributes->get($id);
        try {
            $this->Attributes->setLogMessageBuilder(function () use($attribute){
                return 'Manajemen Atribut - Penghapusan data atribut : '.$attribute->get('name');
            });
            if ($this->Attributes->delete($attribute)) {
                $this->Flash->success(__('The attribute has been deleted.'));
            } else {
                $this->Flash->error(__('The attribute could not be deleted. Please, try again.'));
            }
        } catch (Exception $e) {
            $this->Flash->error(__('The attribute could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function import(){

        Configure::write('debug', 0);
        set_time_limit(600);
        if ($this->request->is('post')) {

            $this->Attributes->getConnection()->begin();
            $data = $this->request->getData('files');
            $file = $data['tmp_name'];
            $handle = fopen($file, "r");
            $count = 0;

            $success = true;
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $count++;
                if ($count == 1) {
                    continue;
                }

                $findMainCategory = $this->ProductCategories->find()
                    ->where(['ProductCategories.name' => trim($row[2])])
                    ->first();
                if($findMainCategory){
                    if(!empty($row[3])){

                        $explode = array_filter(array_map('trim',explode('|', $row[3])));
                        foreach($explode as $vals){
                            $explodes = array_filter(array_map('trim',explode(':', $vals)));
                            $parents = trim($explodes[0]);


                            $findParentName = $this->Attributes->find()
                                ->where(['Attributes.name' => $parents])
                                ->first();
                            if($findParentName){
                                $id = $findParentName->get('id');
                            }else{
                                $newEntities = $this->Attributes->newEntity();
                                $newEntities = $this->Attributes->patchEntity($newEntities, $this->request->getData());
                                $newEntities->set('parent_id', null);
                                $newEntities->set('product_category_id', $findMainCategory->get('id'));
                                $newEntities->set('name', trim($parents));
                                $this->Attributes->setLogMessageBuilder(function () use($newEntities){
                                    return 'Manajemen Atribut - Import data atribut : '.$newEntities->get('name');
                                });
                                if($this->Attributes->save($newEntities))
                                $id = $newEntities->get('id');
                            }
                            if($id){
                                $values = array_filter(array_map('trim',explode(',', $explodes[1])));

                                foreach($values as $v){
                                    $nameAttr = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', trim($v));
                                    $findValueName = $this->Attributes->find()
                                        ->where(['Attributes.product_category_id' => $findMainCategory->get('id'),'Attributes.name' => $nameAttr, 'Attributes.parent_id !=' => NULL])
                                        ->first();
                                    if(empty($findValueName)){
                                        $newEntity = $this->Attributes->newEntity();
                                        $newEntity = $this->Attributes->patchEntity($newEntity, $this->request->getData());
                                        $newEntity->set('parent_id', $id);
                                        $newEntity->set('product_category_id', $findMainCategory->get('id'));
                                        $newEntity->set('name', $nameAttr);
                                        if($this->Attributes->save($newEntity)){

                                        }else{
                                            $success = false;
                                            $this->Flash->error(__('Data tidak valid pada baris ke '.$count.' "'.trim($v).'"'));
                                            return $this->redirect(['action' => 'index']);
                                            break;
                                        }
                                    }
                                }
                            }else{
                                $success = false;
                                $this->Flash->error(__('gagal menyimpan data untuk row ke '.$count));
                                return $this->redirect(['action' => 'index']);
                                break;
                            }

                        }
                    }else{

                        $success = false;
                        $this->Flash->error(__('data tidak di temukan pada baris ke '.$count.' tidak ditemukan.'));
                        return $this->redirect(['action' => 'index']);
                        break;
                    }
                }else{

                    $success = false;
                    $this->Flash->error(__('Kategori level 3 pada baris ke '.$count.' tidak ditemukan.'));
                    return $this->redirect(['action' => 'index']);
                    break;
                }
            }

            if($success){
                $this->Attributes->getConnection()->commit();
                $this->Flash->success(__('Success import file'));
            }else{
                $this->Attributes->getConnection()->rollback();
            }
        }

        $this->redirect(['action' => 'index']);
    }
}
