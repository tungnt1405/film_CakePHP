<?php $this->assign('title', 'Thêm quốc gia');?>
<div class="col-md-9 col-lg-10 main mt-3">
    <div class="row mb-3">
        <div class="col-md-6 col-lg-6">
            <h2 class="sub-header">Thêm danh mục</h2>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="pull-right">
            <?= $this->Form->button('Thêm',['class'=>'btn btn-md btn-outline-success', 'style'=>'cursor: pointer','form'=>'frmAdd'])?>
            <?= $this->Html->link('Hủy bỏ',array('_name'=>'admin_movies_home'),array('class'=>'btn btn-md btn-outline-primary'))?>
            </div>
        </div>
        <hr class="w-95">
        <?= $this->Form->create($movie,['id'=>'frmAdd','type'=>'file'])?>
            <div class="row ml-3 mr-3">
            <div class="form-group col-md-6">
                    <?= $this->Form->control('m_name', array(
                        'label' => 'Tên phim',
                        'id' => 'title',
                        'class' => 'form-control',
                        'autofocus',
                        'onkeyup' => 'ChangeToSlug()',
                        'required' => false
                    ))?>
                </div>
                <div class="form-group col-md-6">
                    <?= $this->Form->control('m_slug', array(
                        'label' => 'Tên không dấu',
                        'id' => 'slug',
                        'class' => 'form-control',
                        'required' => false
                    ))?>
                </div>                
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $this->Form->control('movies_info.country_id', array(
                            'label' => 'Quốc gia',
                            'id' => 'country_id',
                            'class' => 'form-control form-select',
                            'options' => $listCountry,
                            'empty'=>'--------- Quốc Gia ---------',
                            'required' => false
                        ))?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $this->Form->control('movies_info.category_id', array(
                            'label' => 'Chủ đề',
                            'id' => 'category_id',
                            'class' => 'form-control form-select',
                            'options' => $listCategories,
                            'empty'=>'--------- Chủ đề ---------',
                            'required' => false
                        ))?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $this->Form->control('movies_info.genre_id', array(
                            'label' => 'Thể loại',
                            'id' => 'genre_id',
                            'class' => 'form-control form-select',
                            'options' => $listGenres,
                            'empty'=>'--------- Thể loại ---------',
                            'required' => false
                        ))?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $this->Form->control('movies_info.resolution', array(
                            'label' => 'Chất lượng',
                            'id' => 'resolution',
                            'class' => 'form-control form-select',
                            'options' => [
                                'SD'=> 'SD',
                                'HD'=> 'HD'
                            ],
                            'required' => false
                        ))?>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <?= $this->Form->control('m_desc', array(
                        'label' => 'Mô tả',
                        'id' => 'description',
                        'class' => 'form-control',
                        'required' => false
                    ))?>
                </div>
                <div class="form-group col-md-6">
                    <?= $this->Form->control('movies_info.session', array(
                        'label' => 'Thời lượng',
                        'type' => 'number',
                        'id' => 'session',
                        'class' => 'form-control',
                        'required' => false
                    ))?>
                </div>    
                <div class="form-group col-md-6">
                    <?= $this->Form->control('movies_info.sesson', array(
                        'label' => 'Phần phim',
                        'type' => 'number',
                        'id' => 'sesson',
                        'class' => 'form-control',
                        'required' => false
                    ))?>
                </div>    
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $this->Form->control('movies_info.subtitle', array(
                            'label' => 'Phụ đề',
                            'id' => 'subtitle',
                            'class' => 'form-control form-select',
                            'options' => [
                                'vi' => 'VietSub',
                                'en' => 'EngSub',
                                'tm' => 'Thuyết minh'
                            ],
                            'required' => false
                        ))?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $this->Form->control('movies_info.year', array(
                            'label' => 'Năm sản xuất',
                            'id' => 'year',
                            'class' => 'form-control form-select',
                            'options' => [
                                '2022' => 2022,
                                '2021' => 2021,
                                '2020' => 2020,
                            ],
                            'required' => false
                            ))?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $this->Form->control('movies_info.topview', array(
                            'label' => 'Thứ hạng',
                            'id' => 'year',
                            'class' => 'form-control form-select',
                            'options' => [
                                'ngay'=> 'Ngày',
                                'thang' => 'Tháng',
                                'nam' => 'Năm'
                            ],
                            'required' => false
                        ))?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $this->Form->control('movies_info.total_episode', array(
                            'label' => 'Tổng số tập',
                            'id' => 'episode_toal',
                            'class' => 'form-control',
                            'required' => false
                        ))?>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <?= $this->Form->control('movies_info.tags', array(
                        'label' => 'Tags',
                        'id' => 'tag',
                        'class' => 'form-control',
                        'required' => false
                    ))?>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $this->Form->control('movies_info.m_status', array(
                            'label' => 'Trạng thái',
                            'id' => 'm_status',
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
                <div class="col-md-12">
                    <div class="form-group files">
                        <!-- <label for="file">Chọn avatar </label>  -->
                        <?php echo $this->Form->label('Thumbnail'); ?>
                        <?php echo $this->Form->file('thumb_nail', ['class'=>'form-control', 'id'=>"file", 'required' => false]); ?>
                        <!-- <input id="file" name="img_avatar" type="file" class="form-control" /> -->
                    </div>
                </div>
                <div class="box-pre-thumb hidden ml-3"></div>
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
    CKEDITOR.replace('m_desc');
    // CKEDITOR.replace('tag');
  })
</script>
<?php echo $this->Html->script(['admin/movie','sweetalert2'])?>
