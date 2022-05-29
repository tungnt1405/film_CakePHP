<?= $this->element('client/head') ?>

<body>
    <!--preloading-->
    <?php if (empty($check_loader)) : ?>
        <div id="preloader">
            <?php echo $this->Html->image('default/logo1.png', ["width" => "119", "height" => "58", "class" => '"logo']) ?>
            <div id="status">
                <span></span>
                <span></span>
            </div>
        </div>
    <?php endif; ?>

    <!--end of preloading-->
    <?= $this->element('login') ?>
    <?= $this->element('register') ?>

    <?= $this->element('client/header') ?>

    <?= $this->fetch('content') ?>
    <?= $this->element('client/footer') ?>
</body>

</html>