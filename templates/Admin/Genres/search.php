<?php $this->assign('title', 'Tìm kiếm: '.$this->request->getQuery('query'));?>
<div class="col-md-9 col-lg-10 main mt-3">
   <div class="row mb-3">
      <div class="col-lg-12 col-md-12">
        <h2 class="sub-header mb-3" style="display:flex">Tìm kiếm: <strong> <?= $this->request->getQuery('query')?></strong></h2>
        <div class="box-tools" style=" width:100%; display:flex; justify-content: center">
            <form action="<?php echo $this->Url->build(['_name'=>'admin_genre_search'])?>" method="get">
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
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Danh sách hiển thị
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a href="<?= $this->Url->build(array('_name'=>'admin_genre_home'))?>" class="dropdown-item <?= count($genres) == 10 ? 'active': ''?>">10</a>
                    <a href="?limit=25" class="dropdown-item <?= count($genres) == 25 ? 'active': ''?>">25</a>
                    <a href="?limit=50" class="dropdown-item <?= count($genres) == 50 ? 'active': ''?>">50</a>
                    <a href="?limit=100" class="dropdown-item <?= count($genres) == 100 ? 'active': ''?>">100</a>
                </div>
            </div>
            <div class="pull-right mb-2">
                <a href="<?= $this->Url->build(array('_name'=>'admin_genre_create'))?>" class="btn btn-sm btn-outline-primary w-10 btn-add"><i class="fa-solid fa-plus"></i></a>
                <a class="btn btn-sm btn-outline-primary w-10 btn-down"><i class="fa-solid fa-download"></i></a>
            </div>
       </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Tên tiêu đề</th>
                        <th>Tên không dấu</th>
                        <th>Mô tả</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Ngày sửa</th>
                        <th>Khác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($genres as $genre):?>
                    <tr>
                        <td><?= $genre->id ?></td>
                        <td><?= $genre->title?></td>
                        <td>
                            <?= $genre->slug?>
                        </td>
                        <td><?php echo html_entity_decode($genre->description)?></td>
                        <td><?= $genre->status == 0 ? "Ẩn": "Hiện" ?></td>
                        <td><?= $genre->created->format('Y-m-d')?></td>
                        <td><?= $genre->modified->format('Y-m-d')?></td>
                        <td class="td-center">
                            <a href=<?= $this->URL->build(array("_name"=>'admin_genre_edit','slug' => $genre->slug))?> class="btn btn-warning" id="edit-btn">Sửa</a>
                            <?= $this->Form->postLink(__('Xóa'),
                                ['_name'=>'admin_genre_delete', 'id'=> $genre->id],
                                [
                                    'confirm'=>__('Bạn có chắc muốn xóa tiêu đề "{0}" không?',$genre->title),
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
<?php echo $this->Html->script(['admin/genre','sweetalert2'])?>