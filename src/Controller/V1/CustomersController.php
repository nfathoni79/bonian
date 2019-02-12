<?php
namespace App\Controller\V1;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Validation\Validator;


/**
 * Class CouriersController
 * @package App\Controller\V1
 * @property \AdminPanel\Model\Table\CustomersTable $Customers
 */

class CustomersController  extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Customers');
        $this->loadComponent('SendAuth');
    }

    private function reffcode($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            try {
                $pieces []= $keyspace[random_int(0, $max)];
            } catch(\Exception $e) {}
        }
        return implode('', $pieces);
    }

    public function registers()
    {
            /*DATA SAMPLE*/
            $this->request->data['email'] = 'thinktobad@gmail.com';
            $this->request->data['password'] = '123456';
            $this->request->data['cpassword'] = '123456Abc';
            $this->request->data['first_name'] = 'Resliansyah';
            $this->request->data['last_name'] = 'Pratama';
            $this->request->data['phone'] = '0811205255';
            $this->request->data['platforrm'] = 'Android';
            $this->request->data['auth_code'] = '239134';


            $validator = new Validator();

//            $validator
//                ->email('email')
//                ->requirePresence('email', 'create')
//                ->notEmpty('email')
//                ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => __d('MemberPanel','Email address already exist')]);
//
//
//            $validator
//                ->requirePresence('password', 'create')
//                ->notEmpty('password', __d('MemberPanel','You must enter a password'), 'create')
//                ->lengthBetween('password', [6, 20], 'password min 6 - 20 character')
//                ->regex('password', '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/', __d('MemberPanel', 'Password min 6 char at least one uppercase letter, one lowercase letter and one number'));
//
//            $validator
//                ->requirePresence('cpassword', 'create')
//                ->notEmpty('cpassword')
//                ->allowEmpty('cpassword', function ($context) {
//                    return !isset($context['data']['password']);
//                })
//                ->equalToField('cpassword', 'password', __d('MemberPanel', 'Confirmation password does not match with your password'))
//                ->add('cpassword', 'compareWith', [
//                    'rule' => ['compareWith', 'password'],
//                    'message' => __d('MemberPanel','Passwords do not match.')
//                ]);
//
//            $validator
//                ->requirePresence('auth_code')
//                ->notEmpty('auth_code', __d('MemberPanel', 'This field is required'))
//                ->add('auth_code', 'is_valid', [
//                    'rule' => function($value) {
//                        return $this->SendAuth->isValid($value);
//                    },
//                    'message' => __d('MemberPanel', 'Auth code not valid')
//                ]);

            // display error custom on controller
            $errors = $validator->errors($this->request->getData());
            if (empty($errors)) {
                $success = false;
                $register = $this->Customers->newEntity();
                $register = $this->Customers->patchEntity($register, $this->request->getData(),['fields' => ['email','password','cpassword','phone']]);
                $register->set('reffcode', $this->reffcode('10'));
                $register->set('customer_group_id', 1);
                $register->set('customer_status_id', 1);
                $register->set('is_verified', 1);
                $register->set('platforrm', 'Android');
                $save = $this->Customers->save($register);
                //debug($register);
                //exit;
                if($save){
                    //$success = true;
                }else{
                    $this->setResponse($this->response->withStatus(406, 'Failed to registers'));
                    //display error on models
                    $error = $register->getErrors();
                }
            }else {
                $this->setResponse($this->response->withStatus(406, 'Failed to registers'));
                $error = $errors;
            }

             $this->set(compact('error'));
    }

    public function sendverification(){

        $this->SendAuth->register('register', '0811205255');
        $code = $this->SendAuth->generates();
        $text = 'Demi keamanan akun Anda, mohon TIDAK MEMBERIKAN kode verifikasi kepada siapapun TERMASUK TIM ZOLAKU. Kode verifikasi berlaku 15 mnt : '.$code;
        debug($text);
        exit;
    }
}
