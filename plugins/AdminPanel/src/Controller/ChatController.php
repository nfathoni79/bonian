<?php
namespace AdminPanel\Controller;

use AdminPanel\Controller\AppController; 

/**
 * Brands Controller 
 * 
 */
class ChatController extends AppController
{
 
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        //debug($this->request->getSession()->read());
    }

    public function authorize()
    {
        $this->request->allowMethod('post');

        $auth = null;

        try {
            $auth = $this->ChatKit->getInstance()->authenticate([
                'user_id' => $this->Auth->user('username')
            ]);
            $auth = $auth['body'];
        } catch(\Exception $e) {
            $this->setResponse($this->response->withStatus(403, 'failed authenticate socket'));
        }

        return $this->response->withType('application/json')
            ->withStringBody(json_encode($auth));
    }
 

}
