<div class="col-md-3 col-lg-2 sidebar-offcanvas pt-3" id="sidebar" role="navigation">
   <ul class="nav flex-column pl-1" style="height: 100vh">
      <li class="nav-item"><a class="nav-link <?= $this->request->getParam('controller') == 'Dashboard' ? 'active' : ''?>" href="<?php echo $this->Url->build(['_name'=>'admin_dashboard'])?>"><i class="fa-solid fa-gauge-high" id="dashboard"></i> Bảng điều khiển</a></li>
      <li class="nav-item"><a class="nav-link <?= $this->request->getParam('controller') == 'Categories'? 'active' : ''?>" href="<?= $this->Url->build(['_name'=>'admin_categories_index']) ?>"><i class="fa-solid fa-tags"></i>&nbsp;Danh mục phim</a></li>
      <li class="nav-item">
         <a class="nav-link <?= $this->request->getParam('controller') == 'Genres'? 'active' : ''?>" href="#submenu1" data-toggle="collapse" data-target="#submenu1"><i class="fa-solid fa-tag"></i> Thể loại phim&#9662;</a>
         <ul class="list-unstyled flex-column pl-3 collapse" id="submenu1" aria-expanded="false">
            <li class="nav-item"><a class="nav-link" href="<?= $this->Url->build(['_name'=>'admin_genre_create'])?>">Thêm mới</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= $this->Url->build(['_name'=>'admin_genre_home'])?>">Danh sách</a></li>
         </ul>
      </li>
      <li class="nav-item"><a class="nav-link <?= $this->request->getParam('controller') == 'Countries' ? 'active' : ''?>" href="<?= $this->Url->build(['controller'=>'Countries' , 'action'=>'index'])?>"><i class="fa-solid fa-earth-asia"></i> Quốc gia</a></li>
      <li class="nav-item"><a class="nav-link <?= $this->request->getParam('controller') == 'Movies'? 'active' : ''?>" href="<?= $this->Url->build(['_name'=>'admin_movies_home'])?>"><i class="fa-solid fa-clapperboard"></i> Phim</a></li>
      <li class="nav-item"><a class="nav-link <?= $this->request->getParam('controller') == 'Episodes'? 'active' : ''?>" href="<?= $this->Url->build(['_name'=>'admin_episodes_home'])?>"><i class="fa-solid fa-video"></i> Tập phim</a></li>
      <li class="nav-item">
        <a href="<?php echo $this->Url->build(['_name'=>'admin_user_index'])?>" class="nav-link <?= $this->request->getParam('controller') == 'Users' ? 'active' : ''?>">
            <i class="fa-solid fa-user"></i>&nbsp;Quản lý người dùng
        </a>
      </li>
      <li class="nav-item"><a class="nav-link <?= $this->request->getParam('controller') == 'Comment'? 'active' : ''?>" href="<?= $this->Url->build(['_name'=>'admin_comment_home'])?>"><i class="fa fa-commenting" aria-hidden="true"></i> Bình luận</a></li>
      <li class="nav-item"><a class="nav-link" href=""><i class="fa-solid fa-gear"></i> Cài đặt chung</a></li>
   </ul>
</div>
<!--/col-->