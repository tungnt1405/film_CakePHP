<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Core\Configure;

class AdminController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('admin');

        $url_s3 = Configure::read('s3_base');
        $this->set('url_s3', $url_s3);

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('ShowDataDebug');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password'],
                    'scope' => ['active' => 1],
                    'userModel' => 'Users'
                ]
            ],
            'loginRedirect' => [
                'controller' => 'Dashboard',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                'prefix' => 'Admin'
            ],
            // 'storage' => 'Session',
            'authError' => 'Vui lòng đăng nhập trước khi truy cập',
        ]);

        // $this->loadComponent('Auth');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login']);

        if ($this->Auth->User()) {
            if (empty($this->roleUser()) || !$this->roleUser()) {
                return $this->redirect('/');
            }
        }
    }

    public function roleUser()
    {
        return $this->Auth->User('is_admin');
    }

    function paginateAll($user_list)
    {
        $limit = $this->request->getParam('limit');
        return $this->paginate($user_list, array('limit' => !empty($limit) ? $limit : '10'));
    }
    public function paginateSearch($options)
    {
        return $this->paginate($options, array('limit' => '10'));
    }
}
