<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AdminController;
use Cake\Mailer\Mailer;
use Cake\Mailer\MailerAwareTrait;
use Cake\Mailer\TransportFactory;
//Creating API Keys for Basic Authentication
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Event\EventInterface;

class UsersController extends AdminController
{

    var $IS_ADMIN = 0;
    var $STATUS   = 0;
    var $ACTIVE   = 1;



    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
    }

    public function login()
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->loadModel('Users');
        if($this->request->is('post')){
            // $check_user = $this->Users->find('all',[
            //     'conditions' => array(
            //         "email" => $this->request->getData('email'),
            //         "password" => md5($this->request->getData('password')),
            //         'is_admin' => 1,
            //     )
            // ])->first();
            // if($check_user){
            //     echo 'co';
            // }else{
            //     echo 'khong';
            // }
            // die;
            $user = $this->Auth->identify();
            if($user){
                if($user['active'] != 1){
                    $this->Flash->error('Users chưa được kích hoạt. Vui lòng liên hệ quản trị viên');
                }else{
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                    exit();
                }
            }else{
                $this->Flash->error('Email hoặc mật khẩu không chính xác!');
            }
        }
        $this->set('title','Đăng nhập');
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
    public function index()
    {
        $this->loadModel('UsersBase');
        $user_list = $this->UsersBase->find('all');
        $users = $this->paginateAll($user_list);
        $this->set('users',$users);
        $this->set('title','Quản lý users');
    }
    public function add()
    {
        $this->loadModel('UsersBase');
        
        $user = $this->UsersBase->newEmptyEntity();
        if($this->request->is('post')){
            $haser = new DefaultPasswordHasher();
            // $userTable = TableRegistry::get('Users');
            $user->name = $this->request->getData('name');
            $user->email = $this->request->getData('email');
            $user->password = $haser->hash($this->request->getData('password'));
            $user->role = $this->request->getData('role');
            $user->active = $this->ACTIVE;
            $user->create_at = date('Y-m-d H:i:s');
            //upload file on server
            $img = $this->request->getData('img_avatar');
            
            $user->img_avatar = $this->uploadFile($img);
            if($this->Users->save($user)){
                $this->Flash->success(__('success'));
                return $this->redirect(['action'=>'add']);
            }
            else{
                $this->set('error','Thêm không thành công! Vui lòng thử lại');
            }
        }
        $this->set('user',$user);
        $this->set('title','Thêm người dùng');
    }
    public function edit($id = null)
    {
        $id = $this->request->getParam('id');
        $this->loadModel('UsersBase');
        $user = $this->UsersBase->get($id);
        $this->set('user', $user);
        $data = [];
        
        if($this->request->is(array('post','put'))){
            $data['name'] = $this->request->getData('name');
            $data['email'] = $this->request->getData('email');
            $data['role'] = $this->request->getData('role');
            $data['img_avatar'] = $this->request->getData('img_avatar');
            $user = $this->UsersBase->patchEntity($user, [
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
            ]);
            
            $img = $data['img_avatar'];
            if($img->getError() == 0){
                //check file upload
                if($user->img_avatar){
                    unlink(WWW_ROOT.'img/upload/users/'.$user->img_avatar);
                }
                $user->img_avatar = $this->uploadFile($img);
            }
            
            //save db
            if($this->UsersBase->save($user)){
                $this->Flash->success(__('success'));
                return $this->redirect(['action'=>'edit', 'id'=> $id]);
            }else{
                $this->set('error','Cập nhật không thành công! Vui lòng thử lại');
            }
        }
        
        $this->set('title','Chỉnh sửa thông tin của '.$user->name);
    }

    public function delete($id = null)
    {
        $id = $this->request->getParam('id');
        $this->request->allowMethod(['post','delete']);
        $this->loadModel('UsersBase');
        $user = $this->UsersBase->get($id);
        if($user->img_avatar){
            unlink(WWW_ROOT.'img/upload/users/'.$user->img_avatar);
        }
        if($this->UsersBase->delete($user)){
            $this->Flash->success(__('success'));
            return $this->redirect(['action'=>'index']);
        } else{
            $this->set('error','Xóa không thành công! Vui lòng thử lại');
        }
    }
    //upload avatar
    public function uploadFile($img)
    {
        $tmp = $img->getStream()->getMetadata('uri');
        $nameImg = $img->getClientFilename();
        $ex = substr(strrchr($nameImg,'.'),1);
        $newName = time().'_'.$nameImg;
        if(!file_exists(WWW_ROOT.'img/upload/users/')){
            mkdir(WWW_ROOT.'img/upload/users/', 0777, true);
        }
        $path = "img/upload/users/".$newName;
        move_uploaded_file($tmp, WWW_ROOT.$path);
        return $newName;
    }

    public function search()
    {
        $search = $this->request->getQuery('query');
        
        $this->loadModel('Users');
        $result = $this->Users->search($search);

        if($result){
            $users = $this->paginateSearch($result);
        } else{
            $users = '';
        }
        $this->set('users',$users);
        $this->set('title','Từ khóa tìm kiếm: '.$search);
    }
}
