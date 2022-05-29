<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\EventInterface;


class PagesController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $check_loader = true;
        $this->set('check_loader', $check_loader);
    }
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
    }

    public function setModel()
    {
        $this->loadModel('Categories');
        $this->loadModel('Movies');
        $this->loadModel('MoviesInfo');
    }
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    public function index()
    {
        $this->setModel();
        $movies = $this->Movies->find('all', [
            'contain' => [
                'MoviesInfo'
            ],
            'conditions' => [
                'MoviesInfo.m_status =' => 1
            ]
        ]);
        //get topview:ngay
        $top_tuan = $this->MoviesInfo->getTopTuanByMovie();
        //get topview:thang
        $top_thang = $this->MoviesInfo->getTopThangByMovie();;
        //get topview:nam
        $top_nam = $this->MoviesInfo->getTopNamByMovie();;

        $this->set(compact('top_tuan', 'top_thang', 'top_nam'));
        $this->set('categoryMovie', $movies);
    }

    public function error404()
    {
        $this->viewBuilder()->setTemplatePath('Error');
        $this->set('flag_error', 1);
    }
}
