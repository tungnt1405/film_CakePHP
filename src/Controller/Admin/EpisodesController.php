<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AdminController;

use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;

class EpisodesController extends AdminController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
    }

    public function setModel()
    {
        $this->loadModel('Episodes');
        $this->loadModel('Movies');
    }

    public function index()
    {
        $this->setModel();
        $episodesList = $this->Episodes->find('all', [
            'order' => ['Episode.created DESC'],
            'contain' => ['Movies']
        ]);
        $episodes = $this->paginateAll($episodesList);
        $this->set('episodes', $episodes);
    }
    public function add()
    {
        $this->setModel();
        $movie_list = $this->Movies->listMovies();

        //get list movie has links film(sign film)
        $movie_regis_link = $this->Episodes->getMoviesHasLink();
        $movie_get_all = $this->Movies->getAllMovies();
        $movie_id_has_links = array();
        $movie_id_sort_links = array();
        foreach ($movie_regis_link as $movie) {
            $movie_id_has_links[] = $movie['movie_id_distinct']; //get id movie has link
        };
        foreach ($movie_get_all as $m) {
            if (in_array($m->id, $movie_id_has_links)) {
                if ($m->movies_info->category_id == 3 || $m->movies_info->category_id == 9) { //find movie multiple episode
                    continue;
                }
                $movie_id_sort_links[$m->id] = $m->m_name; //get odd movie has link
            }
        }
        $movie_lists =  array();
        foreach ($movie_list as $key => $va) {
            if (!in_array($va, $movie_id_sort_links)) { //find film not link or odd film has link yet 
                $movie_lists[$key] = $va;
            }
        }
        $this->set('movie_lists', $movie_lists);
        $episode = $this->Episodes->newEmptyEntity();
        if ($this->request->is('post')) {
            $episode = $this->Episodes->patchEntity($episode, $this->request->getData());
            // if (!empty($this->request->getData('episode')) || $this->request->getData('episode')) {
            //     $episode->episode = $this->request->getData('episode');
            // }
            if ($this->Episodes->save($episode)) {
                $this->Flash->success(__('success'));
                return $this->redirect(['_name' => 'admin_episodes_create']);
            } else {
                $this->set('error', 'Thêm không thành công! Vui lòng thử lại');
            }
        }
        $this->set('episode', $episode);
    }
    public function edit()
    {
        $id = $this->request->getParam('id');
        $episode = $this->Episodes->get($id, [
            'contain' => ['Movies']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $episode = $this->Episodes->patchEntity($episode, $this->request->getData());
            $episode->modified = date("Y-m-d H:i:s");

            if ($this->Episodes->save($episode)) {
                $this->Flash->success(__('success'));
                return $this->redirect(['_name' => 'admin_episodes_edit', 'id' => $episode->id]);
            } else {
                $this->set('error', 'Cập nhật không thành công! Vui lòng thử lại');
            }
        }

        $this->set(compact('episode'));
    }
    public function delete()
    {
        $id = $this->request->getParam('id');
        $this->request->allowMethod(['post', 'delete']);

        $episode = $this->Episodes->get($id, [
            'contain' => ['Movies']
        ]);

        if ($this->Episodes->delete($episode)) {
            $this->Flash->success(__('success'));
            return $this->redirect(['_name' => 'admin_episodes_home']);
        } else {
            $this->set('error', 'Xóa không thành công! Vui lòng thử lại');
        }
    }

    public function search()
    {
        $search = trim($this->request->getQuery('query'));
        $result = $this->Episodes->search($search);

        $episodes =  null;
        if ($result) {
            $episodes = $this->paginateSearch($result);
        } else {
            $episodes = '';
        }
        $this->set('episodes', $episodes);
    }

    public function ajaxEpisode()
    {
        $this->setModel();
        $this->autoRender = false;
        $id = $this->request->getData('id');
        $movie = $this->Movies->get($id, ['contain' => 'MoviesInfo']);
        $countEpisode = $this->Episodes->getCountEpisodeOfMovie($id);
        $data = [];
        if ($this->request->is(['post', 'ajax'])) {
            $data['total_episode'] = $movie->movies_info->total_episode;
            if ($countEpisode >= $movie->movies_info->total_episode) {
                $data['episode_current'] = $movie->movies_info->total_episode;
            } else {
                if ($countEpisode <= 0) {
                    $data['episode_current'] = $countEpisode;
                    $data['episode_next'] = 1;
                } else {
                    $data['episode_current'] = $countEpisode;
                    $data['episode_next'] = $countEpisode + 1;
                }
                // $data['episode_next'] = $countEpisode+1;
            }
            $data['category_id'] = $movie->movies_info->category_id;
            return $this->response->withType("application/json")->withStringBody(json_encode(compact('data')));
            die;
        }
        return $this->response->withType("application/json")->withStringBody(json_encode(''));
    }
}
