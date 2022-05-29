<div class="col-md-9 col-lg-10 main mt-3">
   <div class="row mb-3">
      <div class="col-lg-12 col-md-12">
        <a href="javascript:history.back(0)" class="btn btn-info pull-right">Trở lại</a>
        <h2 class="sub-header mb-3" style="display:flex">Tìm kiếm: "<?= $this->request->getQuery('query') ?>"</h2>
        <div class="box-tools" style=" width:100%; display:flex; justify-content: center">
            <form action="<?php echo $this->Url->build(['action'=>'search'],['id'=>'frmSearch'])?>" method="get">
                <div class="input-search input-group" style="width: 50vw;">
                    <input type="text" name="query" class="form-control pull-right" id="query" placeholder="Nhập nội dung tìm kiếm" 
                    value="<?= !empty($this->request->getQuery('query')) ? $this->request->getQuery('query') : ''?>">
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
        <?php if($users->isEmpty()):?>
            <h3>
                <p class="text-center mt-5" style="color: #939191">----- Không có kết quả nào trả về -----</p>
            </h3>
        <?php else:?>
            <div class="table-responsive mt-2">
                <table class="table table-striped table-bordered">
                    <thead class="thead-inverse">
                        <tr>
                            <th>#</th>
                            <th>Ảnh đại diện</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Quyền</th>
                            <th>Active</th>
                            <th>Khác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user):?>
                        <tr>
                            <td><?=$user->id?></td>
                            <td class="td-center">
                                <?=$this->Html->image('upload/users/'.$user->img_avatar,['class'=>'user_avatar'])?>
                            </td>
                            <td class="td-center"><?=$user->name?></td>
                            <td><?=$user->email?></td>
                            <td class="td-center"><?=$user->role?></td>
                            <td class="td-center"><?=$user->active?></td>
                            <td class="td-center">
                                <a href=<?= $this->URL->build(array('controller'=>'Users','action' => 'edit','id' => $user->id))?> class="btn btn-warning" id="edit-btn">Sửa</a>
                                <?= $this->Form->postLink(__('Xóa'),
                                    ['_name'=>'admin_users_delete', 'id'=>$user->id],
                                    [
                                        'confirm'=>__('Bạn có chắc muốn xóa người dùng có tên "{0}" không?',$user->name),
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
        <?php endif;?>
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
<?php echo $this->Html->script(['admin/users','sweetalert2'])?>