<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\I18n;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    var $layout = 'default';

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */

    public function initialize()
    {
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'], // Added this line
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'controller' => 'Articles',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'home'
            ],
            'authenticate' => [
                'Form'
            ],
        ]);
        
    }

    //check language, the software before load page
    public function beforeFilter(Event $event)
    {        
        $language = $this->Cookie->read('website_language');
        if (isset($language)) {
                I18n::locale($language);
            } else {
                I18n::locale('en_US');
        }
        
        if ($this->request->isMobile()){
                $this->is_mobile = true;
                    $this->set('is_mobile', true );
                    $this->autoRender = false;
            } else {
                $this->set('is_mobile', false );
        }
    
        $this->Auth->allow(['login','changeLanguage']);
        
    }

    //Add link to mobile view
    public function afterFilter(Event $event) {
        if (isset($this->is_mobile) && $this->is_mobile) {
            
            $has_mobile_view_file = file_exists(ROOT . DS . APP_DIR . DS . 'Template' . DS . $this->name . DS . 'mobile' . DS .  $this->request->getParam('action') . '.ctp') ;
            $has_mobile_layout_file = file_exists( ROOT . DS . APP_DIR . DS . 'Template' . DS . 'Layout' . DS . 'mobile' . DS . $this->layout . '.ctp' );

            $deny_action_view_file = array("logout", "changeLanguage");
            if(! in_array($this->request->getParam('action'),$deny_action_view_file)){
                $view_file = ( $has_mobile_view_file ? 'mobile' . DS : '' ) . $this->request->getParam('action');
            
                $layout_file = ( $has_mobile_layout_file ? 'mobile' . DS : '' ) . $this->layout;
                $this->render( $view_file, $layout_file );
            }
        }
    }


    //Check the permission to view Articles
    public function isAuthorized($user)
    {   
        if (isset($user['role']) || $user['role'] === 'admin') {
            return true;
        }
        return false;
    }

    //Change language for the page that you request
    public function changeLanguage($lang)    {
        if (!empty($lang)) {           
            if ($lang == 'ja') {                
                $this->Cookie->write('website_language', 'ja_JP');                
            } else if ($lang == 'en') {
                $this->Cookie->write('website_language', 'en_US');    
            }
            $this->redirect($this->referer());
        }
    }
}
