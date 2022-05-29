//login
$('#formLogin button').on('click', function(){
    email = $('#email').val();
    password = $('#password').val();
    _csrfToken = $('input[name=_csrfToken]').val();
    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    $('#email, #password').each(function(){
        $(this).on('change',function(){
            $('.error-notify').addClass('hidden');
        })
    });
    if(email === '' || email.trim() === ''){
        $('.error-notify').addClass('hidden');
        $('label[for=email]').append(`<span class="error-notify" style="color:red">Vui lòng nhập địa chỉ email</span>`)
        return;
    }else{
        if (!testEmail.test(email)){
            $('.error-notify').addClass('hidden');
            $('label[for=email]').append(`<span class="error-notify" style="color:red">Email không đúng định dạng</span>`);
            return;
        }else{
            $.ajax({
                url:  "/users/login",
                type: 'post',
                dataType: 'json',
                data: {
                    _csrfToken: _csrfToken,
                    email: email,
                    password: password,
                },
            }).done(function(data){
                if(data == 1){
                    location.reload();
                }else{
                    $('.notify').removeClass('hidden');
                    $('.notify').html("Tài khoản hoặc mật khẩu không chính xác")
                }
            });
        }
    }
});

//register


//get api cities
$ajax_api_cities = $.ajax({
    url: 'http://mr80.net/files/2015/09/vietnam_provinces_cities.json',
    type:'get',
    dataType: 'json',
    success: function(data){
        doneFunc(data)
    }
})

var doneFunc = function(data){
    //get list city
    const name_city = $.each(data, (i, item)=>{
        $("#country").append($('<option/>',{
            value: i,
            text: item.name
        }));
        if(item.name == "Hà Nội"){
            $.each(item.cities, (k, item2)=>{
                $("#city").append($('<option/>',{
                    value: k,
                    text: item2
                }));
            })
        }
    });
    
    //get list district to city
    let name_district = $.each(data , (i, item)=>{
        $("#country").on('change',function(){
            let name_get_change = $(this).find("option:selected").text();
            if(item.name == name_get_change){
                if(name_get_change){
                    $("#city option")
                    .remove()
                    .end();
                }
                $.each(item.cities, (k, item2)=>{
                    $("#city").append($('<option/>',{
                        value: k,
                        text: item2
                    }));
                })
            }
        })
    });
}

//show img previous
$('#file').change(function () {
    var fileImg = $('input#file').val();
    console.log();
    if (fileImg != '') {        
        $('.box-pre-img').removeClass('hidden');
        $('.box-pre-img').addClass('form-group');
        $('.box-pre-img').html(`<p><strong>Ảnh xem trước</strong></p>`)
        $('.box-pre-img').append(`<img src="${URL.createObjectURL(event.target.files[0])}" style="width:80px; height: 80px; border-radius: 50%; margin-bottom: 5px"/>`)
    }
})

//check validate
$().ready(function(){
    //check number phone
    jQuery.validator.addMethod("phone_number", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && 
        phone_number.match(/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/);
    }, "Số điện thoại không đúng định dạng");


    //check password
    $.validator.addMethod("validatePassword", function (value, element) {
        return this.optional(element) || /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/i.test(value);
    }, "Hãy nhập password từ 8 đến 16 ký tự bao gồm chữ hoa, chữ thường và ít nhất một chữ số");


    //check filesize
    $.validator.addMethod(
        "filesize",
        (value, element, param) => {
            const limit = parseInt(param) * 1024 *1024;
            const size = element.files[0].size;
            if(size>limit){
                return false;
            }
            return true;
        },
        "Dung lượng không vượt quá 1MB"
    );

    //check validator info
    $('#infoFrm').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        debug: true,
        rules: {
            name : {
                required : true,
                maxlength: 50
            },
            number_phone : {
                required : true,
                phone_number: true
            },
            country: {
                required: true
            },
            city: {
                required: true
            },
        },
        messages: {
            name: {
                required: "Tên khách hàng không được để trống",
                maxlength: "Nhập tối đa 50 ký tự"
            },
            number_phone : {
                required: "Số điện thoại không được để trống",
            },
            country : {
                required: "Vui lòng chọn Tỉnh/Thành Phố",
            },
            city : {
                required: "Vui lòng chọn Quận/Huyện",
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
    
    //check validator change_img
    $('#changeFrm').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        debug: true,
        rules: {
            img_change : {
                required: true,
                extension: "png|jpeg|jpg|gif",
                filesize: 1
            },
        },
        messages: {
            img_change: {
                required: "Hãy chọn avatar cho tài khoản",
                extension: "Avatar là hình ảnh có định dạng png || jpeg || jpg || gif",
                filesize: "Dung lượng không vượt quá 1MB"
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });

    //check validator pass
    $('#passwordFrm').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        debug: false,
        success: 'valid',
        rules: {
            old_password : {
                required : true,
            },
            new_password : {
                required : true,
                validatePassword: true
            },
            cf_password : {
                required : true,
                validatePassword: true,
                equalTo: "#new_password"
            },
        },
        messages: {
            old_password: {
                required: "Không để trống mật khẩu",
            },
            new_password : {
                required: "Vui lòng nhập mật khẩu mới",
            },
            cf_password : {
                required: "Vui lòng xác nhận mật khẩu mới",
                equalTo: "Mật khẩu xác nhận không trùng khớp"
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });

    //check register
    $('#registerForm').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            name : {
                required : true,
                maxlength: 50
            },
            email_regis : {
                required : true,
                email : true,
                remote: {
                    url: "/checkEmail",
                    type: "POST",
                    cache: false,
                    dataType: "json",
                    data: {
                        _csrfToken: function(){return $("meta[name=csrfToken]").attr('content')},
                        email_regis: function() { return $("#email_regis").val(); }
                    },
                    dataFilter: function (response) {
                        respone_d = response;

                        if (response === 0 || response != 1) {
                            return true;
                        }else{
                            message = 'Email đã tồn tại';
                            return false;
                        }
                    },                                     
                },
            },
            password : {
                minlength: 8,
                maxlength: 32,
                required : true,
                validatePassword: true,
            },
            re_password: {
                required: true,
                validatePassword: true,
                equalTo: "#password_regis"
            },
            'profiles[phone]' : {
                required: true,
                phone_number: true
            }
        },
        messages: {
            name: {
                required: "Tên khách hàng không được để trống",
                maxlength: "Nhập tối đa 50 ký tự"
            },
            email_regis : {
                required: "Email không được để trống",
                email: "Email sử dụng không đúng định dạng *@*.*",
                // remote: "Email đã tồn tại"
                remote: function(){ return message; }
            },
            password : {
                minlength: "Mật khẩu ít nhất phải 8 ký tự trở lên",
                maxlength: "Mật khẩu tối đa 32 ký tự trở xuống",
                required: "Không bỏ trống mật khẩu",
            },
            re_password : {
                required: "Không bỏ trống mật khẩu",
                equalTo: "Mật khẩu xác nhận không trùng khớp"
            },
            'profiles[phone]' : {
                required: "Số điện thoại không được để trống",
            }
        },
        submitHandler: function (form, event) {
            form.submit()
        },
        
    });
    // .submit(function(e){
    //     e.preventDefault();
    //     $.ajax({
    //         url: $(this).attr('action'),
    //         type: $(this).attr('type'),
    //         data: $(this).serialize(),
    //     }).done(function(response){
    //         alert(response)
    //     })
    //     return false;
    // });

    $('.forward-pass').on('click', function(){
        $('#formReset').removeClass('hidden');
        $('.login-social').addClass('hidden');
        $('#formLogin').addClass('hidden');
        $('.title-form--user').html('Lấy mật khẩu')
    });

    $('#formReset').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules:{
            email_reset : {
                required : true,
                email : true,
                remote: {
                    url: "/checkEmail",
                    type: "POST",
                    cache: false,
                    dataType: "json",
                    data: {
                        _csrfToken: function(){return $("meta[name=csrfToken]").attr('content')},
                        email_regis: function() { return $("#email_reset").val(); }
                    },
                    dataFilter: function (response) {
                        respone_d = response;

                        if (response != 0 || response == 1) {
                            return true;
                        }else{
                            message = 'Email không tồn tại';
                            return false;
                        }
                    },                                     
                },
            },
        }, 
        messages: {
            email_reset : {
                required: "Email không được để trống",
                email: "Email sử dụng không đúng định dạng *@*.*",
                // remote: "Email đã tồn tại"
                remote: function(){ return message; }
            },
        }, 
        submitHandler: function (form, event) {
            form.submit()
        },
    });

    $('.login').on('click', function(){
        $('#formReset').addClass('hidden');
        $('.login-social').removeClass('hidden');
        $('#formLogin').removeClass('hidden');
        $('.title-form--user').html('Đăng nhập')
    });

    //check validator pass
    $('#resetPass').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        debug: false,
        success: 'valid',
        rules: {
            new_password : {
                required : true,
                validatePassword: true
            },
            cf_password : {
                required : true,
                validatePassword: true,
                equalTo: "#new_password"
            },
        },
        messages: {
            new_password : {
                required: "Vui lòng nhập mật khẩu mới",
            },
            cf_password : {
                required: "Vui lòng xác nhận mật khẩu mới",
                equalTo: "Mật khẩu xác nhận không trùng khớp"
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
});