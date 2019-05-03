<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductCategories Model
 *
 * @property \AdminPanel\Model\Table\ProductCategoriesTable|\Cake\ORM\Association\BelongsTo $ParentProductCategories
 * @property \AdminPanel\Model\Table\ProductCategoriesTable|\Cake\ORM\Association\HasMany $ChildProductCategories
 * @property \AdminPanel\Model\Table\ProductToCategoriesTable|\Cake\ORM\Association\HasMany $ProductToCategories
 *
 * @method \AdminPanel\Model\Entity\ProductCategory get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\ProductCategory newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductCategory[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class ProductCategoriesTable extends Table
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

        $this->setTable('product_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Tree');

        $this->addBehavior('Elastic/ActivityLogger.Logger', [
            'scope' => [
                'ProductCategories'
            ],
            'issuer' => \Cake\Core\Configure::read('User') ?
                \Cake\ORM\TableRegistry::get('AdminPanel.Users')->get(\Cake\Core\Configure::read('User.id'))
                : null
        ]);

        $this->belongsTo('ParentProductCategories', [
            'className' => 'AdminPanel.ProductCategories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildProductCategories', [
            'className' => 'AdminPanel.ProductCategories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ProductToCategories', [
            'foreignKey' => 'product_category_id',
            'className' => 'AdminPanel.ProductToCategories'
        ]);

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'path' => [
                'nameCallback' => function ($tableObj, $entity, $data, $field, $settings) {
                    $ext = substr(strrchr($data['name'], '.'), 1);
                    return time() . rand(100, 999) . '.' . $ext;
                },
                'transformer' =>  function ($table, \AdminPanel\Model\Entity\ProductCategory $entity, $data, $field, $settings) {
                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);


                    // Store the thumbnail in a temporary file
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;

                    $tmp_name = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;

                    $size = new \Imagine\Image\Box(300, 300);
                    $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
                    $imagine = new \Imagine\Gd\Imagine();

                    // Save that modified file to our temp file
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp_name);

                    $data['tmp_name'] = $tmp_name;

                    // Use the Imagine library to DO THE THING
                    $size = new \Imagine\Image\Box(80, 80);
                    $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
                    $imagine = new \Imagine\Gd\Imagine();

                    // Save that modified file to our temp file
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp);

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
                        $tmp => 'thumbnail-' . $data['name'],
                    ];
                }
            ],
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
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->allowEmptyString('slug', false)
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

//        $validator
//            ->scalar('description')
//            ->maxLength('description', 255)
//            ->requirePresence('description', 'create')
//            ->allowEmptyString('description', false);

//        $validator
//            ->notEmpty('path')
//            ->add('path', 'mime', [
//                'rule' => ['mimeType', ['image/jpeg', 'image/png']],
//                'message' => __d('MemberPanel', 'These files extension are allowed: .{0}', '.png .jpeg and .jpg')
//            ])
//            ->add('path', 'size', [
//                'rule' => function($field) {
//                    return $field['size'] <= (1024 * 1024 * 4);
//                },
//                'message' => __d('MemberPanel', 'max File size are allowed: {0}', '4MB')
//            ]);

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
        $rules->add($rules->isUnique(['slug']));
        $rules->add($rules->existsIn(['parent_id'], 'ParentProductCategories'));

        return $rules;
    }


    public function getIdByName($slug = null){
        $getCategory = $this->find()
            ->where(['name' => $slug])
            ->first();
        return $getCategory['id'];
    }
}
