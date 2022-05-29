<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AdminController;

class DashboardController extends AdminController
{
    public function setModel()
    {
        $this->loadModel('Users');
        $this->loadModel('Categories');
        $this->loadModel('Genres');
        $this->loadModel('Countries');
        $this->loadModel('Movies');
    }
    public function index()
    {
        $this->setModel();
        $count_movie = $this->Movies->getCountAllMovies();
        $movie = $this->Movies->find('all',['contain'=>"MoviesInfo"]);
        $month_current = date('m');
        $year_current = date('Y');
        $data_of_month = $this->Movies->getMovieOfMonth($month_current, $year_current);
        $get_value_month =[];
        $month = [];
        $count_value_month=[];
        foreach($data_of_month as $k => $m){
            $get_value_month[] = date_format($m['created'],'Y/m/d');
        }
        foreach(array_count_values($get_value_month)as $k=>$m){
            $month[] = $k;
            $count_value_month[] = $m;
        }
        // echo "<pre>";
        // print_r($month);die;
        $count_users = $this->Users->getCountAllUsers();
        $count_genres = $this->Genres->getCountAllGenres();
        $count_categories = $this->Categories->getCountAllCategories();
        $this->set([
            'count_movies'=>$count_movie,
            'count_users' => $count_users,
            'count_genres' => $count_genres,
            'count_categories' => $count_categories,
            'month' => $month,
            'count_value_month' => $count_value_month
        ]);
        $this->set('title','Điều khiển');
    }

    public function ajaxGraph()
    {
        $this->setModel();
        $this->autoRender = false;
        if ($this->request->is(['post','ajax'])) {
            $month = $this->request->getData('month');
            $year  = $this->request->getData('year');
            $total_movie = $this->Movies->getMovieOfMonth($month, $year);
            $get_value_month =[];
            $month = [];
            $count_value_month=[];
            foreach($total_movie as $k => $m){
                $get_value_month[] = date_format($m['created'],'Y/m/d');
            }
            if($get_value_month){
                foreach(array_count_values($get_value_month)as $k=>$m){
                    // $month[] = $k;
                    $count_value_month['value'][] = $k;
                    $count_value_month['count'][] = $m;
                }
            }else{
                $count_value_month['value'][] = '';
                $count_value_month['count'][] = '';
            }
            return $this->response->withType("application/json")->withStringBody(json_encode(compact('count_value_month')));    
        }
        return $this->response->withType("application/json")->withStringBody(json_encode(''));
        die;
    }
}