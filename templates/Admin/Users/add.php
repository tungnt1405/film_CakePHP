<div class="col-md-9 col-lg-10 main mt-3">
    <div class="row mb-3">
        <div class="col-md-6 col-lg-6">
            <h2 class="sub-header">Thêm người dùng</h2>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="pull-right">
            <?= $this->Form->button('Thêm',['class'=>'btn btn-md btn-outline-success', 'style'=>'cursor: pointer','form'=>'frmAdd'])?>
            <?= $this->Html->link('Hủy bỏ',array('_name'=>'admin_user_index'),array('class'=>'btn btn-md btn-outline-primary'))?>
            </div>
        </div>
        <hr class="w-95">
        <?= $this->Form->create($user,['id'=>'frmAdd','type'=>'file'])?>
            <div class="row ml-3 mr-3">
                <div class="form-group col-md-6">
                    <!-- <label for="name">Tên khách hàng</label> -->
                    <!-- <input type="text" name="name" id="name" class="form-control" autofocus> -->
                    <?= $this->Form->control('name', array(
                        'label' => 'Tên khách hàng',
                        'id' => 'name',
                        'class' => 'form-control',
                        'autofocus',
                        'required' => false
                    ))?>
                </div>
                <div class="form-group col-md-6">
                    <!-- <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control"> -->
                    <?= $this->Form->control('email', array(
                        'label' => 'Email',
                        'id' => 'email',
                        'class' => 'form-control',
                        'required' => false
                    ))?>
                </div>
                <div class="form-group col-md-6">
                    <!-- <label for="password">Password</label>
                    <input type="text" name="password" id="password" class="form-control"> -->
                    <?= $this->Form->control('password', array(
                        'type' => 'text',
                        'label' => 'Password',
                        'id' => 'password',
                        'class' => 'form-control',
                        'required' => false
                    ))?>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <!-- <label for="role">Phân quyền</label>
                        <select name="role" id="role" class="form-control form-select" aria-label="Chọn quyền">
                            <option>-------------- Phân quyền cho người dùng --------------</option>
                            <option value="admin">Admin</option>
                            <option value="member">Member</option>
                        </select> -->

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
                    <div class="form-group files">
                        <!-- <label for="file">Chọn avatar </label>  -->
                        <?php echo $this->Form->label('Chọn avatar'); ?>
                        <?php echo $this->Form->file('img_avatar', ['class'=>'form-control', 'id'=>"file", 'required' => false]); ?>
                        <!-- <input id="file" name="img_avatar" type="file" class="form-control" /> -->
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
<?php echo $this->Html->script(['admin/users','sweetalert2'])?>
