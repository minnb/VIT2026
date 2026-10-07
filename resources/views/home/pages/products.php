<?php  require __DIR__.'/../layouts/header.php'; ?>
<body class="">
<?php require __DIR__.'/../layouts/nav.php'; ?>
<div class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <ul>
          <li class="home"> <a title="Quay về trang chủ" href="<?php echo route('index'); ?>">Trang chủ</a><span>&raquo;</span></li>
          <li class=""> <a title="Sản phẩm sản xuất tại Vitduct" href="#">Sản phẩm</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="main-container col1-layout">
<div class="container">
  <div class="row">
    <div class="col-main col-sm-12 col-xs-12">
      <div class="shop-inner">
        <div class="product-grid-area">
          <ul class="products-grid">
            <?php foreach($data as $key=>$value) { ?>
            <li class="item col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
              <div class="product-item">
                <div class="item-inner">
                  <div class="product-thumbnail">
                    <div class="pr-img-area product-imgage-lager"> <a title="<?php echo $value['title']; ?>" href="<?php echo route('get.product.single',['id'=>fencrypt($value['id']),'name'=>makeUnicode($value['title'])]) ?>">
                      <figure><img class="first-img" src="<?php echo getImageInContent($value['content']) ?>" alt="<?php echo $value['title']; ?>"></figure>
                      </a> </div>
                  </div>
                  <div class="item-info">
                    <div class="info-inner">
                      <div class="item-title"> <a title="<?php echo $value['title']; ?>" href="<?php echo route('get.product.single',['id'=>fencrypt($value['id']),'name'=>makeUnicode($value['title'])]) ?>"><?php echo $value['title']; ?></a> </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          <?php } ?>
          </ul>
        </div>
        <div class="pagination-area ">
            <?php $data->onEachSide(12)->links(); ?>
        </div>
      </div>
    </div>
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


