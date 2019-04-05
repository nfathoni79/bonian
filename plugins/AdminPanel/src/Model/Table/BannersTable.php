<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;

/**
 * Banners Model
 *
 * @property \AdminPanel\Model\Table\ProductCategoriesTable|\Cake\ORM\Association\BelongsTo $ProductCategories
 *
 * @method \AdminPanel\Model\Entity\Banner get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\Banner newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\Banner[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Banner|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Banner|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\Banner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Banner[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\Banner findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BannersTable extends Table
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

        $this->setTable('banners');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'name' => [
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
                    $ext = substr(strrchr($data['name'], '.'), 1);
                    return str_replace('-', '', Text::uuid()) . '.' . 'jpg'; //strtolower($ext);
                },
                'transformer' =>  function ($table, \AdminPanel\Model\Entity\Banner $entity, $data, $field, $settings) {
                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);


                    // Store the thumbnail in a temporary file
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;

                    $tmp_name = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;

                    $size = new \Imagine\Image\Box(796, 235);
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

        $this->belongsTo('ProductCategories', [
            'foreignKey' => 'product_category_id',
            'className' => 'AdminPanel.ProductCategories'
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
            ->scalar('position')
            ->notBlank('position');

//        $validator
//            ->scalar('dir')
//            ->maxLength('dir', 255)
//            ->allowEmptyString('dir');
//
//        $validator
//            ->integer('size')
//            ->allowEmptyString('size');
//
//        $validator
//            ->scalar('type')
//            ->maxLength('type', 150)
//            ->allowEmptyString('type');

        $validator->provider('upload', \Josegonzalez\Upload\Validation\DefaultValidation::class);

        $validator->add('name', 'fileAboveMinHeight', [
            'rule' => ['isAboveMinHeight', 235],
            'message' => 'This image should at least be 235px high',
            'provider' => 'upload'
        ]);
        $validator->add('name', 'fileAboveMinWidth', [
            'rule' => ['isAboveMinWidth', 796],
            'message' => 'This image should at least be 796px wide',
            'provider' => 'upload'
        ]);
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

        return $rules;
    }
}
