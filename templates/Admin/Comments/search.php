<?php $this->assign('title','Tìm kiếm: '.$this->request->getQuery('query'))?>
<div class="col-md-9 col-lg-10 main mt-3">
    <div class="row mb-3">
        <div class="col-lg-12 col-md-12">
            <h2 class="sub-header mb-3" style="display:flex">Tìm kiếm: <strong> <?= $this->request->getQuery('query')?></strong></h2>
            <div class="box-tools" style=" width:100%; display:flex; justify-content: center">
                <form action="<?php echo $this->Url->build(['_name'=>'admin_comment_search'])?>" method="get">
                    <div class="input-search input-group" style="width: 50vw;">
                        <input type="text" name="query" class="form-control pull-right" id="query" value="<?=$this->request->getQuery('query')?>" >
                        <div class="button-search input-group-btn">
                            <button type="submit" class="btn btn-primary search-icon" style="
                                border-top-right-radius: 7px 7px;
                                border-bottom-right-radius: 7px 7px;
                            "><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        <div>
        <div class="dropdown pull-left mb-2">
            <?= $this->Html->link('Trở về',array('_name'=>'admin_comment_home'),array('class'=>'btn btn-md btn-warning'))?>
            </div>
       </div>
        <div class="table-responsive" id="movie_scroll" style="margin-bottom: 5px;">
            <table class="table table-striped table-bordered" id="movie_table">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Phim</th>
                        <th>Người bình luận</th>
                        <th>Nội dung</th>
                        <th>Khác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($comments as $comment):?>
                        <tr>
                            <td><?php echo $comment->id?></td>
                            <td><?php echo @h($comment->movie->m_name)?></td>
                            <td><?php echo @h($comment->user->name)?></td>
                            <td><?php echo $comment->content?></td>
                            <td>
                                <?= $this->Form->postLink(__('Xóa'),
                                        ['_name'=>'admin_comment_delete', 'id'=>$comment->id],
                                        [
                                            'confirm'=>__('Bạn có chắc muốn xóa bình luận này không không?'),
                                            'class' => 'btn btn-danger',
                                        ]
                                )?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <ul class="pagination">
            <?php
                echo $this->Paginator->first();
                if($this->Paginator->hasPrev()){
                    echo $this->Paginator->prev();
                }
                echo $this->Paginator->numbers();
                if(!empty($this->Paginator->next())){
                    echo $this->Paginator->next();
                }
                echo $this->Paginator->last();
                ?>
        </ul>
      </div>
   </div>
</div>

<?php $flash = $this->Flash->render();
    if($flash):
?>
    <script>
        $(document).ready(function(){
            Swal.fire({
                icon: `success`,
                title: `Xóa thành công`,
                timer: 5000
            })
        })
    </script>
<?php endif;?>  
<?php if(isset($error)):?>
    <script>
        $(document).ready(function(){
            Swal.fire({
                icon: `error`,
                title: `Vui lòng thử lại. Xóa không thành công!`,
                timer: 5000
            })
        })
    </script>
<?php endif;?> 
<?php echo $this->Html->script(['sweetalert2'])?>