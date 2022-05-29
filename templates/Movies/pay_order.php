<?php $this->assign('title','Mua phim')?>
<?php $session = $this->request->getSession();?>
<head>
    <?php echo $this->Html->css(['client/payment','client/materialdesignicons.min','client/vuetify.min']) ?>

    <style>
        .payment-order:nth-child(3):after {
            content: '';
            height: 8px;
            background: yellowgreen;
            width: 67px;
            position: absolute;
            right: -145px;
            top: 36%;
        }
        .payment-order:nth-child(3):before {
            content: '';
            position: absolute;
            width: 0;
            height: 0;
            top: 55%;
            border-style: solid;
            border-width: 10px 0 10px 20px;
            border-color: transparent transparent transparent yellowgreen;
            right: -165px;
            transform: translateY(-50%);
        }

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
            margin-left: 20px;
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
                        <li class="payment-order"><span>1</span></li>
                        <li class="payment-order"><span>2</span></li>
                        <li class="payment-order"><span class="payment-active">3</span></li>
                        <li class="payment-order"><span>4</span></li>
                    </ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="page-single" id="page-single">
    <v-container id="payOrder" style="position:relative">
        <div class="payment--info">
            <h3 class="payment--info-title">Danh sách phim</h3>
            <input type="hidden" name="desc" value="Mua phim <?php echo $session->read('info_movie.movie_name');?>">
            <v-row>
                <v-col cols="12" md="12">
                    <img src="https://i.pinimg.com/736x/a6/64/f6/a664f6ae929e7f16620a77c311dd2c88.jpg" width="90" height="150">
                    <span><?php echo $session->read('info_movie.movie_name');?></span> - <span>Giá: <?= number_format(100000)?>VND</span>
                </v-col>
                <v-col cols="12" md="12">
                    <img src="https://i.pinimg.com/736x/a6/64/f6/a664f6ae929e7f16620a77c311dd2c88.jpg" width="90" height="150">
                    <span>Joker</span> - <span>Giá: <?= number_format(100000)?>VND</span>
                </v-col>
            </v-row>
            <h3 class="payment--info-title">Thông tin khách hàng</h3>
            <v-row>
                <v-col cols="12" md="6">
                    <label for="payment-name">Tên người mua <span class="input--required">*</span></label>
                    <p style="color: #000">NGUYEN VAN A</p>
                </v-col>
                <v-col cols="12" md="6">
                    <label for="payment-email">Địa chỉ email <span class="input--required">*</span></label>
                    <p style="color: #000">email@mailsac.com</p>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="6">
                    <label for="payment-name">Số điện thoại <span class="input--required">*</span></label>
                    <p style="color: #000">0123456798</p>
                </v-col>
                <v-col cols="12" md="6">
                    <label for="payment-note">Lời nhắn</label>
                    <textarea disabled name="payment-note" id="payment-note" style="border-style:solid; height: 100px; background: #fff;"><?= $session->read('info_user_movie.payment-note')?></textarea>
                </v-col>
            </v-row>
            <h3 class="payment--info-title">Phương thức thanh toán</h3>
            <v-row>
                <v-col cols="12" md="12">
                    <?php echo $this->Html->image('default/vnpay.svg',['width'=> 120, 'height'=>120,'style'=>'margin-right: 50px;'])?>
                </v-col>
            </v-row>
        </div>
        <div class="payment--checkout">
            <v-row>
                <v-col cols="12" md="12">
                    Tổng tiền: <span class="payment-amount"><?= number_format(200000)?> VND</span>
                    <input type="hidden" name="payment-amount" value="200000">
                </v-col>
                <v-col cols="12" md="12">
                    Số lượng: <span class="payment-amount">x2</span>
                    <input type="hidden" name="payment-quantity" value="2">
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="12">
                    Giảm giá: <span class="payment-amount">0 VND</span>
                    <input type="hidden" name="payment-coupon" value="0">
                </v-col>
                <v-col cols="12" md="12">
                    Thành tiền: <span class="payment-amount"><?= number_format(200000)?> VND</span>
                    <input type="hidden" name="payment-total" value="200000">
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="12">
                    <v-btn class="btn" color="primary" elevation="2" @click="submitPay">Mua phim</v-btn>
                    <a href="/pay_movie"><v-btn class="payment-back">Quay lại</v-btn></a>
                </v-col>
            </v-row>
        </div>
    </v-container>
</div>
<?= $this->Html->script(['client/vue','client/vuetify','client/axios.min'])?>
<script>
    new Vue({
        el: '#page-single',
        data: () => {
            return{
            }
        },
        methods: {
            submitPay(){
                $.ajax({
                    url: '/pay_order',
                    type: 'post',
                    data:{
                        _csrfToken: $("meta[name=csrfToken]").attr('content'),
                    },
                    beforeSend: function() {
                        $('#payOrder').prepend('<div id="overload"><div class="loader"></div></div>');
                    },
                    success: function(data) {
                        window.location.href= data
                        console.log(data);
                    },
                })
            }
        },
    })
</script>