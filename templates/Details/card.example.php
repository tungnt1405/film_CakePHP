<?php $this->assign("title", 'Tích hợp thẻ') ?>
<head>
    <?php echo $this->Html->css(['client/materialdesignicons.min','client/vuetify.min'])?>
</head>
<style>
    .v-label{
        color:red
    }
</style>
<div class="hero common-hero">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="hero-ct">
					<h1><?php echo "Thẻ thanh toán" ?></h1>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="page-single" id="page-single">
    <h1 class="title-payment">Thông tin thanh toán</h1>
    <?php //echo $this->Form->create(null,['id'=>'formPayment','v-model'=>'valid'])?>
    <v-form ref="form" action="/card" id="formPayment" v-model="valid" lazy-validation @submit.prevent="submit">
        <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken')?>">
        <v-container>
            <div class="alert--notify">Vui lòng điền đầy đủ thông tin các ô có dấu <span class="input--required">*</span></div>
            <input type="hidden" name="desc" v-model="formData.desc">
            <v-row>
                <v-col cols="12" md="6">
                    <v-text-field required :rules="[rules.required]" hide-details="auto" class="input--custom" name="full_name" v-model="formData.full_name">
                    <template v-slot:label>
                        Họ tên <span class="input--required">*</span>
                    </template>
                    </v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field required :rules="[rules.required, rules.email]" hide-details="auto" class="input--custom" name="email" v-model="formData.email">
                    <template v-slot:label>
                        Địa chỉ Email <span class="input--required">*</span>
                    </template>
                    </v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="6">
                    <v-text-field required :rules="[rules.required, rules.number_phone]" hide-details="auto" class="input--custom" name="phone_number" v-model="formData.number_phone">
                    <template v-slot:label>
                        Số điện thoại <span class="input--required">*</span>
                    </template>
                    </v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field required :rules="[rules.required]" hide-details="auto" class="input--custom" name="address" v-model="formData.address">
                    <template v-slot:label>
                        Địa chỉ <span class="input--required">*</span>
                    </template>
                    </v-text-field>
                </v-col>
            </v-row>
            <!-- chưa làm require -->
            <v-row>
                <v-col cols="12" md="6">
                    <v-text-field required :rules="[rules.required]" hide-details="auto" class="input--custom" name="city" v-model="formData.city">
                    <template v-slot:label>
                        Tỉnh <span class="input--required">*</span>
                    </template>
                    </v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field required :rules="[rules.required]" hide-details="auto" class="input--custom" name="post_code" v-model.number="formData.post_code">
                    <template v-slot:label>
                        Mã bưu điện <span class="input--required">*</span>
                    </template>
                    </v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="6">
                    <v-text-field required :rules="[rules.required]" hide-details="auto" class="input--custom" name="country" v-model="formData.country">
                    <template v-slot:label>
                        Quốc gia <span class="input--required">*</span>
                    </template>
                    </v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field required :rules="[rules.required]" hide-details="auto" class="input--custom" name="payment-amount" v-model="formData.payment_amount">
                    <template v-slot:label>
                        Giá tiền <span class="input--required">*</span>
                    </template>
                    </v-text-field>
                </v-col>
            </v-row>
            <!-- hết phần chưa làm require -->
            <v-row>
                <v-col cols="12" md="12">
                    <v-textarea
                    label="Lời nhắn"
                    class="textarea--payment"
                    rows="5"
                    name="payment-note"
                    row-height="200"
                    ></v-textarea>
                </v-col>
            </v-row>
            <v-row class="pull-right">
                <v-btn class="btn" type="submit" form="formPayment" :disabled="!valid">Mua phim</v-btn>
            </v-row>
        </v-container>
    <?php //echo $this->Form->end();?>
    </v-form>
</div>
<?= $this->Html->script(['client/vue','client/vuetify','client/axios.min'])?>
<script>
let app = new Vue({
    el:"#page-single",
    vuetify: new Vuetify(),
    data(){
        return{
            valid: false,
            formData:{
                desc: `Mua phim <?php echo "123"?>`,
                full_name: '',
                email: '',
                number_phone: null,
                address: '',
                city: '',
                post_code: '',
                country: '',
                payment_amount: null
            },
            rules: {
                required: value => !!value || 'Vui lòng không bỏ trống ô này',
                email: value=>{
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    return pattern.test(value) || 'Địa chỉ email không đúng định dạng.'
                },
                number_phone: value=>{
                    const check_phone = /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/;
                    return check_phone.test(value) || 'Số điện thoại không đúng'
                },
            },
        }
    },
    methods:{
        submit(){
            this.$refs.form.validate()  
            this.sendSanbox();
        },

        sendSanbox(){
            let email = this.formData.email;
            let desc = this.formData.desc;
            console.log(email);
            $.ajax({
                url: '/card',
                type:'post',
                data: {
                    _csrfToken: $('[name="_csrfToken"]').val(),
                    desc: desc,
                    full_name: $('[name="full_name"]').val(),
                    email: email,
                    phone_number: $('[name="phone_number"]').val(),
                    address: $('[name="address"]').val(),
                    city: $('[name="city"]').val(),
                    post_code: $('[name="post_code"]').val(),
                    country: $('[name="country"]').val(),
                    'payment-amount': $('[name="payment-amount"]').val(),
                    'payment-note': $('[name="payment-note"]').val()
                },
                success: function(data){
                    console.log(data.result);
                    location.href = data.result
                }
            })
            // axios.post('/card', {
            //     _csrfToken: $('[name="_csrfToken"]').val(),
            //     full_name: $('[name="full_name"]').val(),
            //     email: email,
            //     phone_number: $('[name="phone_number"]').val(),
            //     address: $('[name="address"]').val(),
            //     city: $('[name="city"]').val(),
            //     post_code: $('[name="post_code"]').val(),
            //     country: $('[name="country"]').val(),
            //     price: $('[name="price"]').val(),
            // })
            // .then(function (response) {
            //     console.log(respone.result);
            //     // location.href = response.data
            //     // window.location.href = response.data
            // })
            // .catch(function (error) {
            //     this.formData.full_name = '';
            //     this.formData.email = '';
            //     this.formData.number_phone = null;
            //     this.formData.address = '';
            //     this.formData.city = '';
            //     this.formData.post_code = '';
            //     this.formData.country = '';
            //     this.formData.price = null;
            //     console.log(error);
            // });
        },
    }
});
</script>
<style>
    .input--custom input{
        background-color: #233A50;
        padding-left: 5px !important;
        color: #fff !important;
    }
    .input--custom label{
        color: #fff !important;
        font-size: 20px;
        margin-left: 5px;
    }
    .v-messages__message{
        color: #fff !important;
        font-size: 18px;
        margin-top: 5px;
        line-height: 20px !important;
    }
    .alert--notify{
        max-width: 49%;
        border-left: 5px red solid;
        padding-left: 10px;
        background-color: #fff;
        color: #000;
        line-height: 30px;
        font-size: 18px;
        margin-bottom: 20px;
    }
    .input--required{
        color: red
    }
    .theme--light.v-btn.v-btn--has-bg{
        margin-right: 12px;
    }
    /* .theme--light.v-btn{
        color: rgba(0,0,0,.87);
    } */
    .title-payment{
        color: #fff;
        text-align: center;
        text-transform: uppercase;
    }
    .textarea--payment textarea, .textarea--payment label{
        color: #fff !important;
        font-size: 20px;
    }
    .textarea--payment textarea{
        border-bottom: 1px solid #fff !important;
    }
    .textarea--payment textarea:focus{
        border-bottom: 1px solid #fff !important;
        outline: #fff !important;
    }
    .v-input--is-focused input,
    .textarea--payment.v-input--is-focused textarea {
        border: 2px solid #4FC3F7 !important;
        border-color: #4FC3F7 !important;
        height: 200px !important;
    }
    .theme--light.v-btn.v-btn--disabled.v-btn--has-bg{
        background-color: #fff !important;
    }
</style>