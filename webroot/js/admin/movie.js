$().ready(function(){
    //check validator
    $('#frmAdd').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        ignore: [],
        rules: {
            m_name : {
                required : true,
                maxlength: 255
            },
            m_slug : {
                required : true,
                maxlength: 500
            },
            "m_desc" : {
                required : function(mydata) {
                    CKEDITOR.instances[mydata.id].updateElement();
                    var memberdatacontent = mydata.value.replace(/<[^>]*>/gi, '');
                    return memberdatacontent.length === 0;
                },
            },
            "movies_info[country_id]":{
                required: true
            },
            "movies_info[category_id]":{
                required: true
            },
            "movies_info[genre_id]": {
                required: true
            },
            "movies_info[m_status]": {
                required: true
            },
        },
        messages: {
            m_name: {
                required: "Tên danh mục không được để trống",
                maxlength: "Nhập tối đa 255 ký tự"
            },
            m_slug : {
                required: "Tên không dấu không được để trống",
                maxlength: "Tên không dấu tối đa 500 ký tự"
            },
            'm_desc' : {
                required: "Vui lòng nhập mô tả cho danh mục",
            },
            "movies_info[country_id]":{
                required: "Hãy chọn quốc gia sản xuất cho phim"
            },
            "movies_info[category_id]":{
                required: "Hãy chọn danh mục cho phim"
            },
            "movies_info[genre_id]": {
                required: "Hãy chọn thể loại cho phim"
            },
            "movies_info[m_status]" : {
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
            m_name : {
                required : true,
                maxlength: 255
            },
            m_slug : {
                required : true,
                maxlength: 500
            },
            "m_desc" : {
                required : function(mydata) {
                    CKEDITOR.instances[mydata.id].updateElement();
                    var memberdatacontent = mydata.value.replace(/<[^>]*>/gi, '');
                    return memberdatacontent.length === 0;
                },
            },
            "movies_info[country_id]":{
                required: true
            },
            "movies_info[category_id]":{
                required: true
            },
            "movies_info[genre_id]": {
                required: true
            },
            "movies_info[m_status]": {
                required: true
            },
        },
        messages: {
            m_name: {
                required: "Tên danh mục không được để trống",
                maxlength: "Nhập tối đa 255 ký tự"
            },
            m_slug : {
                required: "Tên không dấu không được để trống",
                maxlength: "Tên không dấu tối đa 500 ký tự"
            },
            'm_desc' : {
                required: "Vui lòng nhập mô tả cho danh mục",
            },
            "movies_info[country_id]":{
                required: "Hãy chọn quốc gia sản xuất cho phim"
            },
            "movies_info[category_id]":{
                required: "Hãy chọn danh mục cho phim"
            },
            "movies_info[genre_id]": {
                required: "Hãy chọn thể loại cho phim"
            },
            "movies_info[m_status]" : {
                required: "Hãy chọn trạng thái hiển thị",
            },
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
});
$(".files").attr('data-before', "Kéo thả ảnh tại đây hoặc chọn ảnh bỏ vào");
$('input[type="file"]').change(function (e) {
    var fileName = e.target.files[0].name;
    $(".files").attr('data-before', fileName);

});

$('#file').change(function () {
    var fileImg = $('input#file').val();
    if (fileImg != '') {        
        $('.box-pre-thumb').removeClass('hidden');
        $('.box-pre-thumb').addClass('form-group');
        $('.box-pre-thumb').html(`<p><strong>Ảnh xem trước</strong></p>`)
        $('.box-pre-thumb').append(`<img src="${URL.createObjectURL(event.target.files[0])}" width="98" height="150"/>`)
    }
})