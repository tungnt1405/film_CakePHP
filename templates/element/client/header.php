<style>
	header .top-search {
		margin: 0 auto;
		width: 80%;
		justify-content: center !important;
	}
</style>
<header class="ht-header">
	<div class="container">
		<nav class="navbar navbar-default navbar-custom">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header logo">
				<div class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<div id="nav-icon1">
						<span></span>
						<span></span>
						<span></span>
					</div>
				</div>
				<a href="/"><?= $this->Html->image('default/logo1.png', ['class' => 'logo', 'width' => 119, 'height' => '58']) ?></a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse flex-parent" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav flex-child-menu menu-left">
					<li class="hidden">
						<a href="#page-top"></a>
					</li>
					<li class="dropdown first">
						<a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown">
							Thể loại <i class="fa fa-angle-down" aria-hidden="true"></i>
						</a>
						<ul class="dropdown-menu level1">
							<?php foreach ($genres as $genre) : ?>
								<li><a href="<?php echo $this->Url->build(['_name' => 'genres_details', 'slug' => $genre->slug]) ?>"><?= $genre->title ?></a></li>
							<?php endforeach; ?>
						</ul>
					</li>
					<li class="dropdown first">
						<a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown">
							Quốc gia <i class="fa fa-angle-down" aria-hidden="true"></i>
						</a>
						<ul class="dropdown-menu level1">
							<?php foreach ($countries as $country) : ?>
								<li><a href="<?php echo $this->Url->build(['_name' => 'countries_details', 'slug' => $country->country_slug]) ?>"><?= $country->country_name ?></a></li>
							<?php endforeach; ?>
						</ul>
					</li>
					<?php foreach ($categories as $category) : ?>
						<li><a href="<?php echo $this->Url->build(['_name' => 'category_details', 'slug' => $category->slug]) ?>"><?= $category->title ?></a></li>
					<?php endforeach; ?>
					<li class="dropdown first">
						<a class="btn btn-default dropdown-toggle lv1" data-toggle="dropdown">
							Năm sản xuất <i class="fa fa-angle-down" aria-hidden="true"></i>
						</a>
						<ul class="dropdown-menu level1">
							<?php for ($i = 2022; $i >= 1990; $i--) : ?>
								<li><a href="<?php echo $this->Url->build(['_name' => 'year_details', 'year' => $i]) ?>"><?= $i ?></a></li>
							<?php endfor; ?>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav flex-child-menu menu-right">
					<?php
					if (!empty($member_info)) : ?>
						<?php if (!empty($notifyAccept) && $notifyAccept == 1) {
							header('location: ' . $this->Url->build(['_name' => 'index']));
							die;
						} ?>
						<li><a href="<?= $this->Url->build(['_name' => 'member_profile', 'id' => $member_info['id']]) ?>">Thông tin</a></li>
						<li class="logoutLink"><a href="<?= $this->Url->build(['_name' => 'users_logout']) ?>">đăng xuất</a></li>
					<?php else : ?>
						<li class="loginLink"><a href="#">đăng nhập</a></li>
						<li class="btn signupLink"><a href="#">đăng ký</a></li>
					<?php endif; ?>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</nav>

		<!-- top search form -->
		<form action="/search" method="get">
			<div class="top-search">
				<!-- <select id="search-menu">
					<option value="category">Danh mục</option>
					<option value="genre">Thể loại</option>
					<option value="country">Quốc gia</option>
				</select> -->
				<input type="text" id="tags" name="tag_key" placeholder="Tìm kiếm phim" value="<?= !empty($this->request->getQuery('tag_key')) ? $this->request->getQuery('tag_key') : '' ?>">
				<button class="btn-search--movie" disabled><span class="search-icon"><i class="fa fa-search fa-fw"></i></span>
					<span class="loading-icon hidden"><i class="fas fa-spinner fa-spin"></i></span>
				</button>
			</div>
		</form>
	</div>
</header>

<script>
	var dropdown = $('.dropdown');
	dropdown.hover(
		function() {
			$(this).children('.dropdown-menu.level1').prop('style', 'display:grid; grid-template-columns:repeat(3, 1fr); min-width: 180px;');
		},
		function() {
			$(this).children('.dropdown-menu.level1').prop('style', 'display:none');
		}
	);
</script>