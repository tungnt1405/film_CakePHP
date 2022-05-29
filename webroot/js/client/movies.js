$('#CommentForm input[type=submit]').on('click', function(e){
    e.preventDefault();
    id_user = $('input[name=id_user]').val();
    id_movie = $('input[name=id_movie]').val();
    _csrfToken = $('input[name=_csrfToken]').val();
    rate_movie = $('input[name=rate_movie]').val();
    comment_content = $('#comment_content').val();
    if(comment_content == undefined || comment_content.trim() == ''){
        alert('Vui lòng nhập nội dung bình luận trước khi nhấn submit');
    }else{
        $.ajax({
            url: '/comment/write',
            type: 'post',
            dataType: 'json',
            data: {
                _csrfToken: _csrfToken,
                user_id: id_user,
                movie_id: id_movie,
                rate_movie: rate_movie,
                comment: comment_content
            },
            success: function(data){
                $('#comment_content').val('');
                $('.notifications').html(data);
                $('.notifications').fadeOut(3000);

                setTimeout(function(){
                    window.location.reload();
                },4000)
            },
        });
    }
})