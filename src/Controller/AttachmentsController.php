<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Utility\Text;
use Cake\Validation\Validator;
use Cake\Routing\Router;

/**
 * Images Controller
 *
 *
 */
class AttachmentsController extends AppController
{


    public function initialize()
    {
        parent::initialize();

    }


    public function index()
    {
        $this->disableAutoRender();

    }


    public function image()
    {
        $this->disableAutoRender();

        $this->request->allowMethod('post');
        $validator = new Validator();

        $validator->requirePresence('image')
            ->add('image', 'check_mime', [
                'rule' => function($value) {
                    if (!empty($value['tmp_name'])) {
                        return in_array(mime_content_type($value['tmp_name']), ['image/jpeg', 'image/png', 'image/gif']);
                    }

                    return false;

                },
                'message' => 'mime error'
            ]);

        $error = $validator->errors($this->request->getData());

        if (empty($error)) {
            $image = $this->request->getData('image');
            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);

            $path = WWW_ROOT . 'attachments' . DS . date('Y');
            if (!file_exists($path)) {
                mkdir($path);
            }

            $path .= DS . date('m');
            if (!file_exists($path)) {
                mkdir($path);
            }


            $save_file = $path . DS . Text::uuid() . '.' . $extension;

            $size = new \Imagine\Image\Box(1024, 1024);
            $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
            $imagine = new \Imagine\Gd\Imagine();
            // Save that modified file to our temp file
            $imagine->open($image['tmp_name'])
                ->thumbnail($size, $mode)
                ->save($save_file);

            $error = [
              'url' =>  Router::url('/' . str_replace(DS, '/', str_replace(WWW_ROOT, '', $save_file)), true),
              'name' => $image['name'],
              'type' => mime_content_type($image['tmp_name']),
            ];
        }

        return $this->response->withType('application/json')
            ->withStringBody(json_encode($error));

    }


}
