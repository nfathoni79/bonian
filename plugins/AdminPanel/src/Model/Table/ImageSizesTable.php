<?php
namespace AdminPanel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImageSizes Model
 *
 * @method \AdminPanel\Model\Entity\ImageSize get($primaryKey, $options = [])
 * @method \AdminPanel\Model\Entity\ImageSize newEntity($data = null, array $options = [])
 * @method \AdminPanel\Model\Entity\ImageSize[] newEntities(array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ImageSize|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ImageSize|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \AdminPanel\Model\Entity\ImageSize patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ImageSize[] patchEntities($entities, array $data, array $options = [])
 * @method \AdminPanel\Model\Entity\ImageSize findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ImageSizesTable extends Table
{

    protected $cachePath = 'images' . DS;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('image_sizes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('model')
            ->maxLength('model', 150)
            ->requirePresence('model', 'create')
            ->allowEmptyString('model', false);

        $validator
            ->integer('foreign_key')
            ->allowEmptyString('foreign_key');

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

        return $validator;
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
    public function resize(\Cake\Datasource\EntityInterface $entity, $width, $height)
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



            if (!file_exists(WWW_ROOT . DS . $new_location)) {
                mkdir(WWW_ROOT . DS . $new_location);
            }


            $new_path = $new_location . $entity->get('name');

            $o->thumbnail($size, $mode)
                ->save(WWW_ROOT . DS . $new_path);


            $entitySize = $this->newEntity([
                'model' => $entity->getSource(),
                'foreign_key' => $entity->get('id'),
                'dimension' => $dimension,
                'path' => $new_path,
                'size' => filesize(WWW_ROOT . DS . $new_path)
            ]);


            return $this->save($entitySize);
        }
    }
}
