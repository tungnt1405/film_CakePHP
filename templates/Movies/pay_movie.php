<?php $this->assign('title','Mua phim')?>
<?php $session = $this->request->getSession();?>
<head>
    <?php echo $this->Html->css(['client/payment','client/materialdesignicons.min','client/vuetify.min']) ?>

    <style>
        .payment-order:nth-child(2):after {
            content: '';
            height: 8px;
            background: yellowgreen;
            width: 67px;
            position: absolute;
            right: -145px;
            top: 36%;
        }
        .payment-order:nth-child(2):before {
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
        }

        #payment-vnpay,#payment-paypal{
            margin-right: 10px;
        }
        label.payment-pay-error{
            display: none;
            font-size: 16px;
            color: red !important;
            font-weight: 100;
            margin-bottom: 0px !important;
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
                        <li class="payment-order"><span  class="payment-active">2</span></li>
                        <li class="payment-order"><span>3</span></li>
                        <li class="payment-order"><span>4</span></li>
                    </ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="page-single" id="page-single">
    <h1 class="payment--title">Thông tin mua phim</h1>
    <?php echo $this->Form->create(null, ['id'=>'formPaymentConfirm','style'=>'position:relative;'])?>
        <v-container>
            <div class="payment--info">
                <v-row>
                    <v-col cols="12" md="12">
                        <p style="color:#000; font-size: 18px; font-weight: 500">Vui lòng nhập đầy đủ các trường có <span class="input--required">*</span></p>
                    </v-col>
                </v-row>
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
                        <input type="text" name="payment-name" id="payment-name" placeholder="Tên người mua">
                    </v-col>
                    <v-col cols="12" md="6">
                        <label for="payment-email">Địa chỉ email <span class="input--required">*</span></label>
                        <input type="text" name="payment-email" id="payment-email" placeholder="Địa chỉ email">
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6">
                        <label for="payment-name">Số điện thoại <span class="input--required">*</span></label>
                        <input type="text" name="payment-phone" id="payment-phone" placeholder="Số điện thoại">
                    </v-col>
                    <v-col cols="12" md="6">
                        <label for="payment-note">Lời nhắn</label>
                        <textarea name="payment-note" id="payment-note" style="border-style:solid; height: 100px; background: #fff;"></textarea>
                    </v-col>
                </v-row>
                <h3 class="payment--info-title">Phương thức thanh toán</h3>
                <v-row>
                    <v-col cols="12" md="12">
                        <input type="radio" id="payment-vnpay" name="payment-pay" value="vn_pay">
                        <?php echo $this->Html->image('default/vnpay.svg',['width'=> 120, 'height'=>120,'style'=>'margin-right: 50px;'])?>
                        <input type="radio" id="payment-paypal" name="payment-pay" value="paypal" disabled>
                        <?php echo $this->Html->image('default/paypal.webp',['width'=> 120, 'height'=>120])?>
                        <label generated="true" class="payment-pay-error">Vui lòng chọn phương thức thanh toán</label>
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
                    <v-col cols="12" md="6">&nbsp;</v-col>
                    <v-col cols="12" md="6">
                        <v-btn class="btn" color="primary" elevation="2" type="submit">Mua phim</v-btn>
                    </v-col>
                </v-row>
            </div>
        </v-container>
    <?php echo $this->Form->end()?>
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