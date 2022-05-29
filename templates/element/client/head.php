<!DOCTYPE html>
<html lang="en" class="no-js">

<!-- userprofile14:04-->

<head>
	<!-- Basic need -->
	<title><?= $this->fetch('title') ?></title>
	<meta charset="UTF-8">
	<meta property="og:title" content="Đồ Án Tốt Nghiệp - DATN by TungNT" />
	<meta property="og:description" content="Sản phẩm đồ án được thực hiện bởi Nguyễn Thanh Tùng" />
	<meta property="og:image" content="https://pj-movies.s3.ap-southeast-1.amazonaws.com/open_graph.jpg" />
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<link rel="profile" href="#">
	<?php echo $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>

	<!--Google Font-->
	<link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Dosis:400,700,500|Nunito:300,400,600' />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;500;600&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
	<!-- Mobile specific meta -->
	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone-no">

	<!-- CSS files -->
	<?= $this->Html->css(['client/style', 'client/plugins', 'client/tabs', 'jquery.rateyo.min', 'admin/jquery-ui.css']) ?>
	<?php echo $this->Html->script(['jquery.min', 'admin/jquery-ui', 'jquery.rateyo.min']) ?>

</head>