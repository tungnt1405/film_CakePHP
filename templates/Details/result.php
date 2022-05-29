<?php $this->assign('title', 'Thông báo')?>
<?php $vnp_status = $_GET['vnp_ResponseCode'];?>
<head>
    <?php echo $this->Html->css(['client/payment','client/materialdesignicons.min','client/vuetify.min']) ?>

    <style>
        .payment--info input:focus, .payment--info textarea:focus{
            border: 2px solid #2ecc71;
            transition: width 2s;
            outline: none;
        }
        .payment--info input::before{
            content: "";
            width: 100%;
            height: 100%;
            background: #4158d0;
            transform: scaleX(0);
            transform-origin: center;
            transition: transform 0.3s ease;
            outline: none;
        }
        .theme--light.v-btn.v-btn--has-bg{
            background-color: #236ed3 !important;
        }

        #payment-vnpay,#payment-paypal{
            margin-right: 10px;
        }
        .payment-back.theme--light.v-btn.v-btn--has-bg{
            background-color: #f5f5f5 !important;
        }
    </style>
</head>
<div class="hero common-hero">
    <div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="hero-ct">
                    <ul class="payment">
                        <li class="payment-order"><span >1</span></li>
                        <li class="payment-order"><span>2</span></li>
                        <li class="payment-order"><span>3</span></li>
                        <li class="payment-order"><span class="payment-active">4</span></li>
                    </ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="page-single" id="page-single">
    <h1 class="payment--title">Thông báo</h1>
    <?php if($vnp_status === '00' || $vnp_status == '00'):?>
        <v-container>
            <div class="payment-notify" style="height: 400px; text-align: center">
                <i class="fa fa-film" style="height: 120px; margin-top: 55px;" aria-hidden="true"></i>
                <p style="color: #000; font-size: 25px; margin-top: 20px; line-height: 20px">Thanh toán thành công</p>
                <a href="/"><v-btn color="primary">Trở lại trang chủ</v-btn></a>
            </div>
        </v-container>
    <?php else:?>
        <v-container>
            <div class="payment-notify" style="height: 400px; text-align: center">
                <i class="fa fa-film" style="height: 120px; margin-top: 55px;" aria-hidden="true"></i>
                <p style="color: #000; font-size: 25px; margin-top: 20px; line-height: 20px">Hủy thanh toán thành công</p>
                <a href="/pay_info"><v-btn color="primary">Mua phim</v-btn></a>
                <a href="/"><v-btn class="payment-back">Trang chủ</v-btn></a>
            </div>
        </v-container>
    <?php endif;?>
</div>
<?= $this->Html->script(['client/vue','client/vuetify','client/axios.min'])?>
<script>
    new Vue({
        el: '#page-single',
        data: () => {
            return{
            }
        }
    })
</script>