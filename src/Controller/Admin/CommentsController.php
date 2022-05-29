<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AdminController;

use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;

class CommentsController extends AdminController{
   
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->loadModel('Comments');
    }

    public function index()
    {
        $commentList = $this->Comments->find('all',[
            'order'=>['Comment.created DESC'],
            'contain'=>['Movies','Users']
        ]);
        $comments = $this->paginateAll($commentList);
        $this->set('comments', $comments);
    }

    public function delete()
    {
        $id = $this->request->getParam('id');
        $this->request->allowMethod(['post','delete']);

        $category = $this->Comments->get($id);

        if($this->Comments->delete($category)){
            $this->Flash->success(__('success'));
            return $this->redirect(['_name'=>'admin_comment_home']);
        }else{
            $this->set('error','Xóa không thành công! Vui lòng thử lại');
        }
    }

    public function search()
    {
        $search = trim($this->request->getQuery('query'));
        $result = $this->Comments->search($search);

        $comments =  null;
        if($result){
            $comments = $this->paginateSearch($result);
        } else{
            $comments = '';
        }
        $this->set('comments',$comments);
    }
}
