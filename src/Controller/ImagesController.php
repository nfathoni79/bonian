<?php
namespace App\Controller;

use App\Controller\AppController;
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
            ]);
        $validator
            ->requirePresence('customer_id')
            ->notBlank('customer_id');

        $errors = $validator->errors($this->request->getData());
        if (empty($errors)) {
            $entity = $this->Customers->get($this->request->getData('customer_id'));
            $entity->set('avatar',$this->request->getData('avatar'));
            if($this->Customers->save($entity)){
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
