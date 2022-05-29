<nav class="navbar navbar-fixed-top navbar-toggleable-sm navbar-inverse bg-primary">
   <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
   <span class="navbar-toggler-icon"></span>
   </button>
   <div class="flex-row d-flex">
      <a class="navbar-brand mb-1" href="#">Block Butter <span>(film review)</span></a>
      <button type="button" class="hidden-md-up navbar-toggler" data-toggle="offcanvas" title="Toggle responsive left sidebar">
      <span class="navbar-toggler-icon"></span>
      </button>
   </div>
   <div class="navbar-collapse collapse" id="collapsingNavbar">      
      <ul class="navbar-nav ml-auto">
         <!-- <li class="nav-item">
            <a class="nav-link" href="" data-target="#myModal" data-toggle="modal">About</a>
         </li> -->
         <li class="nav-item">
            <a class="nav-link" href="<?= $this->Url->build(['_name'=>'admin_logout'])?>">Đăng xuất</a>
         </li>
      </ul>
   </div>
</nav>