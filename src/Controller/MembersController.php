<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Mailer;
use Cake\Mailer\MailerAwareTrait;
use Cake\Mailer\TransportFactory;

class MembersController extends AppController
{
    var $IS_ADMIN = 0;
    var $STATUS   = 0;
    var $ACTIVE   = 1;
    public function setModel()
    {
        $this->loadModel('UsersBase');
        $this->loadModel('Users');
    }

    public function index()
    {
    }
    public function login()
    {
        $this->loadModel('Users');
        if ($this->request->is('post')) {
            $check_user = $this->Users->checkEmailUsers($this->request->getData('email'));
            $haser = new DefaultPasswordHasher();
            if ($check_user) {
                if ($haser->check($this->request->getData('password'), $check_user['password'])) {
                    $this->Auth->setUser($check_user);
                    echo "1";
                } else {
                    echo "0";
                }
            } else {
                echo "0";
            }
            die;
        }
    }
    public function logout()
    {
        // session_destroy();
        return $this->redirect($this->Auth->logout());
    }

    public function register()
    {
        $this->autoRender = false;
        // debug($this->request->getData());die;
        $this->loadModel('UsersBase');
        $this->loadModel('Users');
        $user = $this->UsersBase->newEmptyEntity();
        if ($this->request->is(['post'])) {
            $haser = new DefaultPasswordHasher();
            $user->name = $this->request->getData('name');
            $user->email = $this->request->getData('email_regis');
            $user->password = $haser->hash($this->request->getData('password'));
            $user->is_admin = 0;
            $user->role = 'member';
            $user->active = $this->ACTIVE;
            $user->create_at = date('Y-m-d H:i:s');
            $user->img_avatar = 'default.jpg';
            if ($this->Users->save($user)) {
                $check_user = $this->Users->checkEmailUsers($this->request->getData('email_regis'));
                if ($haser->check($this->request->getData('password'), $check_user['password'])) {
                    $this->Auth->setUser($check_user);
                    return $this->redirect('/');
                    exit();
                }
                // return $this->response->withType('application/json')
                // ->withStringBody(json_encode(['result' => 'success']));          
            } else {
                // return $this->response->withType('application/json')
                // ->withStringBody(json_encode(['result' => 'error']));
                echo "<script>alert('Đăng ký không thành công'); window.history.back()</script>";
                die;
            }
        }
        echo "";
        die;
    }

    public function profile($id = null)
    {
        $id = $this->request->getParam('id');
        $this->loadModel('UsersBase');
        $member = $this->UsersBase->get($id, [
            'contain' => ['Profiles']
        ]);
        $this->set('member', $member);
        if (!$this->isCheckLogin()) {
            return $this->redirect(['controller' => 'Pages', 'action' => 'index']);
        }

        if ($this->request->is(['post', 'put'])) {
            $member = $this->UsersBase->patchEntity($member, [
                'name' => $this->request->getData('name'),
            ]);
            $this->loadModel("Profiles");
            $profiles = $this->Profiles->getProfileOfUserId($id);
            $district = $this->request->getData('city');
            $city = $this->request->getData('country');
            $phone = $this->request->getData('number_phone');
            if (!$profiles) {
                $profile = $this->UsersBase->newEmptyEntity();
                $profile->user_id = $id;
                $profile->phone = isset($phone) ? $phone : '';
                $profile->address_city = isset($city) ? $city : '';
                $profile->address_district = isset($district) ? $district : '';
                $profile->created = date("Y-m-d H:m:s");
                $profile->modified = date("Y-m-d H:m:s");
                $this->Profiles->save($profile);
            } else {
                $profiles->phone = isset($phone) ? $phone : $profiles->phone;
                $profiles->address_city = isset($city) ? $city : $profiles->address_city;
                $profiles->address_district = isset($district) ? $district : $profiles->address_district;
                $profiles->modified = date("Y-m-d H:m:s");
                $this->Profiles->save($profiles);
            }
            if ($this->UsersBase->save($member)) {
                $this->Auth->setUser($member);
                return $this->redirect(['_name' => 'member_profile', 'id' => $id]);
            }
        }
    }

    public function changePassword($id = null)
    {

        $id = $this->request->getParam('id');
        $this->loadModel('UsersBase');
        $member = $this->UsersBase->get($id);

        if (!$this->isCheckLogin()) {
            return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
        }

        $haser = new DefaultPasswordHasher();
        $new_pass = $this->request->getData('new_password');
        $old_pass = $this->request->getData('old_password');

        if ($this->request->is(['post', 'put'])) {
            if ($haser->check($old_pass, $member->password)) {
                $member = $this->UsersBase->patchEntity($member, [
                    'password' => $haser->hash($new_pass),
                ]);
                if ($this->UsersBase->save($member)) {
                    $this->Auth->setUser($member);
                    return $this->redirect(['controller' => 'Members', 'action' => 'profile', 'id' => $id]);
                    exit();
                }
            }
        }
    }

    public function changeAvatar($id = null)
    {

        $id = $this->request->getParam('id');
        $this->loadModel('UsersBase');
        $member = $this->UsersBase->get($id);

        if (!$this->isCheckLogin()) {
            return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
        }

        if ($this->request->is(['post', 'put'])) {
            $img = $this->request->getData('img_change');
            if ($img->getError() == 0) {
                //check file upload
                if ($member->img_avatar && $member->img_avatar != 'default.jpg') {
                    unlink(WWW_ROOT . 'img/upload/users/' . $member->img_avatar);
                }
                $member->img_avatar = $this->uploadFile($img);
            }
            if ($this->UsersBase->save($member)) {
                $this->Auth->setUser($member);
                return $this->redirect(['controller' => 'Members', 'action' => 'profile', 'id' => $id]);
                exit();
            }
        }
    }

    public function uploadFile($img)
    {
        $tmp = $img->getStream()->getMetadata('uri');
        $nameImg = $img->getClientFilename();
        $ex = substr(strrchr($nameImg, '.'), 1);
        $newName = time() . '_' . $nameImg;
        if (!file_exists(WWW_ROOT . 'img/upload/users/')) {
            mkdir(WWW_ROOT . 'img/upload/users/', 0777, true);
        }
        $path = "img/upload/users/" . $newName;
        move_uploaded_file($tmp, WWW_ROOT . $path);
        return $newName;
    }

    public function checkEmail()
    {
        $this->loadModel('Users');
        $this->loadComponent('ShowDataDebug');
        if ($this->request->is('post')) {
            $check_user = $this->Users->find('all', [
                'conditions' => [
                    'User.email =' => $this->request->getData('email_regis')
                ]
            ])->first();
            $message = '';
            if ($check_user) {
                $message = 1;
            } else {
                $message = 0;
            }
            return $this->response->withType("application/json")->withStringBody(json_encode($message));
        }
    }

    public function forward($flag = null)
    {
        if ($this->request->is('post')) {
            $http = $_SERVER['HTTP_HOST'];
            $email = $this->request->getData('email_reset');
            $token = Security::hash(Security::randomBytes(32));
            $this->loadModel('UsersBase');
            $user = $this->UsersBase->find()->where(['email' => $email])->first();
            $user = $this->UsersBase->patchEntity($user, [
                'remember_token' => $token,
                'password' => Security::hash(Security::randomBytes(32)),
                'modified' => date('Y-m-d H:i:s')
            ]);
            $template = $this->templateEmailForgot($email, $http, $token);
            if ($this->UsersBase->save($user)) {
                // $this->Flash->success('Mật khẩu sẽ được gửi vào email của bạn. Vui lòng kiểm tra hộp thư');

                TransportFactory::setConfig('mailtrap', [
                    'host' => 'ssl://smtp.gmail.com',
                    'port' => 465,
                    'username' => 'ntt140520.cv@gmail.com',
                    'password' => 'qbraplwfxsetwvqw',
                    'className' => 'Smtp'
                ]);

                $mailer = new Mailer('default');
                $mailer->setTransport('mailtrap');
                $mailer->setEmailFormat('html')
                    ->setSender('ntt140520.cv@gmail.com', 'Film-datn.vn')
                    ->setSubject('Lấy lại mật khẩu')
                    ->setTo($email)
                    // ->deliver('Xin chào, ' . $email . '<br/> Vui lòng nhấn <a href="' . $http . '/users/reset-pass/' . $token . '">tại đây</a> để lấy lại mật khẩu');
                    ->deliver($template);
                return $this->redirect(['controller' => 'Members', 'action' => 'forward', base64_encode('140520')]);
            }
        } else {
            if (base64_decode($flag) !== '140520') {
                return $this->redirect(['controller' => 'Pages', 'action' => 'index']);
                exit();
            }
        }
        $this->set('notifyAccept', 1);
    }

    public function resetPass()
    {
        $this->setModel();
        $token = $this->request->getParam('token');
        $user_check = $this->UsersBase->find('all')->where(['remember_token' => $token])->first();

        if (empty($user_check)) {
            return $this->redirect(['controller' => 'Pages', 'action' => 'error404']);
            exit();
        }
        $expire = time() - strtotime($user_check->modified);

        if ($expire > 60 * 2) {
            $user_check->remember_token = '';
            $user_check->modified = date('Y-m-d H:i:s');
            if ($this->UsersBase->save($user_check)) {
                return $this->redirect(['controller' => 'Members', 'action' => 'expire', base64_encode('00000')]);
            }
            exit();
        }

        if ($this->request->is('post')) {
            $token = $this->request->getParam('token');
            $haser = new DefaultPasswordHasher();
            $pass = $haser->hash($this->request->getData('new_password'));
            $user = $this->UsersBase->find('all')->where(['remember_token' => $token])->first();
            if (!empty($user)) {
                $user->password = $pass;
                $user->remember_token = '';
                $user->modified = date('Y-m-d H:i:s');
                if ($this->UsersBase->save($user)) {
                    return $this->redirect('/movies/notifyAccept/' . base64_encode('222222'));
                    exit();
                }
            } else {
                return $this->redirect(['controller' => 'Pages', 'action' => 'error404']);
                exit();
            }
        }
    }

    public function templateEmailForgot($email, $link, $token)
    {
        $html = '';
        $html .= '
        <div class="email" style="max-width: 500px;
        position: absolute;
        height: auto;
        background-color: bisque;
        color: #000;
        padding: 10px;
        margin: 0 auto;
        border-radius: 7px;">
            <div class="title--email" style="font-size: 25px;
            text-transform: uppercase;">Lấy lại mật khẩu</div>
            <div class="contet--email" style="font-size: 16px;
            margin: 15px 0;
            text-align: justify;">
                <div class="heading" style="margin-bottom: 15px;">
                    Xin chào, ' . $email . '.
                </div>
                <div class="body" style="margin-bottom: 20px;">
                    Chúng tôi rất chân thành cảm ơn khi bạn sử dụng dịch vụ của chúng tôi. <br><br>
                    Để lấy lại mật khẩu của mình. Hãy nhấn vào nút bên dưới.
                </div>
                <div class="foot" style="margin-bottom: 15px; ">
                    <a href="' . $link . '/users/reset-pass/' . $token . '" style="text-decoration: none;
                    color: #fff;
                    padding: 12px;
                    width: auto;
                    height: 50px;
                    background-color: blueviolet;
                    border: none;
                    text-transform: uppercase;
                    border-radius: 7px;">Lấy lại mật khẩu</a>
                </div>
            </div>
            <div class="footer--email">
                <p style="font-size: 16px">
                --------------------- <br>
                Trân trọng!
                <br> Nếu gặp bất kỳ sự cố gì hãy liên hệ: ntt140520.cv@gmail.com
                </p>
            </div>
        </div>
        ';
        return $html;
    }

    public function expire($flag)
    {
        if (base64_decode($flag) !== '00000') {
            return $this->redirect(['controller' => 'Pages', 'action' => 'index']);
            exit();
        }
    }
}
