<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


/**
 * ProductImageSizes Model
 *
 * @property \AdminPanel\Model\Table\ProductImagesTable|\Cake\ORM\Association\BelongsTo $ProductImages
 *
 * @method \AdminPanel\Model\Entity\ProductImageSize get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\ProductImageSize newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductImageSize[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductImageSize|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductImageSize|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ProductImageSize patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductImageSize[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ProductImageSize findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductImageSizesTable extends Table
{

    protected $cachePath = null;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('product_image_sizes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ProductImages', [
            'foreignKey' => 'product_image_id',
            'joinType' => 'INNER',
            'className' => 'AdminPanel.ProductImages'
        ]);

        $this->cachePath =    'webroot' . DS . 'images' . DS;
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
            ->scalar('dimension')
            ->maxLength('dimension', 9)
            ->requirePresence('dimension', 'create')
            ->allowEmptyString('dimension', false);

        $validator
            ->scalar('path')
            ->maxLength('path', 255)
            ->requirePresence('path', 'create')
            ->allowEmptyString('path', false);

        $validator
            ->integer('size')
            ->allowEmptyString('size');

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
        $rules->add($rules->existsIn(['product_image_id'], 'ProductImages'));

        return $rules;
    }

    /**
     * @param $newPath
     * @return string|null
     */
    public function setPath($newPath)
    {
        $this->cachePath =  $newPath . DS;
        return $this->cachePath;
    }


    /**
     * @param \AdminPanel\Model\Entity\ProductImage $entity
     * @param $width
     * @param $height
     * @return \AdminPanel\Model\Entity\ProductImageSize|bool
     */
    public function resize(\AdminPanel\Model\Entity\ProductImage $entity, $width, $height, $save = true)
    {
        //WWW_ROOT
        $path = ROOT . DS . $entity->get('dir') . $entity->get('name');
        if (file_exists($path)) {
            $imagine = new \Imagine\Gd\Imagine();
            $o = $imagine->open($path);


            $size = new \Imagine\Image\Box($width, $height);
            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

            $dimension = $size->getWidth() . 'x' . $size->getHeight();
            $new_location = $this->cachePath . $dimension . DS;

            if (!file_exists(ROOT . DS . $this->cachePath)) {
                mkdir(ROOT . DS . $this->cachePath);
            }



            if (!file_exists(ROOT . DS . $new_location)) {
                mkdir(ROOT . DS . $new_location);
            }


            $new_path = $new_location . $entity->get('name');

            $o->thumbnail($size, $mode)
                ->save(ROOT . DS . $new_path);

            if($save){
                $entitySize = $this->newEntity([
                    'product_image_id' => $entity->get('id'),
                    'dimension' => $dimension,
                    'path' => $new_path,
                    'size' => filesize(ROOT . DS . $new_path)
                ]);


                return $this->save($entitySize);
            }
        }
    }
}
