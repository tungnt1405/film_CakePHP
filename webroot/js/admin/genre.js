$().ready(function(){
    //check validator
    $('#frmAdd').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        ignore: [],
        rules: {
            title : {
                required : true,
                maxlength: 255
            },
            slug : {
                required : true,
                maxlength: 500
            },
            "description" : {
                required : function(mydata) {
                    CKEDITOR.instances[mydata.id].updateElement();
                    var memberdatacontent = mydata.value.replace(/<[^>]*>/gi, '');
                    return memberdatacontent.length === 0;
                },
            },
            status: {
                required: true
            },
        },
        messages: {
            title: {
                required: "Tên thể loại không được để trống",
                maxlength: "Nhập tối đa 255 ký tự"
            },
            slug : {
                required: "Tên không dấu không được để trống",
                maxlength: "Tên không dấu tối đa 500 ký tự"
            },
            'description' : {
                required: "Vui lòng nhập mô tả cho thể loại",
            },
            status : {
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
            title : {
                required : true,
                maxlength: 255
            },
            slug : {
                required : true,
                maxlength: 500
            },
            "description" : {
                required : function(mydata) {
                    CKEDITOR.instances[mydata.id].updateElement();
                    var memberdatacontent = mydata.value.replace(/<[^>]*>/gi, '');
                    return memberdatacontent.length === 0;
                },
            },
            status: {
                required: true
            },
        },
        messages: {
            title: {
                required: "Tên thể loại không được để trống",
                maxlength: "Nhập tối đa 255 ký tự"
            },
            slug : {
                required: "Tên không dấu không được để trống",
                maxlength: "Tên không dấu tối đa 500 ký tự"
            },
            'description' : {
                required: "Vui lòng nhập mô tả cho thể loại",
            },
            status : {
                required: "Hãy chọn trạng thái hiển thị",
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
});