<?php  require __DIR__.'/../layouts/header.php'; ?>
<body class="">
 <?php require __DIR__.'/../layouts/nav.php'; ?>
<div class="breadcrumbs">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <ul>
          <li class="home"> <a title="<?php echo $data['title']; ?>" href="<?php echo route('index'); ?>">Trang chủ</a><span>&raquo;</span></li>
          <li class=""> <a title="<?php echo $data['title']; ?>" href="#"><?php echo App\Models\Category::find($data['categorieID'])->name; ?></a><span>&raquo;</span></li>
          <li><strong><?php echo $data['title']; ?></strong></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="main-container col2-left-layout">
    <div class="container">
      <div class="row">
        <div class="col-main col-sm-9 col-xs-12">
          <div class="product-view-area">
            <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
              <div class="large-image"> <a href="#" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> <img class="zoom-img" src="<?php echo App\Models\Images::checkImageProduct($data['id']); ?>" alt="<?php echo $data['title'] ?>"> </a> </div>
            </div>
            <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7 product-details-area">
              <div class="product-name">
                <h2><?php echo $data['title'] ?></h2>
              </div>
              <div class="ratings">
                <div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> </div>
                <p class="rating-links"> </p>
                <p class="availability in-stock pull-right">Sản xuất: <span>Việt Nam</span></p>
              </div>
              <div class="short-description">
                <h2>LIÊN HỆ</h2>
                <p>Điện thoại: (+84) 0983 625 429 </p>
                <p>Email: contact@vitduct.com.vn</p>
              </div>
              <div class="short-description">
                <p><b>Sản xuất:</b> Ống thông gió, van gió, cửa gió. Lò xo chống rung giảm chấn các loại. Cung cấp, thi công Hệ thống điều hòa không khí và thông 
                gió</p>
                <p>Thi công lắp đặt các hệ thống ME cho các tòa nhà và nhà máy công nghiệp</p>
              </div>
            </div>
          </div>
          <div class="product-overview-tab">
            <div class="product-tab-inner">
              <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                <li class="active"> <a href="#description" data-toggle="tab"> Chi tiết sản phẩm </a> </li>
              </ul>
              <div id="productTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="description">
                  <div class="std">
                    <?php echo $data['content'] ; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <aside class="right sidebar col-sm-3 col-xs-12">
          <div class="block shop-by-side">
            <div class="sidebar-bar-title">
              <h3>Danh mục</h3>
            </div>
            <div class="block-content">
              <div class="layered-Category">
                <div class="layered-content">
                  <ul class="check-box-list">
                    <?php foreach($lstCate as $key=>$item) { ?>
                    <li>
                      <label for="jtv1"> <span class="button"></span> <?php echo $item['name']; ?><span class="count">(<?php echo App\Models\Post::CountPostByCateId($item['id']); ?>)</span> </label>
                    </li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="block special-product">
            <div class="sidebar-bar-title">
              <h3><?php echo App\Models\Category::getParentNameByCateId($data['categorieID']); ?></h3>
            </div>
            <div class="block-content">
              <ul>
                <?php 
                  $lstPro = App\Models\Post::getRandomPostByCate($data['categorieID'],3); 
                  foreach($lstPro as $key=>$value) {
                ?>
                <li class="item">
                  <div class="products-block-left"> <a href="<?php echo route('get.product.single',['id'=>fencrypt($value['id']),'name'=>makeUnicode($value['title'])]) ?>" title="<?php echo $value['title'] ?>" class="product-image"><img src="<?php echo App\Models\Images::checkImageProduct($value['id']); ?>" alt="<?php echo $value['title'] ?>"></a></div>
                  <div class="products-block-right">
                    <p class="product-name"> <a href="<?php echo route('get.product.single',['id'=>fencrypt($value['id']),'name'=>makeUnicode($value['title'])]) ?>"><?php echo $value['title'] ?></a> </p>
                    <span class="price"></span>
                  </div>
                </li>
                <?php } ?>
              </ul>
              <a class="link-all" href="<?php echo route('get.product.all'); ?>">Xem toàn bộ sản phẩm</a> </div>
          </div>

          <div class="block special-product">
            <div class="sidebar-bar-title">
              <h3>Báo giá & Catalog</h3>
            </div>
            <div class="block-content">
              <ul>
                <?php 
                  $lstDoc = App\Models\Post::getRandomPostByCate(12,5); 
                  foreach($lstDoc as $key=>$value) {
                ?>
                <li class="item">
                    <p class="product-name"> 
                      <i class="fa fa-download"></i>
                      <a target="_bank" href="<?php echo $value['description']; ?>"> <?php echo $value['title'] ?></a> </p>
                    <span class="price"></span>
                </li>
                <?php } ?>
              </ul>
              <a class="link-all" href="<?php echo route('get.document.all'); ?>">Tất cả Báo giá & Catalog</a> </div>
          </div>
        </aside>
      </div>
    </div>
  </div>
<div class="container">
    <div class="home-tab">
      <div class="tab-title text-left">
        <h2>Sản phẩm khác</h2>
      </div>
      <div id="productTabContent" class="tab-content">
        <div class="tab-pane active in" id="#">
          <div class="featured-pro">
            <div class="slider-items-products">
              <div id="computer-slider" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col4">
                  <?php
                    $lstProByCate = App\Models\Post::getRandomPostByCate($data['categorieID'],4) ; 
                    foreach($lstProByCate as $value) {
                  ?>
                  <div class="product-item">
                    <div class="item-inner">
                      <div class="product-thumbnail">
                        <div class="pr-img-area product-imgage-lager"> <a title="<?php echo $value['title']; ?>" href="<?php echo route('get.product.single',['id'=>fencrypt($value['id']),'name'=>makeUnicode($value['title'])]) ?>">
                          <figure> <img class="first-img" src="<?php echo App\Models\Images::checkImageProduct($value['id']); ?>" alt="<?php echo e($value['title'] ?? 'Sản phẩm VITDUCT') ?>"></figure>
                          </a> </div>
                        </div>
                      <div class="item-info">
                        <div class="info-inner">
                          <div class="item-title"> <a title="<?php echo $value['title']; ?>" href="<?php echo route('get.product.single',['id'=>fencrypt($value['id']),'name'=>makeUnicode($value['title'])]) ?>"><?php echo $value['title']; ?> </a> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
               </div>
              </div>
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
