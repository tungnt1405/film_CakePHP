//responsive
$(window).resize(function(){
 
    var width = $(window).width();
    
    if (width <= 768){
        $('div.input-search').removeClass('input-group');
        $('div.input-search .button-search').removeClass('input-group-btn');
    }
    else{
        $('div.input-search').addClass('input-group');
        $('div.input-search .button-search').addClass('input-group-btn');
    }
});
$().ready(function(){
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
    //check validator
    $('#frmAdd').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        debug: true,
        rules: {
            name : {
                required : true,
                maxlength: 50
            },
            email : {
                required : true,
                email : true
            },
            password : {
                minlength: 8,
                maxlength: 32,
                required : true,
            },
            role: {
                required: true
            },
            img_avatar : {
                required: true,
                extension: "png|jpeg|jpg|gif",
                filesize: 1
            }
        },
        messages: {
            name: {
                required: "Tên khách hàng không được để trống",
                maxlength: "Nhập tối đa 50 ký tự"
            },
            email : {
                required: "Email không được để trống",
                email: "Email sử dụng không đúng định dạng *@*.*"
            },
            password : {
                minlength: "Mật khẩu ít nhất phải 8 ký tự trở lên",
                maxlength: "Mật khẩu tối đa 32 ký tự trở xuống",
                required: "Không bỏ trống mật khẩu",
            },
            role : {
                required: "Chưa chọn quyền cho tài khoản",
            },
            img_avatar : {
                required: "Hãy chọn avatar cho tài khoản",
                extension: "Avatar là hình ảnh có định dạng png || jpeg || jpg || gif",
                filesize: "Dung lượng không vượt quá 1MB"
            }
        },
        submitHandler: function (form) {
            form.submit();
        },
    });


    $('#frmEdit').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        debug: false,
        success: 'valid',
        rules: {
            name : {
                required : true,
                maxlength: 50
            },
            email : {
                required : true,
                email : true
            },
            password : {
                minlength: 8,
                maxlength: 32,
                required : true,
            },
            role : {
                required: true
            },
            img_avatar : {
                extension: "png|jpeg|jpg|gif",
                filesize: 1
            }
        },
        messages: {
            name: {
                required: "Tên khách hàng không được để trống",
                maxlength: "Nhập tối đa 50 ký tự"
            },
            email : {
                required: "Email không được để trống",
                email: "Email sử dụng không đúng định dạng *@*.*"
            },
            password : {
                minlength: "Mật khẩu ít nhất phải 8 ký tự trở lên",
                maxlength: "Mật khẩu tối đa 32 ký tự trở xuống",
                required: "Không bỏ trống mật khẩu",
            },
            role: {
                required: "Chưa chọn quyền cho tài khoản",
            },
            img_avatar : {
                extension: "Avatar là hình ảnh có định dạng png || jpeg || jpg || gif",
                filesize: "Dung lượng không vượt quá 1MB"
            }
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
});

//Add file image
$(".files").attr('data-before', "Kéo thả ảnh tại đây hoặc chọn ảnh bỏ vào");
$('input[type="file"]').change(function (e) {
    var fileName = e.target.files[0].name;
    $(".files").attr('data-before', fileName);

});

$('#file').change(function () {
    var fileImg = $('input#file').val();
    if (fileImg != '') {        
        $('.box-pre-img').removeClass('hidden');
        $('.box-pre-img').addClass('form-group');
        $('.box-pre-img').html(`<p><strong>Ảnh xem trước</strong></p>`)
        $('.box-pre-img').append(`<img src="${URL.createObjectURL(event.target.files[0])}" class="show_img_append"/>`)
    }
})

//random password
function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}
$('#password').attr('value',makeid(12))