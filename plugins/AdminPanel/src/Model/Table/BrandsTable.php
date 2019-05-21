<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Validation\Validator;

/**
 * Brands Model
 *
 * @property \AdminPanel\Model\Table\ProductCategoriesTable|\Cake\ORM\Association\BelongsTo $ProductCategories
 * @property \AdminPanel\Model\Table\BrandsTable|\Cake\ORM\Association\BelongsTo $ParentBrands
 * @property \AdminPanel\Model\Table\BrandsTable|\Cake\ORM\Association\HasMany $ChildBrands
 * @property \AdminPanel\Model\Table\ProductsTable|\Cake\ORM\Association\HasMany $Products
 * @property \AdminPanel\Model\Table\CategoryToBrandsTable|\Cake\ORM\Association\HasMany $CategoryToBrands
 *
 * @method \AdminPanel\Model\Entity\Brand get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\Brand newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\Brand[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Brand|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Brand|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Brand patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Brand[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Brand findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class BrandsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('brands');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Tree');
        $this->addBehavior('Timestamp');

        $this->addBehavior('Elastic/ActivityLogger.Logger', [
            'scope' => [
                'Brands'
            ],
            'issuer' => \Cake\Core\Configure::read('User') ?
                \Cake\ORM\TableRegistry::get('AdminPanel.Users')->get(\Cake\Core\Configure::read('User.id'))
                : null
        ]);

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'logo' => [
                'fields' => [
                    // if these fields or their defaults exist
                    // the values will be set.
                    'dir' => 'dir', // defaults to `dir`
                    'size' => 'size', // defaults to `size`
                    'type' => 'type', // defaults to `type`
                ],
//                'path' => 'webroot{DS}files{DS}{model}{DS}{field}{DS}{year}{DS}{month}{DS}',
                'nameCallback' => function ($tableObj, $entity, $data, $field, $settings) {
                    //$ext = substr(strrchr($data['name'], '.'), 1);
                    //return time() . rand(100, 999) . '.' . $ext;
                    //$ext = substr(strrchr($data['logo'], '.'), 1);
                    return str_replace('-', '', Text::uuid()) . '.' . 'jpg';
                },
                'transformer' =>  function ($table, \AdminPanel\Model\Entity\Brand $entity, $data, $field, $settings) {
                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);





                    // Store the thumbnail in a temporary file
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;

                    $tmp_name = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;

                    $size = new \Imagine\Image\Box(160, 72);
                    $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
                    $imagine = new \Imagine\Gd\Imagine();

                    // Save that modified file to our temp file
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp_name);

                    $data['tmp_name'] = $tmp_name;



                    //process delete old image
                    $original = $entity->getOriginal('path');
                    if ($original) {
                        $path = $this->getPathProcessor($entity, $data, $field, $settings);
                        $basename = rtrim(ROOT, DS) . DS . $path->basepath();

                        if (file_exists($basename . $original)) {
                            unlink($basename . $original);
                        }

                        if (file_exists($basename . 'thumbnail-' . $original)) {
                            unlink($basename . 'thumbnail-' . $original);
                        }
                    }


                    // Now return the original *and* the thumbnail
                    return [
                        $data['tmp_name'] => $data['name'],
                        //$tmp => 'thumbnail-' . $data['name'],
                    ];
                }
            ],
        ]);


        $this->belongsTo('ProductCategories', [
            'foreignKey' => 'product_category_id',
            'className' => 'AdminPanel.ProductCategories'
        ]);
        $this->belongsTo('ParentBrands', [
            'className' => 'AdminPanel.Brands',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildBrands', [
            'className' => 'AdminPanel.Brands',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('Products', [
            'foreignKey' => 'brand_id',
            'className' => 'AdminPanel.Products'
        ]);
        $this->hasMany('CategoryToBrands', [
            'foreignKey' => 'brand_id',
            'className' => 'AdminPanel.CategoryToBrands'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['product_category_id'], 'ProductCategories'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentBrands'));

        return $rules;
    }

    /**
     * @param $name
     * @param $category_id
     * @return mixed
     */
    public function getId($name, $category_id)
    {
        $name = trim($name);
        $brandEntity = $this->find()
            ->where([
                'name' => $name
            ])
            ->first();

        if ($brandEntity) {
            return $brandEntity->get('id');
        } else {
            $brandEntity = $this->newEntity();
            $brandEntity->parent_id = null;
            $brandEntity->product_category_id = null;
            $brandEntity->name = $name;
            if ($this->save($brandEntity)) {

                $categoryToBrandEntity = $this->CategoryToBrands->find()
                    ->where([
                        'product_category_id' => $category_id,
                        'brand_id' => $brandEntity->get('id')
                    ])
                    ->first();

                if (!$categoryToBrandEntity) {
                    $categoryToBrandEntity = $this->CategoryToBrands->newEntity();
                    $categoryToBrandEntity->product_category_id = $category_id;
                    $categoryToBrandEntity->brand_id = $brandEntity->get('id');
                    $this->CategoryToBrands->save($categoryToBrandEntity);
                }

                return $brandEntity->get('id');
            }
        }

    }


    public function getId_($slug,$categoryId = null){
        $find = $this->find()
            ->where(['name' => $slug,'product_category_id' => $categoryId,])
            ->first();
        if($find){
            return $find->get('id');
        }else{
            $entity = $this->newEntity();
            $entity->parent_id = null;
            $entity->product_category_id = $categoryId;
            $entity->name = $slug;
            if($this->save($entity)){
                return $entity->get('id');
            }
        }
    }
}
