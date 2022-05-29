<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Controller\Controller;
use Cake\Core\Configure;

class AppController extends Controller
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
        if ($this->Auth->User()) {
            if (!empty($this->roleUser()) || $this->roleUser()) {
                return $this->redirect('/admin');
            }
        }
    }

    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('ShowDataDebug');
        $this->loadComponent('Auth', [
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'index'
            ],
        ]);

        $member_info = $this->_getMemberLogin();
        $this->set(compact('member_info'));

        $categories = $this->_getCategory();
        $this->set(compact('categories'));

        $genres = $this->_getGenre();
        $this->set(compact('genres'));

        $countries = $this->_getCountry();
        $this->set(compact('countries'));

        $url_s3 = Configure::read('s3_base');
        $this->set('url_s3', $url_s3);
    }

    public function roleUser()
    {
        return $this->Auth->User('is_admin');
    }

    public function _getMemberLogin()
    {
        return !empty($this->Auth->user()) ? $this->Auth->user() : '';
    }

    public function isCheckLogin()
    {
        return !empty($this->Auth->user()) ? true : false;
    }

    public function _getCategory()
    {
        $this->loadModel('Categories');
        $data = $this->Categories->find('all', [
            'conditions' => [
                'Category.status' => 1
            ],
            'order' => [
                'Category.number' => 'asc'
            ]
        ]);

        return $data;
    }

    public function _getGenre()
    {
        $this->loadModel('Genres');
        $data = $this->Genres->find('all', [
            'conditions' => [
                'Genre.status' => 1
            ]
        ]);

        return $data;
    }

    public function _getCountry()
    {
        $this->loadModel('Countries');
        $data = $this->Countries->find('all', [
            'conditions' => [
                'Country.country_status' => 1
            ]
        ]);

        return $data;
    }
}
