<?php

namespace AdminPanel\Controller;

use App\Controller\AppController as BaseController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\Routing\Router;

/**
 * Class AppController
 * @package AdminPanel\Controller
 * @property \AdminPanel\Controller\Component\DataTableComponent $DataTable
 */

class AppController extends BaseController
{
    public function initialize()
    {
        //parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('AdminPanel.DataTable');
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

        $timeJsonFormat = 'yyyy-MM-dd HH:mm';

        FrozenTime::setJsonEncodeFormat($timeJsonFormat);
        FrozenTime::setToStringFormat($timeJsonFormat);
        if ($this->Auth->user()) {
            Configure::write('User', $this->Auth->user());
        }

	}


	public function beforeFilter(Event $event)
    {
        /* enable prefix routing */
        Router::addUrlFilter(function ($params, $request) {
            if (!isset($params['prefix'])) {
                $params['prefix'] = false;
            }
            return $params;
        });

        return parent::beforeFilter($event);
    }

    /**
     * @param Event $event
     * @return \Cake\Http\Response|void|null
     */
    public function beforeRender(Event $event)
    {

        parent::beforeRender($event);
        $this->viewBuilder()->setClassName('AdminPanel.App');
    }
}
