<?php $this->assign('title', "Xem Phim " . $movie->m_name) ?>
<div class="hero common-hero">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="hero-ct">
                    <h1> <?= $movie->m_name ?></h1>
                    <?php
                    $this->Breadcrumbs->add([
                        [
                            'title' => 'Trang chủ',
                            'url' => ['controller' => 'Pages', 'action' => 'home'],
                            'options' => [
                                'class' => 'active'
                            ]
                        ],
                        [
                            'title' => $movie->m_name,
                            'options' => [
                                'innerAttrs' => [
                                    'class' => "ion-ios-arrow-right"
                                ]
                            ]

                        ]
                    ]);
                    echo $this->Breadcrumbs->render();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- blog detail section-->
<div class="page-single">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">
                <div class="blog-detail-ct">
                    <h1><?= $movie->m_name ?></h1>
                    <!-- <video width="100%" height="400" controls>
                        <source src="https://www.youtube.com/embed/4EYDik5IhAc" type="video/mp4">
                        <source src="" type="video/ogg">
                    </video> -->
                    <iframe id="if_video" type="text/html" width="100%" height="500px" src="<?= !empty($episode->link_film) ? $episode->link_film : '' ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <?php if ($countEpisode != 0) : ?>
                        <?php if ($movie->movies_info->category_id === 3 || $movie->movies_info->category_id === 9) : ?>
                            <div style="color:white;">
                                <span>Tập: </span>
                                <ul style="display:flex; margin-top:5px">
                                    <?php for ($i = 1; $i <= $countEpisode; $i++) : ?>
                                        <li class="episode"><a class="episode-links" href="<?= $this->Url->build(['_name' => 'watch_movie', 'slug' => $movie->m_slug, "episode" => $i]) ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <h1>
                        Nội dung phim
                    </h1>
                    <div style="color: #fff"><?= html_entity_decode($movie->m_desc) ?></div>
                    <!-- share link -->
                    <div class="flex-it share-tag">
                        <div class="social-link">
                            <h4>Share it</h4>
                            <a href="#"><i class="ion-social-facebook"></i></a>
                            <a href="#"><i class="ion-social-twitter"></i></a>
                            <a href="#"><i class="ion-social-googleplus"></i></a>
                            <a href="#"><i class="ion-social-pinterest"></i></a>
                            <a href="#"><i class="ion-social-linkedin"></i></a>
                        </div>
                    </div>
                    <!-- comment items -->
                    <div class="comments">
                        <h4><?= (0 < count($comments->toArray()) && count($comments->toArray()) < 10) ? '0' . count($comments->toArray()) : count($comments->toArray()) ?>
                            Comments</h4>
                        <?php foreach ($comments as $comment) : ?>
                            <div class="cmt-item flex-it">
                                <?= $this->Html->image('upload/users/' . @h($comment->user->img_avatar), ['class' => 'img_avatar']) ?>
                                <div class="author-infor">
                                    <div class="flex-it2">
                                        <h6><a href="#"><?= @h($comment->user->name) ?></a></h6> <span class="time"> -
                                            <?= h($comment->created->format('d/m/Y')) ?></span>
                                        <div class="rateYo" data-rateyo-rating="<?= $comment->rate ?>"></div>
                                    </div>
                                    <p style="width:100%"><?= $comment->content ?></p>
                                    <!-- <p><a class="rep-btn" href="#">+ Reply</a></p> -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="comment-form">
                        <h4>Viết bình luận</h4>
                        <?= $this->Form->create(null, ['onsubmit' => 'return false', 'id' => 'CommentForm']) ?>
                        <input type="hidden" name="id_user" value="<?= $member_info ? $member_info->id : '' ?>">
                        <input type="hidden" name="id_movie" value="<?= $movie ? $movie->id : '' ?>">
                        <input type="hidden" name="rate_movie" value="0">
                        <div id="rateYo"></div>
                        <div class=" row mt-2">
                            <div class="col-md-12">
                                <textarea name="message" id="comment_content" placeholder="Bình luận..."></textarea>
                            </div>
                        </div>
                        <p class="notifications" style="color:white"></p>
                        <?php if ($member_info || !empty($member_info)) : ?>
                            <input class="submit" type="submit" value="Bình luận">
                        <?php else : ?>
                            <a href="#"><input type="button" class="submit loginLink" value="Đăng nhập để bình luận"></a>
                        <?php endif; ?>
                        <?= $this->Form->end() ?>
                    </div>
                    <!-- comment form -->
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="sidebar">
                    <div class="sb-recentpost sb-it">
                        <h4 class="sb-title">Phim theo danh mục</h4>
                        <?php foreach ($category_movies as $key => $value) : ?>
                            <?php if ($value->id != $movie->id && $key < 4) : ?>
                                <div class="recent-item">
                                    <?php echo $this->Html->image(!empty($value->thumb) ? $url_s3 . "uploads/thumbs/" . $value->thumb : 'default/mv-item1.jpg', ['style' => 'width:80px;height:122px']); ?>
                                    <h6 style="margin-left: 15px;"><a href="<?php echo $this->Url->build(["_name" => "movies_details", "slug" => $value->m_slug, "id" => $value->id]); ?>"><?= $value->m_name ?></a>
                                    </h6>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="sb-recentpost sb-it">
                        <h4 class="sb-title">Phim theo thể loại</h4>
                        <?php foreach ($genre_movies as $key => $value) : ?>
                            <?php if ($value->id != $movie->id && $key < 4) : ?>
                                <div class="recent-item">
                                    <?php echo $this->Html->image(!empty($value->thumb) ? $url_s3 . "uploads/thumbs/" . $value->thumb : 'default/mv-item1.jpg', ['style' => 'width:80px;height:122px']); ?>
                                    <h6 style="margin-left: 15px;"><a href="<?php echo $this->Url->build(["_name" => "movies_details", "slug" => $value->m_slug, "id" => $value->id]); ?>"><?= $value->m_name ?></a>
                                    </h6>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="sb-tags sb-it">
                        <h4 class="sb-title">tags</h4>
                        <ul class="tag-items">
                            <?php if ($movie->movies_info->tags) : ?>
                                <?php $hash_tag = array();
                                $tags = explode(', ', @h($movie->movies_info->tags)); ?>
                                <?php foreach ($tags as $tag) : ?>
                                    <li><a href="/search?tag=<?= html_entity_decode($tag) ?>"><?= html_entity_decode($tag) ?></a></li>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <?php echo ""; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="ads">
                        <img src="images/uploads/ads1.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of  blog detail section-->
<script>
    $("#rateYo").rateYo({
        rating: 0,
        fullStar: true
    });
    $(".rateYo").rateYo({
        fullStar: true,
        readOnly: true,
        starWidth: "15px"
    });
</script>
<script>
    $("#rateYo").rateYo().on('rateyo.change', function(e, data) {
        var rating = data.rating;
        $(this).parent().find('input[name=rate_movie]').val(rating)
    });
</script>
<?= $this->Html->script(['client/movies']) ?>