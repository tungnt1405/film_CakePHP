$(function(){
    // let placeholder = getPlaceHolerSearch();
    // $('input[name=tag_key]#tags').attr('placeholder', placeholder);

    // $('#search-menu').on('change keyup blur', function() {
    //     let select = $(this).val();

    //     var placeholder = getPlaceHolerSearch(select);
    //     $('input[name=tag_key]#tags').attr('placeholder', placeholder);
    // });
    
    $('input[name=tag_key]#tags').on('change keyup blur', function(){
        let key_tag = $(this).val();
        if(key_tag === undefined || key_tag.trim() === ''){
            $('.btn-search--movie').attr("disabled", "disabled");
            $('.btn-search--movie .search-icon').removeClass('hidden');
            $('.btn-search--movie .loading-icon').addClass('hidden');
        }else{
            $('.btn-search--movie').removeAttr("disabled")
        }


        $("#tags").autocomplete({
            source: function(request, response){
                $.ajax({
                    url: `/ajaxListMovies?query=${$('input[name=tag_key]#tags').val()}`,
                    type:'get',
                    dataType: 'json',
                    beforeSend: function(){
                        $('.btn-search--movie .search-icon').addClass('hidden');
                        $('.btn-search--movie .loading-icon').removeClass('hidden');
                    },
                    success: function(data){
                        setTimeout(function(){
                            $('.btn-search--movie .search-icon').removeClass('hidden');
                            $('.btn-search--movie .loading-icon').addClass('hidden');
                        },500)
                        response(data.array_data)
                    }
                });
            },
            delay: 500,
            minLength: 1,
            // select: function(event, response){
            //     $('#search_data').val(response.item.value);
            // }
            select: function(event, ui) {   
                location.href= location.origin+'/search?tag_key='+ui.item.value
            }
        }).focus(function() {
            $(this).autocomplete("search", "");
        });
        // .data("ui-autocomplete")._renderItem = function (ul, item) {
        //     return $("<li class='ui-autocomplete-row'></li>")
        //         .data("item.autocomplete", item)
        //         .append(item.label)
        //         .appendTo(ul)
        // };
    });

    $('#payment-movies').click(function(e){
        // e.preventDefault();
        $.ajax({
            url: $(this).attr('data-url'),
            type: 'post',
            data:{
                _csrfToken: $('meta[name="csrfToken"]').attr('content'),
                id: $(this).attr("data-value")
            },
            // beforeSend: function() {
            //     alert('truoc khi send')
            // },
            success: function(data) {
                window.location.href= data
            },
        })
    })

    $('#formPaymentInfo button').click(function(e){
        e.preventDefault();
        $.ajax({
            url: '/pay_info',
            type: 'get',
            beforeSend: function() {
                $('#formPaymentInfo').prepend('<div id="overload"><div class="loader"></div></div>');
            },
            success: function(data) {
                window.location.href= data
            },
        })
    })

    //check number phone
    jQuery.validator.addMethod("phone_number", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || phone_number.length > 9 && 
        phone_number.match(/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/);
    }, "Số điện thoại không đúng định dạng");

    $('#formPaymentConfirm').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            'payment-name' : {
                required : true,
            },
            'payment-email' : {
                required : true,
                email: true
            },
            'payment-phone': {
                required: true,
                phone_number: true
            },
            'payment-pay':{
                required: true
            }
        },
        messages: {
            'payment-name' : {
                required : 'Vui lòng nhập tên người mua',
            },
            'payment-email' : {
                required : 'Không bỏ trống địa chỉ email',
                email: 'Địa chỉ email không đúng định dạng'
            },
            'payment-phone': {
                required: 'Không để trống số điện thoại'
            },
            'payment-pay':{
                required: function(){
                    $('.payment-pay-error').css('display','block')
                }
            }
        },
        submitHandler: function (form) {
            // form.submit();
            $('.payment-pay-error').css('display','none');
            let payment_note = $('#payment-note').val() === '' ? $('input[name="desc"]').val() : $('#payment-note').val();
            $.ajax({
                url: '/pay_movie',
                type: 'post',
                beforeSend: function() {
                    $('#formPaymentConfirm').prepend('<div id="overload"><div class="loader"></div></div>');
                },
                data:{
                    _csrfToken: $("meta[name=csrfToken]").attr('content'),
                    'payment-amount': $('[name="payment-amount"]').val(),
                    'payment-note': payment_note,
                    'payment-pay': $('[name="payment-pay"]').val()
                },
                success: function(data) {
                    window.location.href= data;
                },
            })
            
        },
    });

    
});