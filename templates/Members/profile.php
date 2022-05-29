<?php $this->assign('title', 'Hồ sơ cá nhân'); ?>
<style>
	.avatar {
		height: 125px;
		width: 125px;
		border-radius: 50%
	}

	.modal {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}

	.btn.change-avtar {
		width: 100px;
		height: 40px;
		border-radius: 5px;
	}

	.btn-primary {
		background-color: #0275d8;
		color: #fff;
		border-color: #0275d8;
	}
</style>
<div class="hero user-hero">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="hero-ct">
					<h1>Thông tin: <?= $member_info['name'] ?></h1>
					<?php
					$this->Breadcrumbs->add([
						[
							'title' => 'Trang chủ',
							'url' => ['controller' => 'Pages', 'action' => 'home'],
							'options' => [
								'class' => 'active'
							]
						],
						[
							'title' => $member_info['name'],
							'options' => [
								'innerAttrs' => [
									'class' => "ion-ios-arrow-right"
								]
							]

						]
					]);
					echo $this->Breadcrumbs->render();
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="page-single">
	<div class="container">
		<div class="row ipad-width">
			<div class="col-md-3 col-sm-12 col-xs-12">
				<div class="user-information">
					<div class="user-img">
						<!-- Để tạm sau xóa điều kiện -->
						<a href="#"><?= $this->Html->image('upload/users/' . ($member_info['img_avatar']), ['class' => 'avatar']) ?><br></a>
						<a href="#" class="redbtn" data-toggle="modal" data-target="#changeAvatar">Change avatar</a>
					</div>
					<div class="user-fav">
						<p>Chi tiết tài khoản</p>
						<ul>
							<li class="active"><a href="#infoFrm">Thông tin</a></li>
							<li><a href="#">Phim yêu thích</a></li>
							<li><a href="/card">Thẻ thanh toán</a></li>
						</ul>
					</div>
					<div class="user-fav">
						<p>Khác</p>
						<ul>
							<li><a href="#passwordFrm">Thay đổi mật khẩu</a></li>
							<li><a href="<?= $this->Url->build(['_name' => 'users_logout']) ?>">Đăng xuất</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-9 col-sm-12 col-xs-12">
				<div class="form-style-1 user-pro" action="#">
					<?= $this->Form->create(null, [
						'class' => 'user',
						'id' => 'infoFrm',
						'action' => '/users/profile/' . ($member_info['id'])
					]) ?>
					<h4>01. Thông tin cá nhân</h4>
					<div class="row">
						<div class="col-md-6 form-it">
							<?= $this->Form->control('name', [
								'label' => 'Tên người dùng',
								'placeholder' => $member_info['name']
							])
							?>
						</div>
						<div class="col-md-6 form-it">
							<?= $this->Form->control('email', [
								'label' => 'Địa chỉ Email',
								'value' => $member_info['email'],
								'readonly',
								'style' => 'background-color:#233A50; color: #abb7c4'
							])
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-it">
							<?= $this->Form->control('number_phone', [
								'label' => 'Số điện thoại',
								'placeholder' => @h($member->profile->phone)
							])
							?>
						</div>
						<div class="col-md-6 form-it">
							<?= $this->Form->control('role', [
								'label' => 'Thành viên',
								'placeholder' => $member_info['role'],
								'disabled' => true,
								'style' => 'background-color:#233A50; color: #abb7c4'
							])
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-it">
							<label for="">Tỉnh/Thành Phố</label>
							<input type="text" style='background-color:#233A50; color: #abb7c4; margin-bottom:10px' value="<?= @h($member->profile->address_city) ?>" disabled>
							<?php echo $this->Form->control('country', [
								'label' => 'chọn Tỉnh/Thành Phố để cập nhật lại',
								'id' => 'country',
								'options' => [],
							])
							?>
						</div>
						<div class="col-md-6 form-it">
							<label for="">Quận/Huyện</label>
							<input type="text" style='background-color:#233A50; color: #abb7c4; margin-bottom:10px' value="<?= @h($member->profile->address_district) ?>" disabled>
							<?= $this->Form->control('city', [
								'label' => 'chọn Quận/Huyện để cập nhật lại',
								'id' => 'city',
								'options' => [],
							])
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<?= $this->Form->input('update_submit', ['value' => 'Cập nhật', 'type' => 'submit', 'class' => 'submit']) ?>
						</div>
					</div>
					<?= $this->Form->end() ?>
					<?= $this->Form->create(null, [
						'class' => 'password',
						'id' => 'passwordFrm',
						'action' => '/users/change-password/' . ($member_info['id'])
					]) ?>
					<h4>02. Thay đổi mật khẩu</h4>
					<div class="row">
						<div class="col-md-6 form-it">
							<?= $this->Form->control('old_password', [
								'label' => 'Mật khẩu cũ',
								'type' => 'password',
								'placeholder' => '**********'
							])
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-it">
							<?= $this->Form->control('new_password', [
								'label' => 'Mật khẩu mới',
								'type' => 'password',
								'id' => 'new_password',
								'placeholder' => "***************"
							])
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-it">
							<?= $this->Form->control('cf_password', [
								'label' => 'Nhập lại mật khẩu mới',
								'type' => 'password',
								'placeholder' => "***************"
							])
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<?= $this->Form->input('update_submit', ['value' => 'Thay đổi', 'type' => 'submit', 'class' => 'submit']) ?>
						</div>
					</div>
					<?= $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="changeAvatar" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Thay ảnh đại diện</h5>
				</button>
			</div>
			<div class="modal-body">
				<?php
				echo $this->Form->create(null, [
					'id' => 'changeFrm',
					'action' => '/users/change-avatar/' . ($member_info['id']),
					'type' => 'file'
				]);
				echo $this->Html->image('upload/users/' . ($member_info['img_avatar']), ['style' => 'width:80px; height: 80px; border-radius: 50%; margin-bottom: 5px', 'title' => 'ảnh hiện tại']);
				echo $this->Form->control('img_change', [
					'label' => 'Thay ảnh đại diện',
					'type' => 'file',
					'id' => 'file'
				]);
				echo '<div class="box-pre-img hidden ml-3" style="margin-top: 5px"></div>';
				echo $this->Form->end();
				?>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary change-avtar" form="changeFrm">Thay đổi</button>
				<button type="button" class="btn btn-secondary change-avtar" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?= $this->Html->script('client/user') ?>