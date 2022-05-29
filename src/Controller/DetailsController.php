<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Core\Configure;


class DetailsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
    }
    public function setModel()
    {
        $this->loadModel("Categories");
        $this->loadModel("Countries");
        $this->loadModel("Genres");
        $this->loadModel("Movies");
        $this->loadModel("MoviesInfo");
        $this->loadModel("Comments");
    }
    public function category()
    {
        $this->setModel();
        $cate_slug = $this->request->getParam('slug');
        $category = $this->Categories->getSlugOfCategories($cate_slug);

        $cate_movies = $this->Categories->getMoviesByCategory($category->title, $category->id);
        $count_cate_movies = count($cate_movies->toArray());
        $rating = $this->rating($cate_movies->toArray());

        $this->set(compact('category', 'cate_movies', 'count_cate_movies', 'rating'));
    }
    public function countries()
    {
        $this->setModel();
        $country_slug = $this->request->getParam('slug');
        $country = $this->Countries->getSlugOfCountries($country_slug);
        $county_movies = $this->Countries->getMoviesByCountries($country->country_slug, $country->id);
        $count_movies = count($county_movies->toArray());
        $rating = $this->rating($county_movies->toArray());
        $this->set(compact('country', 'county_movies', 'count_movies', 'rating'));
    }
    public function genres()
    {
        $this->setModel();
        $genre_slug = $this->request->getParam('slug');
        $genre = $this->Genres->getSlugOfGenres($genre_slug);
        $genre_movies = $this->Genres->getMoviesByGenre($genre->slug, $genre->id);
        $count_gen_movies = count($genre_movies->toArray());
        $rating = $this->rating($genre_movies->toArray());

        $this->set(compact('genre', 'genre_movies', 'count_gen_movies', 'rating'));
    }
    public function year()
    {
        $this->setModel();
        $year = $this->request->getParam('year');
        $year_movies = $this->MoviesInfo->getMoviesByYear($year);
        $count_year_movies = count($year_movies->toArray());
        $rating = $this->rating($year_movies->toArray());

        $this->set(compact('year', 'year_movies', 'count_year_movies', 'rating'));
    }

    public function search()
    {
        $this->setModel();
        $query = '';
        if($this->request->getQuery('tag_key')){
            $query = $this->request->getQuery('tag_key');
        }
        if($this->request->getQuery('tag')){
            $query = $this->request->getQuery('tag');
        }
        
        $movie_searchs = $this->Movies->getMoviesByName($query);

        $rating = $this->rating($movie_searchs->toArray());
        $this->set(compact('movie_searchs', 'rating'));
    }

    public function ajaxListMovies()
    {
        $this->setModel();
        $this->autoRender = false;
        $query = $this->request->getQuery('query');
        $availableTags = $this->Movies->getMoviesByName($query);
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

        if ($this->request->is(['ajax'])) {
            foreach ($availableTags as $k => $index) {
                $array_data[] = $index['m_name'];
                // $array_data['value'] = $index['m_name'];
                // $array_data['label'] = '<a href="' . $url . '/' . $index['m_slug'] . '/' . $index['id'] . '">
                // <img src="' . Configure::read('s3_base') . 'uploads/thumbs/' . $index['thumb'] . '" width="30" height="30"/>
                // &nbsp;&nbsp;' . $index['m_name'] . '</a>';
            }
            return $this->response->withType("application/json")->withStringBody(json_encode(compact('array_data')));

            die;
        }
        return $this->response->withType("application/json")->withStringBody(json_encode(compact('')));
        die;
    }

    public function rating(array $movies)
    {
        $rating = [];
        foreach ($movies as $key => $value) {
            $id = !empty($value->Movie['id']) ? $value->Movie['id'] : $value->id;
            $agv_comments = $this->Comments->avgRatingOfMovie($id);
            $rating[] = $agv_comments;
        }
        return $rating;
    }

    public function card()
    {
        $check_loader = true;
        $this->set('check_loader', $check_loader);
        if($this->request->is(['post', 'ajax'])){
            $this->loadComponent('VNPAY');
            $data = [] ;
            $data[] = $this->request->getData();
            $inputData = $this->VNPAY->inputData($data[0]);
            $result = $this->VNPAY->resultQuery($inputData);
            return $this->response->withType("application/json")->withStringBody(json_encode(compact('result')));   
            die;
        }
    }
    public function result()
    {
        //sau khi thanh toan thanh cong thi luu vao db
        $session = $this->request->getSession();
        $check_loader = true;
        $this->set('check_loader', $check_loader);
        $status_vnp = $this->request->getQuery('vnp_ResponseCode');
        
        if($session->read('info_movie')){
            if($status_vnp === '00' || $status_vnp == '00'){
                $session->delete('info_movie');
                $session->delete('info_user_movie');
                $session->delete('pass_movie');
            }
        }else{
            return $this->redirect('/pay_info');
            die;
        }
    }
}
