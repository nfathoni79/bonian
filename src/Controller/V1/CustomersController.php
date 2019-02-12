<?php
namespace App\Controller\V1;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;


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
        $this->loadComponent('Mailer');
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
            $this->request->data['password'] = '123456Abc';
            $this->request->data['cpassword'] = '123456Abc';
            $this->request->data['first_name'] = 'Resliansyah';
            $this->request->data['last_name'] = 'Pratama';
            $this->request->data['phone'] = '08112052555';
            $this->request->data['platforrm'] = 'Android';
            $this->request->data['auth_code'] = '161300';

            $this->SendAuth->register('register', $this->request->getData('phone'));
            $validator = new Validator();

            $validator
                ->requirePresence('auth_code')
                ->notEmpty('auth_code', __d('MemberPanel', 'This field is required'))
                ->add('auth_code', 'is_valid', [
                    'rule' => function($value) {
                        return $this->SendAuth->isValid($value);
                    },
                    'message' => 'Auth code not valid'
                ]);

            // display error custom on controller
            $errors = $validator->errors($this->request->getData());
            if (empty($errors)) {
                $success = false;
                $register = $this->Customers->newEntity();
                $register = $this->Customers->patchEntity($register, $this->request->getData(),['fields' => ['email','password','cpassword','phone']]);
//                $register->set('reffcode', $this->reffcode('10'));
                $register->set('reffcode', 'lKdYcWFbxD');
                $register->set('customer_group_id', 1);
                $register->set('customer_status_id', 1);
                $register->set('is_verified', 1);
                $register->set('platforrm', 'Android');
                $register->set('activation', \Cake\Utility\Text::uuid());
                $save = $this->Customers->save($register);
                if($save){
                    $this->SendAuth->setUsed();
                    //$success = true;
                }else{
                    $this->setResponse($this->response->withStatus(406, 'Failed to registers'));
                    //display error on models
                    $error = $register->getErrors();
                    /*SEND EMAIL REGISTRATION*/
                }
            }else {
                $this->setResponse($this->response->withStatus(406, 'Failed to registers'));
                $error = $errors;
            }

             $this->set(compact('error'));
    }

    public function sendverification(){

        $this->request->data['phone'] = '08112052555';
        $this->SendAuth->register('register', $this->request->getData('phone'));
        $code = $this->SendAuth->generates();

        if($code){
            $text = 'Demi keamanan akun Anda, mohon TIDAK MEMBERIKAN kode verifikasi kepada siapapun TERMASUK TIM ZOLAKU. Kode verifikasi berlaku 15 mnt : '.$code;
            $this->SendAuth->sendsms($text);
        }else{
            $this->setResponse($this->response->withStatus(406, 'Failed request verification'));
        }
        $this->set(compact('error'));
    }

    public function testmail(){

        $this->Mailer
            ->setVar([
                'code' => \Cake\Utility\Text::uuid()
            ])
            ->sendEmail(
                'thinktobad@gmail.com',
                'Verivikasi Alamat Email Kamu Di Zolaku',
                'verification'
            );

        exit;

    }
}
