<!-- footer section-->
<?php if(empty($flag_error)):?>
<footer class="ht-footer">
	<div class="container">
		<div class="flex-parent-ft">
			<div class="flex-child-ft item1">
				 <!-- <a href="#"><?php //echo $this->Html->image('default/logo1.png',['class'=>'logo'])
								?></a> -->
                <p>Lưu ý: các tính năng phần này đang trong quá trình phát triển <br/> Thành thật xin lỗi vì sự bất tiện này.</p> 
              	<p>Địa chỉ: Đang cập nhật</p>
				<p>Số điện thoại: <a href="#">(+01) 223456789</a></p>
			</div>
			<div class="flex-child-ft item2">
				<h4>Resources</h4>
				<ul>
					<li><a href="#">About</a></li> 
					<li><a href="#">Blockbuster</a></li>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Forums</a></li>
					<li><a href="#">Blog</a></li>
					<li><a href="#">Help Center</a></li>
				</ul>
			</div>
			<div class="flex-child-ft item3">
				<h4>Legal</h4>
				<ul>
					<li><a href="#">Terms of Use</a></li> 
					<li><a href="#">Privacy Policy</a></li>	
					<li><a href="#">Security</a></li>
				</ul>
			</div>
			<div class="flex-child-ft item4">
				<h4>Account</h4>
				<ul>
					<li><a href="#">My Account</a></li> 
					<li><a href="#">Watchlist</a></li>	
					<li><a href="#">Collections</a></li>
					<li><a href="#">User Guide</a></li>
				</ul>
			</div>
			<div class="flex-child-ft item5">
				<h4>Newsletter</h4>
				<p>Subscribe to our newsletter system now <br> to get latest news from us.</p>
				<form action="#">
					<input type="text" placeholder="Chức năng đang phát triển">
				</form>
				<!-- <a href="#" class="btn">Subscribe now <i class="ion-ios-arrow-forward"></i></a> -->
			</div>
		</div>
	</div>
	<div class="ft-copyright">
		<div class="ft-left">
			<!-- <p><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></p> -->
		</div>
		<div class="backtotop">
			<p><a href="#" id="back-to-top">Back to top  <i class="ion-ios-arrow-thin-up"></i></a></p>
		</div>
	</div>
</footer>
<?php endif;?>
<!-- end of footer section-->

<?= $this->Html->script(['font-awesome', 'client/plugins', 'client/plugins2', 'client/custom', 'client/common', 'sweetalert2']) ?>
<?= $this->Html->script(['jquery.validate.min', 'additional-methods.min']) ?>