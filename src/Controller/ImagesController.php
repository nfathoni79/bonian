<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Validation\Validator;

/**
 * Images Controller
 *
 *
 * @property \AdminPanel\Model\Table\ProductImageSizesTable $ProductImageSizes
 * @property \AdminPanel\Model\Table\CustomersTable $Customers
 * @property \AdminPanel\Model\Table\ProductRatingImagesTable $ProductRatingImages
 * @property \AdminPanel\Model\Table\BannersTable $Banners
 * @property \AdminPanel\Model\Table\ImageSizesTable $ImageSizes
 * @property \AdminPanel\Model\Table\ProductImagesTable $ProductImages
 * @property \AdminPanel\Model\Table\ProductCategoriesTable $ProductCategories
 */
class ImagesController extends AppController
{
//    public function beforeFilter(Event $event) {
//        if (in_array($this->request->action, ['avatar'])) {
//            $this->getEventManager()->off($this->Csrf);
//        }
//    }

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.ProductImageSizes');
        $this->loadModel('AdminPanel.Customers');
        $this->loadModel('AdminPanel.ProductRatingImages');
        $this->loadModel('AdminPanel.Banners');
        $this->loadModel('AdminPanel.ImageSizes');
        $this->loadModel('AdminPanel.ProductImages');
        $this->loadModel('AdminPanel.ProductCategories');
    }

    /**
     * @param $dimension
     * @param $name
     * @param $ext
     * @return \Cake\Http\Response
     */
    public function index($dimension, $name, $ext)
    {
        $this->disableAutoRender();

        $find = $this->ProductImageSizes->ProductImages->find('all')
            ->select()
            ->where([
                'ProductImages.name' => $name . '.' . $ext
            ])
            ->contain('ProductImageSizes', function (\Cake\ORM\Query $q) use ($dimension) {
                return $q
                    ->where(['ProductImageSizes.dimension' => $dimension]);
            });

        if (!$find->isEmpty()) {
            /**
             * @var \AdminPanel\Model\Entity\ProductImage $data
             */
            $data = $find->first();
            
            if (count($data->get('product_image_sizes')) == 0) {
                //processing and resize on the fly
                list($width, $height) = explode('x', $dimension);
                if ($entity = $this->ProductImageSizes->resize($data, $width, $height)) {
                    return $this->response->withAddedHeader('content-type', $data->get('type'))
                        ->withStringBody(file_get_contents(ROOT . DS . $entity->get('path')));
                }else{
					
					$imagine = new \Imagine\Gd\Imagine();
					$o = $imagine->open(WWW_ROOT  . 'img/not-found.png');
					$size = new \Imagine\Image\Box($width, $height);
					$mode = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
					
					return $this->response->withAddedHeader('content-type', 'image/png')
                        ->withStringBody($o->thumbnail($size, $mode)
						->get('png'));
                }


            }
        } else {
            $find = $this->Banners->find()
                ->select([
                    'image_dimension' => 'ImageSizes.dimension',
                    'image_path' => 'ImageSizes.path',
                ])
                ->where([
                    'Banners.name' => $name . '.' . $ext
                ])
                ->leftJoin(['ImageSizes' => 'image_sizes'], [
                    'ImageSizes.model' => 'AdminPanel.Banners',
                    'ImageSizes.foreign_key = Banners.id',
                    'ImageSizes.dimension' => $dimension,
                ])
                ->enableAutoFields(true);

            if (!$find->isEmpty()) {
                /**
                 * @var \AdminPanel\Model\Entity\Banner $data
                 */
                $data = $find->first();
                if (!$data->get('image_path')) {
                    list($width, $height) = explode('x', $dimension);
                    if ($entity = $this->ImageSizes->resize($data, $width, $height)) {
                        return $this->response->withAddedHeader('content-type', $data->get('type'))
                            ->withStringBody(file_get_contents(WWW_ROOT  . $entity->get('path')));
                    }
                }

            }else{

                $find = $this->ProductCategories->find()
                    ->select([
                        'image_dimension' => 'ImageSizes.dimension',
                        'image_path' => 'ImageSizes.path',
                        'name' => 'ProductCategories.path',
                        'id'
                    ])
                    ->where([
                        'ProductCategories.path' => $name . '.' . $ext
                    ])
                    ->leftJoin(['ImageSizes' => 'image_sizes'], [
                        'ImageSizes.model' => 'AdminPanel.ProductCategories',
                        'ImageSizes.foreign_key = ProductCategories.id',
                        'ImageSizes.dimension' => $dimension,
                    ]);
                if (!$find->isEmpty()) {
                    /**
                     * @var \AdminPanel\Model\Entity\Banner $data
                     */
                    $data = $find->first();
                    $data['dir'] = 'webroot\files\ProductCategories\path\/';
                    $data['type'] = 'image/png';

                    if (!$data->get('image_path')) {
                        list($width, $height) = explode('x', $dimension);

                        if ($entity = $this->ImageSizes->resize($data, $width, $height)) {

                            return $this->response->withAddedHeader('content-type', $data->get('type'))
                                ->withStringBody(file_get_contents(WWW_ROOT  . $entity->get('path')));
                        }
                    }
                }

            }
        }
    }


    public function avatar(){
        $this->disableAutoRender();

        $this->request->allowMethod('post');
        $validator = new Validator();
        $validator
            ->requirePresence('avatar')
            ->add('avatar', [
                'validExtension' => [
                    'rule' => ['extension',['jpg','png','image/jpeg']], // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('These files extension are allowed: .jpg, .png')
                ]
            ])
            ->add('avatar', [
                'validExtension' => [
                    'rule' => array('fileSize', '<=', '1MB'), // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('Image must be less than 1MB')
                ]
            ]);
        $validator
            ->requirePresence('customer_id')
            ->notBlank('customer_id');

        $errors = $validator->errors($this->request->getData());
        if (empty($errors)) {
            $entity = $this->Customers->get($this->request->getData('customer_id'));
            $avatar = $entity->get('avatar');
            $entity->set('avatar',$this->request->getData('avatar'));
            if($this->Customers->save($entity)){
                if($avatar != 'avatar.jpg'){
                    if (file_exists(WWW_ROOT."/files/Customers/avatar/".$avatar)){
                        unlink(WWW_ROOT."/files/Customers/avatar/".$avatar);
                        unlink(WWW_ROOT."/files/Customers/avatar/thumbnail-".$avatar);
                    }
                }
                $response = ['is_success' => true, 'data' => $entity->get('avatar')];
            }else{
                $response = ['is_success' => false];
            }
        }else{

            $response = ['is_success' => false];
        }
        echo json_encode($response);
        exit;

    }

    public function ratings(){
        $this->disableAutoRender();

        $this->request->allowMethod('post');
        $validator = new Validator();
        $validator
            ->requirePresence('name')
            ->add('name', [
                'validExtension' => [
                    'rule' => ['extension',['jpg','png','image/jpeg']], // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('These files extension are allowed: .jpg, .png')
                ]
            ]);
        $validator
            ->requirePresence('product_rating_id')
            ->notBlank('product_rating_id');

        $errors = $validator->errors($this->request->getData());
        if (empty($errors)) {
//            debug($this->request->getData());
//            exit;
            $success = true;
            foreach($this->request->getData('name') as $vals){
                $entity = $this->ProductRatingImages->newEntity();
                $this->ProductRatingImages->patchEntity($entity, $this->request->getData(), [
                    'fields' => [
                        'product_rating_id'
                    ]
                ]);
                $entity->set('name', $vals);
                if($this->ProductRatingImages->save($entity)){

                }else{
                   $success = false;
                }
            }
            if($success){
                $response = ['is_success' => true];
            }else{
                $response = ['is_success' => false];
            }
        }else{
            $response = ['is_success' => false];
        }
        echo json_encode($response);
        exit;

    }

}
