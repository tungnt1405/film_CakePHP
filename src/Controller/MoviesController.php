<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class MoviesController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $check_loader = true;
        $this->set('check_loader', $check_loader);
    }

    public function index()
    {
        $movies = $this->paginate($this->Movies);

        $this->set(compact('movies'));
    }


    public function details()
    {
        $id = $this->request->getParam('id');
        $movie = $this->Movies->get($id, array(
            'contain' => 'MoviesInfo'
        ));
        $movies = $this->Movies->getAllMoviesRelatedByGenreID($movie->movies_info->genre_id);
        // $movies_session = $this->Movies->getMoviesBySession($movie->m_name, $movie->movies_info->sesson);
        // $this->ShowDataDebug->dd($movies_session);
        $this->loadModel('Comments');
        $comments = $this->Comments->getCommentOfMovies($movie->id);
        $agv_comments = $this->Comments->avgRatingOfMovie($movie->id);
        $this->set([
            'movie' => $movie,
            'movies' => $movies,
            'comments' => $comments,
            'agv_comments' => $agv_comments
        ]);
    }

    public function watch()
    {
        $slug = $this->request->getParam('slug');
        $movie = $this->Movies->getMovieBySlug($slug);
        $this->loadModel('Episodes');
        $episode = $this->request->getParam('episode');
        $countEpisode = $this->Episodes->getCountEpisodeOfMovie($movie->id);
        $episode = $this->Episodes->getLinkEpisode($episode, $movie->id);
        $genre_movies = $this->Movies->getAllMoviesRelatedByGenreID($movie->movies_info->genre_id);
        $category_movies = $this->Movies->getAllMoviesRelatedByCategoryID($movie->movies_info->category_id);
        $this->loadModel('Comments');
        $comments = $this->Comments->getCommentOfMovies($movie->id);
        $this->set(compact('movie', 'genre_movies', 'category_movies', 'comments', 'countEpisode', 'episode'));
    }

    public function comments()
    {
        $this->autoRender = false;
        $data = array();
        $this->loadModel('Comments');
        $comment = $this->Comments->newEmptyEntity();
        if ($this->request->is(['ajax', 'post'])) {
            $comment = $this->Comments->patchEntity($comment, [
                'user_id' => $this->request->getData('user_id'),
                'movie_id' => $this->request->getData('movie_id'),
                'content' => $this->request->getData('comment'),
                'rate' => $this->request->getData('rate_movie'),
                'creared' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ]);
            if ($this->Comments->save($comment)) {
                echo json_encode("Bình luận thành công!");
                exit();
            } else {
                echo json_encode("Opps!...");
                die;
            }
        }
        echo "";
        die;
    }

    public function notifyAccept($flag)
    {
        if (base64_decode($flag) !== '222222') {
            return $this->redirect(['controller' => 'Pages', 'action' => 'index']);
            exit();
        }
        $this->set('notifyAccept', 1);
    }

    public function payMovie()
    {
        $session = $this->request->getSession();
        
        if(!$session->read('info_movie') && !$session->read('pass_movie')){
            return $this->redirect(['_name' => 'pay_info']);
            die;
        }

        if($this->request->is('post','ajax')){
            $get_data = $this->request->getData();
            $info_movie = [];
            $info_movie['payment-amount'] = $get_data['payment-amount'];
            $info_movie['payment-note'] = $get_data['payment-note'];
            $info_movie['payment-pay'] = $get_data['payment-pay'];
            $session->write('info_user_movie', $info_movie);
            return $this->response->withType("application/json")->withStringBody(json_encode('/pay_order'));
            die;
        }
    }

    public function payInfo()
    {
        $session = $this->request->getSession();
        if(!$session->read('pass_movie')){
            $session->write('pass_movie', true);
        }
        if($session->read('info_user_movie')){
            return $this->redirect(['_name' => 'pay_order']);
            die;
        }
        if ($this->request->is(['ajax'])) {
            return $this->response->withType("application/json")->withStringBody(json_encode('/pay_movie'));
            die;
        }
    }

    public function payOrder()
    {
        $session = $this->request->getSession();
        if(!$session->read('info_movie')){
            return $this->redirect(['_name' => 'pay_info']);
            die;
        }
        if(!$session->read('info_user_movie')){
            return $this->redirect(['_name' => 'pay_movie']);
            die;
        }
        if($this->request->is('post','ajax')){
            $this->loadComponent('VNPAY');
            $data = [] ;
            $data[] = [
                'payment-note'=>$session->read('info_user_movie.payment-note'),
                'payment-amount'=> (int) $session->read('info_user_movie.payment-amount'),
                'payment-pay'=>$session->read('info_user_movie.payment-pay'),
            ];
            if($data[0]['payment-pay'] === 'vn_pay'){
                $inputData = $this->VNPAY->inputData($data[0]);
                $result = $this->VNPAY->resultQuery($inputData);
                return $this->response->withType("application/json")->withStringBody(json_encode($result));
                die;
            }
        }
    }

    public function ajaxPay()
    {
        if ($this->request->is(['ajax'])) {
            $id = $this->request->getData('id');
            $movie = $this->Movies->get($id);
            $info_movie = [];
            $info_movie['movie_name'] = $movie->m_name;
            $session = $this->request->getSession();
            $session->write('info_movie', $info_movie);
            return $this->response->withType("application/json")->withStringBody(json_encode('/pay_info'));
        }
        return $this->response->withType("application/json")->withStringBody(json_encode(compact('')));
        die;
    }
}
