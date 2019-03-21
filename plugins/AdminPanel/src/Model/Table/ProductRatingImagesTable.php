<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use Cake\Core\Configure;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * ProductRatingImages Model
 *
 * @property \AdminPanel\Model\Table\ProductRatingsTable|\Cake\ORM\Association\BelongsTo $ProductRatings
 *
 * @method \AdminPanel\Model\Entity\ProductRatingImage get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\ProductRatingImage newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductRatingImage[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductRatingImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductRatingImage|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductRatingImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductRatingImage[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductRatingImage findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductRatingImagesTable extends Table
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

        $this->setTable('product_rating_images');
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
                'path' => 'webroot{DS}files{DS}{model}{DS}{field}{DS}{year}{DS}{month}{DS}',
                'nameCallback' => function ($tableObj, $entity, $data, $field, $settings) {
                    $ext = substr(strrchr($data['name'], '.'), 1);
                    return str_replace('-', '', Text::uuid()) . '.' . 'jpg'; //strtolower($ext);
                },
                'transformer' =>  function ($table, \AdminPanel\Model\Entity\ProductRatingImage $entity, $data, $field, $settings) {

                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
                    // Store the thumbnail in a temporary file
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                    // Use the Imagine library to DO THE THING
                    $size = new \Imagine\Image\Box(40, 40);
                    $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                    $imagine = new \Imagine\Gd\Imagine();
                    // Save that modified file to our temp file
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp);
                    // Now return the original *and* the thumbnail
                    return [
                        $data['tmp_name'] => $data['name'],
                        $tmp => 'thumbnail-' . $data['name'],
                    ];
                },
                'deleteCallback' => function ($path, $entity, $field, $settings) {
                    // When deleting the entity, both the original and the thumbnail will be removed
                    // when keepFilesOnDelete is set to false

                    return [
                        $path . $entity->{$field}
                    ];
                },
                'keepFilesOnDelete' => false
            ],
        ]);
        $this->belongsTo('ProductRatings', [
            'foreignKey' => 'product_rating_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.ProductRatings'
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

//        $validator
//            ->scalar('name')
//            ->maxLength('name', 100)
//            ->allowEmptyString('name');
//
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
        $rules->add($rules->existsIn(['product_rating_id'], 'ProductRatings'));

        return $rules;
    }
}
