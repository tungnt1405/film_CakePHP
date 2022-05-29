<div class="col-md-9 col-lg-10 main mt-3">
    <div class="row mb-3">
        <div class="col-md-6 col-lg-6">
            <h2 class="sub-header">Thông tin cá nhân</h2>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="pull-right">
            <?= $this->Form->button('Cập nhật',['class'=>'btn btn-md btn-outline-success', 'style'=>'cursor: pointer','form'=>'frmEdit'])?>
            <?= $this->Html->link('Hủy bỏ',array('_name'=>'admin_user_index'),array('class'=>'btn btn-md btn-outline-primary'))?>
            </div>
        </div>
        <hr class="w-95">
        <?= $this->Form->create($user,['id'=>'frmEdit','type'=>'file'])?>
            <div class="row ml-3 mr-3">
                <div class="form-group col-md-6">
                    <?= $this->Form->control('name', array(
                        'label' => 'Tên khách hàng',
                        'id' => 'name',
                        'class' => 'form-control',
                        'autofocus',
                        'required' => false
                    ))?>
                </div>
                <div class="form-group col-md-6">
                    <?= $this->Form->control('email', array(
                        'label' => 'Email',
                        'id' => 'email',
                        'class' => 'form-control',
                        'required' => false
                    ))?>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $this->Form->control('role', array(
                            'label' => 'Phân quyền',
                            'id' => 'role',
                            'class' => 'form-control form-select',
                            'options' => [
                                'admin'=> 'Admin',
                                'member'=>'Member'
                            ],
                            'empty'=>'--------- Phân quyền cho người dùng ---------',
                            'required' => false
                        ))?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <?php echo $this->Form->label('Avatar hiện tại:'); ?>
                        <?=$this->Html->image('upload/users/'.$user->img_avatar,['class'=>'user_avatar'])?>
                    </div>
                    <div class="form-group files">                        
                        <?php echo $this->Form->label('Chọn avatar'); ?>
                        <?php echo $this->Form->file('img_avatar', ['class'=>'form-control', 'id'=>"file", 'required' => false]); ?>
                    </div>
                </div>
                <div class="box-pre-img hidden ml-3"></div>
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
                title: `Cập nhật thông tin thành công`,
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
                title: `Vui lòng thử lại. Cập nhật không thành công!`,
                timer: 5000
            })
        })
    </script>
<?php endif;?> 
<?php echo $this->Html->script(['admin/users','sweetalert2'])?>
