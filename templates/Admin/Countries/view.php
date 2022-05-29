<?php $this->assign('title', 'Tìm kiếm: '.$this->request->getQuery('query'));?>
<div class="col-md-9 col-lg-10 main mt-3">
   <div class="row mb-3">
      <div class="col-lg-12 col-md-12">
        <h2 class="sub-header mb-3" style="display:flex">Tìm kiếm: <strong> <?= $this->request->getQuery('query')?></strong></h2>
        <div class="box-tools" style=" width:100%; display:flex; justify-content: center">
            <form action="<?php echo $this->Url->build(['_name'=>'admin_countries_search'])?>" method="get">
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
            <div class="pull-right mb-2">
                <a href="<?= $this->Url->build(array('_name'=>'admin_categories_add'))?>" class="btn btn-sm btn-outline-primary w-10 btn-add"><i class="fa-solid fa-plus"></i></a>
                <a class="btn btn-sm btn-outline-primary w-10 btn-down"><i class="fa-solid fa-download"></i></a>
            </div>
       </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Tên quốc gia</th>
                        <th>Tên không dấu</th>
                        <th>Mô tả</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Ngày sửa</th>
                        <th>Khác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($countries as $country):?>
                    <tr>
                        <td><?= $country->id ?></td>
                        <td><?= $country->country_name?></td>
                        <td>
                            <?= $country->country_slug?>
                        </td>
                        <td><?php echo html_entity_decode($country->country_description)?></td>
                        <td><?= $country->country_status == 0 ? "Ẩn": "Hiện" ?></td>
                        <td><?= $country->created->format('Y-m-d')?></td>
                        <td><?= $country->modified->format('Y-m-d')?></td>
                        <td class="td-center">
                            <?= $this->Html->link(__('Sửa'),["_name"=>'admin_countries_edit','slug' => $country->country_slug],['class'=>"btn btn-warning","id"=>"edit-btn"])?>
                            <?= $this->Form->postLink(__('Xóa'),
                                ['_name'=>'admin_countries_delete', 'id'=>$country->id],
                                [
                                    'confirm'=>__('Bạn có chắc muốn xóa danh mục "{0}" không?',$country->country_name),
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
<?php echo $this->Html->script(['admin/country','sweetalert2'])?>