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
 * ProductImages Model
 *
 * @property \AdminPanel\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \AdminPanel\Model\Table\ProductImageSizesTable|\Cake\ORM\Association\HasMany $ProductImageSizes
 *
 * @method \AdminPanel\Model\Entity\ProductImage get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\ProductImage newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductImage[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductImage|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductImage[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductImage findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductImagesTable extends Table
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

        $this->setTable('product_images');
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
                'transformer' =>  function ($table, \AdminPanel\Model\Entity\ProductImage $entity, $data, $field, $settings) {

                    //$extension = pathinfo($data['name'], PATHINFO_EXTENSION);


                    $tmp_name = tempnam(sys_get_temp_dir(), 'upload') . '.' . 'jpg'; //force convert to jpg

                    /*
                    $imagine = new \Imagine\Gd\Imagine();

                    // Save that modified file to our temp file
                    $image = $imagine->open($data['tmp_name']);


                    //processing watermark
                    if ($path = Configure::read('Images.watermark')) {
                        $watermark_full_path = ROOT . DS . $path;
                        if (file_exists($watermark_full_path)) {
                            $size      = $image->getSize();
                            $watermark = $imagine->open($watermark_full_path);
                            $transparent = $watermark->palette()->color(array(0, 0, 0), 80);
                            $transparent->darken(10);
                            $watermark->effects()->colorize($transparent);
                            $wSize     = $watermark->getSize();
                            $bottomRight = new \Imagine\Image\Point($size->getWidth() - $wSize->getWidth(),
                                $size->getHeight() - $wSize->getHeight() - 10);
                            $image->paste($watermark, $bottomRight, 90);
                        }
                    }

                    $image->save($tmp_name);
                    */
                    Image::configure(array('driver' => 'gd'));
                    $img = Image::make($data['tmp_name']);
                    if ($path = Configure::read('Images.watermark')) {
                        $watermark_full_path = ROOT . DS . $path;
                        if (file_exists($watermark_full_path)) {
                            $png = Image::make($watermark_full_path);
                            $img->insert($png, 'bottom-right', 10, 10);
                        }
                    }

                    $img->save($tmp_name);


                    //after
                    $data['tmp_name'] = $tmp_name;


                    // Now return the original *and* the thumbnail
                    return [
                        $data['tmp_name'] => $data['name'],
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

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.Products'
        ]);
        $this->hasMany('ProductImageSizes', [
            'foreignKey' => 'product_image_id',
            'className' => 'AdminPanel.ProductImageSizes'
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

        /*$validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->allowEmptyString('name');*/

        /*$validator
            ->integer('primary')
            ->requirePresence('primary', 'create')
            ->allowEmptyString('primary', false);*/

        return $validator;
    }

    public function getNameImageById($id = null){
        $getImage = $this->find()
            ->where(['product_id' => $id])
            ->first();
        return $getImage['name'];
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
        //$rules->add($rules->existsIn(['product_id'], 'Products'));

        return $rules;
    }

    /**
     * @param \Cake\Event\Event $event
     * @param \AdminPanel\Model\Entity\ProductImage $entity
     * @param \ArrayObject $options
     */
    public function afterSave(\Cake\Event\Event $event,  \AdminPanel\Model\Entity\ProductImage $entity, \ArrayObject $options)
    {
        if ($entity->isNew()) {
            $this->ProductImageSizes->resize($entity, 300, 300);
            $this->ProductImageSizes->resize($entity, 450, 450);
        }
    }

    /**
     * @param \Cake\Event\Event $event
     * @param \AdminPanel\Model\Entity\ProductImage $entity
     * @param \ArrayObject $options
     */
    public function beforeDelete(\Cake\Event\Event $event,  \AdminPanel\Model\Entity\ProductImage $entity, \ArrayObject $options) {
        /**
         * @var \AdminPanel\Model\Entity\ProductImageSize[] $data
         */
        $data = $this->ProductImageSizes->find()
            ->where([
                'product_image_id' => $entity->get('id')
            ]);

        foreach($data as $file) {
            if (file_exists(ROOT . DS . $file->get('path'))) {
                @unlink(ROOT . DS . $file->get('path'));
                $this->ProductImageSizes->delete($file);
            }
        }

    }
}
