<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AdminController;

class GenresController extends AdminController
{
    public function index()
    {
        $genres = $this->paginateAll($this->Genres);
        $this->set(compact('genres'));
    }

    public function view($id = null)
    {
        $genre = $this->Genres->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('genre'));
    }

    public function add()
    {
        $genre = $this->Genres->newEmptyEntity();
        if ($this->request->is('post')) {
            $genre = $this->Genres->patchEntity($genre, $this->request->getData());
            if($this->Genres->save($genre)){
                $this->Flash->success(__('success'));
                return $this->redirect(['_name'=>'admin_genre_create']);
            }else{
                $this->set('error','Thêm không thành công! Vui lòng thử lại');
            }
        }
        $this->set(compact('genre'));
    }

    public function edit($id = null)
    {
        $slug = $this->request->getParam('slug');
        $genre = $this->Genres->getSlugOfGenres($slug);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $genre = $this->Genres->patchEntity($genre, $this->request->getData());
            $genre->modified = date("Y-m-d");
            if ($this->Genres->save($genre)) {
                $this->Flash->success(__('success'));
                return $this->redirect(['_name'=>'admin_genre_edit','slug'=>$genre->slug]);
            }
            else{
                $this->set('error','Cập nhật không thành công! Vui lòng thử lại');
            }
        }
        $this->set(compact('genre'));
    }

    public function delete($id = null)
    {
        $id = $this->request->getParam('id');
        $this->request->allowMethod(['post', 'delete']);
        $genre = $this->Genres->get($id);
        if ($this->Genres->delete($genre)) {
            $this->Flash->success(__('success'));
            return $this->redirect(['_name'=>'admin_genre_home']);
        } else {
            $this->set('error','Xóa không thành công! Vui lòng thử lại');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search()
    {
        $search = $this->request->getQuery('query');
        $result = $this->Genres->search($search);

        $genres =  null;
        if($result){
            $genres = $this->paginateSearch($result);
        } else{
            $genres = '';
        }
        $this->set('genres',$genres);
    }
}
