<div class="login-wrapper" id="login-content">
    <div class="login-content">
        <a href="#" class="close">x</a>
        <h3 class="title-form--user">Đăng nhập</h3>
        <p class="notify hidden" style="color: red; font-size: 16px; font-weight: 500">hihi</p>
        <?= $this->Form->create(null, ['id' => 'formLogin', 'onsubmit' => 'return false', 'class' => '']) ?>
        <div class="row">
            <label for="email">
                Email:
                <?= $this->Form->control('email', array(
                    'type' => 'text',
                    'placeholder' => 'Nhập địa chỉ email',
                    'id' => 'email',
                    'label' => false
                )) ?>
            </label>
        </div>

        <div class="row">
            <label for="password">
                Password:
                <?= $this->Form->control('password', array(
                    'type' => 'password',
                    'id' => 'password',
                    'placeholder' => '**********',
                    'label' => false
                )) ?>
            </label>
        </div>
        <div class="row">
            <div class="remember">
                <!-- <div>
						<input type="checkbox" name="remember" value="Remember me"><span>Remember me</span>
					</div> -->
                <a class="pull-right forward-pass" href="#">Quên mật khẩu ?</a>
            </div>
        </div>
        <div class="row">
            <button type="submit form-login">Đăng nhập</button>
        </div>
        <?= $this->Form->end() ?>
        <div class="row login-social">
            <p>Đăng nhập bằng tài khoản khác</p>
            <div class="social-btn-2">
                <a class="fb" href="#"><i class="ion-social-facebook"></i>Facebook</a>
                <a class="tw" href="#"><i class="ion-social-twitter"></i>twitter</a>
            </div>
        </div>
        <?= $this->Form->create(null, ['id' => 'formReset', 'class' => 'hidden', 'action' => $this->Url->build(['_name' => 'forward'])]) ?>
        <div class="row">
            <label for="email_reset">
                Email:
                <?= $this->Form->control('email_reset', array(
                    'type' => 'text',
                    'placeholder' => 'Nhập địa chỉ email',
                    'id' => 'email_reset',
                    'label' => false
                )) ?>
            </label>
        </div>
        <div class="row">
            <div class="remember">
                <!-- <div>
						<input type="checkbox" name="remember" value="Remember me"><span>Remember me</span>
					</div> -->
                <a class="pull-right login" href="#">Đăng nhập nếu bạn đã đăng ký.</a>
            </div>
        </div>
        <div class="row">
            <button type="submit form-reset">Lấy mật khẩu</button>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
<?= $this->Html->script('client/user') ?>