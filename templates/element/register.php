<style>
    label {
        margin-bottom: 5px
    }

    label.error {
        font-size: 16px;
        color: red !important;
        font-weight: 100;
        margin-bottom: 0px !important;
    }

    .login-content {
        max-height: calc(100vh - 100px);
        overflow-y: auto;
        z-index: 9999;
    }

    .login-content::-webkit-scrollbar {
        width: 5px;
        height: 5px;
        border: 1px solid #d5d5d5;
    }

    .login-content::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .login-content::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 5px;
    }
</style>
<div class="login-wrapper" id="signup-content">
    <div class="login-content">
        <a href="#" class="close">x</a>
        <h3>đăng ký</h3>
        <?= $this->Form->create(null, [
            'id' => "registerForm",
            // 'onsubmit'=>'return false'
            'action' => $this->Url->build(['_name' => 'register']),
        ]) ?>
        <div class="row">
            <label for="username-2">
                Họ và tên người dùng:
                <input type="text" name="name" id="name" />
            </label>
        </div>

        <div class="row">
            <label for="email-2">
                Địa chỉ email:
                <?= $this->Form->control('email_regis', ["id" => "email_regis", 'label' => false, 'type' => 'text']) ?>
            </label>
        </div>
        <div class="row">
            <label for="password-2">
                Mật khẩu:
                <input type="password" name="password" id="password_regis" />
            </label>
        </div>
        <div class="row">
            <label for="repassword-2">
                Nhập lại mật khẩu:
                <input type="password" name="re_password" id="re_password" />
            </label>
        </div>
        <div class="row">
            <label for="repassword-2">
                Số điện thoại:
                <!-- <input type="text" name="profiles.phone" id="phone_number" /> -->
                <?= $this->Form->input('profiles.phone', ['id' => 'phone_number', 'label' => false, 'type' => 'text']) ?>
            </label>
        </div>
        <div class="row">
            <button type="submit">Đăng ký</button>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>