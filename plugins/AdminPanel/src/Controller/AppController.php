<?php

namespace AdminPanel\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;

class AppController extends BaseController
{
    public function initialize()
    {
        //parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Acl.Acl');
        $this->loadComponent('Auth', [
            'authorize' => [
                'Acl.Actions' => [
                    'actionPath' => 'controllers/',
                    'userModel' => 'Users',
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => 'AdminPanel'
            ],
            'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => [
                'Form' => [
                    'finder' => 'auth',
                    'userModel' => 'AdminPanel.Users',
                    'fields' => ['username' => 'email']
                ]
            ],
            'unauthorizedRedirect' => false,
            'storage' => [
                'className' => 'Session',
                'key' => 'Auth.Users',
            ],
        ]);

	}
	
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setClassName('AdminPanel.App');

    }
}
