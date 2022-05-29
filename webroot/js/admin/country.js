$().ready(function(){
    //check validator
    $('#frmAdd').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        ignore: [],
        rules: {
            country_name : {
                required : true,
                maxlength: 255
            },
            country_slug : {
                required : true,
                maxlength: 500
            },
            "country_description" : {
                required : function(mydata) {
                    CKEDITOR.instances[mydata.id].updateElement();
                    var memberdatacontent = mydata.value.replace(/<[^>]*>/gi, '');
                    return memberdatacontent.length === 0;
                },
            },
            country_status: {
                required: true
            },
        },
        messages: {
            country_name: {
                required: "Tên danh mục không được để trống",
                maxlength: "Nhập tối đa 255 ký tự"
            },
            country_slug : {
                required: "Tên không dấu không được để trống",
                maxlength: "Tên không dấu tối đa 500 ký tự"
            },
            'country_description' : {
                required: "Vui lòng nhập mô tả cho danh mục",
            },
            country_status : {
                required: "Hãy chọn trạng thái hiển thị",
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });


    $('#frmEdit').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        ignore: [],
        rules: {
            country_name : {
                required : true,
                maxlength: 255
            },
            country_slug : {
                required : true,
                maxlength: 500
            },
            "country_description" : {
                required : function(mydata) {
                    CKEDITOR.instances[mydata.id].updateElement();
                    var memberdatacontent = mydata.value.replace(/<[^>]*>/gi, '');
                    return memberdatacontent.length === 0;
                },
            },
            country_status: {
                required: true
            },
        },
        messages: {
            country_name: {
                required: "Tên danh mục không được để trống",
                maxlength: "Nhập tối đa 255 ký tự"
            },
            country_slug : {
                required: "Tên không dấu không được để trống",
                maxlength: "Tên không dấu tối đa 500 ký tự"
            },
            'country_description' : {
                required: "Vui lòng nhập mô tả cho danh mục",
            },
            country_status : {
                required: "Hãy chọn trạng thái hiển thị",
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
});