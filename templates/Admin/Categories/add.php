<?php $this->assign('title', 'Thêm sản phẩm');?>
<div class="col-md-9 col-lg-10 main mt-3">
    <div class="row mb-3">
        <div class="col-md-6 col-lg-6">
            <h2 class="sub-header">Thêm danh mục</h2>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="pull-right">
            <?= $this->Form->button('Thêm',['class'=>'btn btn-md btn-outline-success', 'style'=>'cursor: pointer','form'=>'frmAdd'])?>
            <?= $this->Html->link('Hủy bỏ',array('_name'=>'admin_categories_index'),array('class'=>'btn btn-md btn-outline-primary'))?>
            </div>
        </div>
        <hr class="w-95">
        <?= $this->Form->create($category,['id'=>'frmAdd'])?>
            <div class="row ml-3 mr-3">
                <div class="form-group col-md-6">
                    <?= $this->Form->control('title', array(
                        'label' => 'Tên danh mục',
                        'id' => 'title',
                        'class' => 'form-control',
                        'autofocus',
                        'onkeyup' => 'ChangeToSlug()',
                        'required' => false
                    ))?>
                </div>
                <div class="form-group col-md-6">
                    <?= $this->Form->control('slug', array(
                        'label' => 'Tên không dấu',
                        'id' => 'slug',
                        'class' => 'form-control',
                        'required' => false
                    ))?>
                </div>
                <div class="form-group col-md-12">
                    <?= $this->Form->control('description', array(
                        'label' => 'Mô tả',
                        'id' => 'description',
                        'class' => 'form-control',
                        'required' => false
                    ))?>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $this->Form->control('status', array(
                            'label' => 'Trạng thái',
                            'id' => 'status',
                            'class' => 'form-control form-select',
                            'options' => [
                                '0'=> 'Ẩn',
                                '1'=>'Hiện'
                            ],
                            'empty'=>'--------- Trạng thái hiển thị ---------',
                            'required' => false
                        ))?>
                    </div>
                </div>
            </div>
        <?= $this->Form->end()?>
    </div>
</div>
<?php $flash = $this->Flash->render();
    if($flash):
?>
    <script>
        $(document).ready(function(){
            Swal.fire({
                icon: `success`,
                title: `Thêm dữ liệu thành công`,
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
                title: `Vui lòng thử lại. Thêm không thành công!`,
                timer: 5000
            })
        })
    </script>
<?php endif;?> 
<script>
  $(function () {
    CKEDITOR.replace('description')
  })
</script>
<?php echo $this->Html->script(['admin/category','sweetalert2'])?>
