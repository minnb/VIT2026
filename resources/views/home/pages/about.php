<?php  require __DIR__.'/../layouts/header.php'; ?>
<body class="">
<?php require __DIR__.'/../layouts/nav.php'; ?>
<div class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <ul>
          <li class="home"> <a title="Dự án tiêu biểu của Vitduct" href="<?php echo route('index'); ?>">Trang chủ</a><span>&raquo;</span></li>
          <li class=""> <a title="Dự án tiêu biểu của Vitduct" href="#"><?php echo isset($title) ? $title:'' ?></a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="main container">
   <div class="about-page">
      <div class="col-xs-12 col-sm-12"> 
        <p><?php if(isset($data)){ echo $data; } ?></p>
      </div>
    </div>
</div>
<?php
  require __DIR__.'/../layouts/service.php';
  require __DIR__.'/../layouts/footer.php';
?>
</div>
  <script type="text/javascript" src="<?php echo asset('public/home/js/jquery.min.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/bootstrap.min.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/owl.carousel.min.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/jquery.bxslider.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/jquery.flexslider.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/mobile-menu.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/jquery-ui.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/main.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/countdown.js') ?>"></script> 
  <script type="text/javascript" src="<?php echo asset('public/home/js/cloud-zoom.js') ?>"></script> 
</body>
</html>


