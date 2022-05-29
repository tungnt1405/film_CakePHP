<?= $this->element('admin/head')?>

<body>
  <?=$this->element('admin/header')?>
  <div class="container-fluid" id="main">
    <div class="row row-offcanvas row-offcanvas-left">
      <?= $this->element('admin/navbar')?>

      <?= $this->fetch('content')?>
    </div>
  </div>
  <?= $this->element('admin/footer')?>

</body>

</html>