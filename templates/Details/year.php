<?php $this->assign("title", "Phim năm " . $year) ?>
<div class="hero common-hero">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="hero-ct">
					<h1><?php echo 'Phim năm ' . $year ?></h1>
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
							'title' => $year,
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
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<?php if(!empty($year_movies->toArray())):?>
					<div class="topbar-filter fw">
						<p>Đã tìm thấy tổng cộng có: <span><?php echo $count_year_movies ?> </span>phim</p>
						<label>Sắp xếp:</label>
						<select>
							<option value="date_desc">Ngày gần nhất</option>
							<option value="date_asc">Ngày tăng dần</option>
						</select>
					</div>
					<div class="flex-wrap-movielist mv-grid-fw">
						<?php foreach ($year_movies as $key => $year_movie) : ?>
							<div class="movie-item-style-2 movie-item-style-1">
								<?php echo $this->Html->image(!empty($year_movie->movie->thumb) ? $url_s3 . "uploads/thumbs/" . @h($year_movie->movie->thumb) : 'default/mv-item1.jpg', ['style' => 'width:170px;height:261px']); ?>
								<div class="hvr-inner">
									<a href="<?php echo $this->Url->build(["_name" => "movies_details", "slug" => $year_movie->movie->m_slug, "id" => $year_movie->movie->id]); ?>"> Chi tiết <i class="ion-android-arrow-dropright"></i> </a>
								</div>
								<div class="mv-item-infor">
									<h6><a href="<?php echo $this->Url->build(["_name" => "movies_details", "slug" => $year_movie->movie->m_slug, "id" => $year_movie->movie->id]); ?>"><?= $year_movie->movie->m_name ?></a></h6>
									<div class="cate mt-2">
										<span class="blue"><a href="#"><?= $year_movie->resolution ?></a></span>
									</div>
									<p class="rate"><i class="ion-android-star"></i><span><?= !empty($rating[$key]) ? round($rating[$key], 2) : 5 ?></span> /5</p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="topbar-filter">
						<label>Phim mỗi trang:</label>
						<select>
							<option value="range">20 phim</option>
							<option value="saab">10 phim</option>
						</select>

						<div class="pagination2">
							<span>Page 1 of 2:</span>
							<a class="active" href="#">1</a>
							<a href="#">2</a>
							<a href="#">3</a>
							<a href="#">...</a>
							<a href="#">78</a>
							<a href="#">79</a>
							<a href="#"><i class="ion-arrow-right-b"></i></a>
						</div>
					</div>
				<?php else:?>
					<div class="flex-wrap-movielist mv-grid-fw">
						<p style="font-size:28px; text-align:justify">Chưa cập nhật phim hoặc không có phim.! <br><br> <span>Rất xin lỗi vì điều này.</span> </p>
					</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>