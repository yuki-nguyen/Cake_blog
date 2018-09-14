<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Http\Cookie\Cookie;
use Cake\Routing\Router;//
use Cake\Mailer\Email;// To reset password
use \Curl\Curl;
use Cake\Network\Http\Client;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['add','logout','password', 'reset']);
    }

    public function index()
    {        
        $this->set('users', $this->Users->find('all'));
    }

    public function view($id)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    //Add user and define role
    public function add()
    {        var_dump('dsfd');
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                
                $this->Flash->success(__('Success! Login to relax!!!'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Opps!!! Something went wrong'));
             //debug($user->errors());
        } 
        $this->set('user', $user);
    }
    
    //Login
    public function login()
    { var_dump('ádasda');
        if($this->request->is('post')) {

            $user = $this->Auth->identify();

            if($user) {
                $this->Flash->success(__('Success! Login to relax!!!'));
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            else{                
                $this->Flash->error(__('Username or password is incorrect'), [
                    'key' => 'auth'
                ]);
            }
            
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function renderJson($data)
    {
        $this->autoRender = false;
        $this->response->body(json_encode($data));
        $this->response->type('application/json');

        return $this->response;
    }

    public function password()
    {
        if ($this->request->is('post')) {
            $query = $this->Users->findByEmail($this->request->data['email']);
            $user = $query->first();
            if (is_null($user)) {
                $this->Flash->error('Email address does not exist. Please try again');
            } else {
                $passkey = uniqid();
                $url = Router::Url(['controller' => 'users', 'action' => 'reset'], true) . '/' . $passkey;
                $timeout = time() + DAY;
                
                 if ($this->Users->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $user->id])){
                    $this->sendResetEmail($url, $user);
                    $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error('Error saving reset passkey/timeout');
                }
            }
        }
    }

    private function sendResetEmail($url, $user) {
        $email = new Email();
        $email->template('resetpw');
        $email->emailFormat('both');
        $email->from('no-reply@naidim.org');
        $email->to($user->email, $user->full_name);
        $email->subject('Reset your password');
        $email->viewVars(['url' => $url, 'username' => $user->username]);
        
        if ($email->send()) {
            $this->Flash->success(__('Check your email for your reset password link'));
        } else {
            $this->Flash->error(__('Error sending email: ') . $email->smtpError);
        }
    }

    public function reset($passkey = null) {
        if ($passkey) {
            $query = $this->Users->find('all', ['conditions' => ['passkey' => $passkey, 'timeout >' => time()]]);
            $user = $query->first();
            if ($user) {
                if (!empty($this->request->data)) {
                    // Clear passkey and timeout
                    $this->request->data['passkey'] = null;
                    $this->request->data['timeout'] = null;
                    $user = $this->Users->patchEntity($user, $this->request->data);
                    if ($this->Users->save($user)) {
                        $this->Flash->set(__('Your password has been updated.'));
                        return $this->redirect(array('action' => 'login'));
                    } else {
                        $this->Flash->error(__('The password could not be updated. Please, try again.'));
                    }
                }
            } else {
                $this->Flash->error('Invalid or expired passkey. Please check your email or try again');
                $this->redirect(['action' => 'password']);
            }
            unset($user->password);
            $this->set(compact('user'));
        } else {
            $this->redirect('/');
        }
    }

    public function callAPI(){
        // $ch = curl_init("http://192.168.56.20:8080/connect.php/");
        $url = "http://192.168.56.20/connect.php/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_PORT, 8080);
        curl_setopt($ch, CURLOPT_TIMEOUT, 400);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, True);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);//show on browser, if True-> must echo to display 
        $report=curl_getinfo($ch);
        // print_r($report);
        $result = curl_exec($ch);
       
    }
}