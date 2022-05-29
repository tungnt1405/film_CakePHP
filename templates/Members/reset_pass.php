<?php $this->assign('title', 'Đặt mật khẩu mới') ?>
<style>
    #resetPass .input.password 
    {
        width: 40% !important;
        margin: 0 auto !important;
    }
</style>
<div class="hero user-hero">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="hero-ct">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-single">
    <div class="container">
        <div class="row ipad-width">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-style-1 user-pro text-center" action="#">
                    <h4>Nhập mật khẩu mới</h4>
                    <?= $this->Form->create(null, ['id' => 'resetPass']) ?>
                    <div class="row">
                        <div class="col-md-12 form-it text-left">
                            <?= $this->Form->control('new_password', [
                                'label' => 'Mật khẩu mới',
                                'type' => 'password',
                                'id' => 'new_password',
                                'placeholder' => "***************",
                                'class' => 'reset-pass',
                                'autofocus'
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-it text-left">
                            <?= $this->Form->control('cf_password', [
                                'label' => 'Nhập lại mật khẩu mới',
                                'type' => 'password',
                                'placeholder' => "***************",
                                'class' => 'reset-pass'
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <?= $this->Form->input('update_submit', ['value' => 'Cập nhật mật khẩu', 'type' => 'submit', 'class' => 'submit', 'style' => 'width:20%']) ?>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>