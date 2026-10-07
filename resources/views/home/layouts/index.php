<?php  require __DIR__.'/../layouts/header.php'; ?>
<body class="cms-index-index cms-home-page">
 <?php require __DIR__.'/../layouts/nav.php'; ?>
 <?php
 require __DIR__.'/../layouts/slide.php';
 require __DIR__.'/../layouts/service.php';
?>
  <div class="inner-box">
    <div class="container">
      <div class="row"> 
        <?php $top1_doc = App\Models\Post::getRandomPostByCate(12,''); ?>
        <div class="col-md-3 top-banner hidden-sm">
          <div class="jtv-banner3">
            <div class="jtv-banner3-inner"><a href="#"><img src="<?php echo asset('public/home/images/sub1.jpg') ?>" alt="Banner sản phẩm VITDUCT"></a>
              <div class="hover_content">
                <div class="hover_data">
                  <div class="title"><?php echo e(App\Models\Category::getNameById($top1_doc['categorieID'])); ?></div>
                  <div class="desc-text"></div>
                  <span><?php echo e($top1_doc['title']); ?></span>
                  <p><a target="_bank" href="<?php echo $top1_doc['description'] ; ?>" class="shop-now">Xem ngay</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-9 jtv-best-sale special-pro">
          <div class="jtv-best-sale-list">
            <div class="wpb_wrapper">
              <div class="best-title text-left">
                <h2>Sản phẩm tiêu biểu</h2>
              </div>
            </div>
            <div class="slider-items-products">
              <div id="jtv-best-sale-slider" class="product-flexslider">
                <div class="slider-items">
                  <?php 
                    $topProduct = App\Models\Post::getRandomPost(1,7); 
                    foreach($topProduct as $key=>$item) {
                  ?>
                  <div class="product-item">
                    <div class="item-inner">
                      <div class="product-thumbnail">
                        <div class="icon-new-label new-left">Mới</div>
                        <div class="pr-img-area product-image"> <a title="<?php echo e($item['title']); ?>" href="<?php echo route('get.product.single',['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['title'])]) ?>">
                          <figure> <img class="first-img" src="<?php echo App\Models\Images::checkImageProduct($item['id']); ?>" alt="<?php echo e($item['title']); ?>"></figure>
                          </a> </div>
                      </div>
                      <div class="item-info">
                        <div class="info-inner">
                          <div class="item-title"> <a title="<?php echo e($item['title']); ?>" href="<?php echo route('get.product.single',['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['title'])]) ?>"><?php echo e($item['title']); ?> </a> </div>
                          <div class="item-content">
                            <div class="rating"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
                            <div class="item-price">
                              <div class="price-box"> <span class="regular-price"> <span class="price"></span> </span> </div>
                            </div>
                            <div class="pro-action">
                            </div>
                          </div>
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
  <div class="container">
  
    <?php 
      $lstCatePro= App\Models\Category::getList(1); 
      foreach($lstCatePro as $key=>$item) {
    ?>
    <div class="home-tab">
      <div class="tab-title text-left">
        <h2><?php echo e($item['name']); ?></h2>
      </div>
      <div id="productTabContent" class="tab-content">
        <div class="tab-pane active in" id="#">
          <div class="featured-pro">
            <div class="slider-items-products">
              <div id="computer-slider" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col4">
                  <?php
                    $lstProByCate = App\Models\Post::getPostByCateId($item['id'],4) ; 
                    foreach($lstProByCate as $value) {
                  ?>
                  <div class="product-item">
                    <div class="item-inner">
                      <div class="product-thumbnail">
                        <div class="pr-img-area product-imgage-lager"> <a title="<?php echo e($value['title']); ?>" href="<?php echo route('get.product.single',['id'=>fencrypt($value['id']),'name'=>makeUnicode($value['title'])]) ?>">
                          <figure> <img class="first-img" src="<?php echo App\Models\Images::checkImageProduct($value['id']); ?>" alt="<?php echo e($value['title']); ?>"></figure>
                          </a> </div>
                        </div>
                      <div class="item-info">
                        <div class="info-inner">
                          <div class="item-title"> <a title="<?php echo e($value['title']); ?>" href="#"><?php echo e($value['title']); ?> </a> </div>
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
    <?php } ?>
  </div>

  <div class="container">
    <?php 
      $lstCateProject= App\Models\Category::getList(2); 
      foreach($lstCateProject as $key=>$item) {
    ?>
      <div class="home-tab">
        <div class="tab-title text-left">
          <h2><?php echo e($item['name']); ?></h2>
        </div>
        <div id="productTabContent" class="tab-content">
          <div class="tab-pane active in" id="#">
            <div class="featured-pro">
              <div class="slider-items-products">
                <div id="computer-slider" class="product-flexslider hidden-buttons">
                  <div class="slider-items slider-width-col4">
                    <?php
                      $lstProByCate = App\Models\Post::getPostByCateId($item['id'],4) ; 
                      foreach($lstProByCate as $value) {
                    ?>
                    <div class="product-item">
                      <div class="item-inner">
                        <div class="product-thumbnail">
                          <div class="pr-img-area product-imgage-lager"> <a title="<?php echo e($value['title']); ?>" href="<?php echo route('get.product.single',['id'=>fencrypt($value['id']),'name'=>makeUnicode($value['title'])]) ?>">
                            <figure> <img class="first-img" src="<?php echo getImageInContent($value['content']) ?>" alt="<?php echo e($value['title'] ?? 'Sản phẩm VITDUCT') ?>"></figure>
                            </a> </div>
                          </div>
                        <div class="item-info">
                          <div class="info-inner">
                            <div class="item-title"> <a title="<?php echo e($value['title']); ?>" href="<?php echo route('get.product.single',['id'=>fencrypt($value['id']),'name'=>makeUnicode($value['title'])]) ?>"><?php echo e($value['title']); ?> </a> </div>
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
    <?php } ?>
  </div>

  <div class="container">
    <?php
     require __DIR__.'/../layouts/product_link.php';
    ?>
  </div>
<?php
 require __DIR__.'/../layouts/footer.php';
?>
</div>
<script type="text/javascript" src="<?php echo asset('public/home/js/jquery.min.js') ?>"></script> 
<script type="text/javascript" src="<?php echo asset('public/home/js/bootstrap.min.js') ?>"></script> 
<script type="text/javascript" src="<?php echo asset('public/home/js/owl.carousel.min.js') ?>"></script> 
<script type="text/javascript" src="<?php echo asset('public/home/js/mobile-menu.js') ?>"></script> 
<script type="text/javascript" src="<?php echo asset('public/home/js/jquery-ui.js') ?>"></script> 
<script type="text/javascript" src="<?php echo asset('public/home/js/main.js') ?>"></script> 
<script type="text/javascript" src="<?php echo asset('public/home/js/countdown.js') ?>"></script> 
<script type="text/javascript" src="<?php echo asset('public/home/js/revolution-slider.js') ?>"></script> 
<script type='text/javascript'>
        jQuery(document).ready(function(){
            jQuery('#rev_slider_4').show().revolution({
                dottedOverlay: 'none',
                delay: 5000,
                startwidth: 865,
	              startheight: 450,
                hideThumbs: 200,
                thumbWidth: 200,
                thumbHeight: 50,
                thumbAmount: 2,
                navigationType: 'thumb',
                navigationArrows: 'solo',
                navigationStyle: 'round',
                touchenabled: 'on',
                onHoverStop: 'on',
                swipe_velocity: 0.7,
                swipe_min_touches: 1,
                swipe_max_touches: 1,
                drag_block_vertical: false,
                spinner: 'spinner0',
                keyboardNavigation: 'off',
                navigationHAlign: 'center',
                navigationVAlign: 'bottom',
                navigationHOffset: 0,
                navigationVOffset: 20,
                soloArrowLeftHalign: 'left',
                soloArrowLeftValign: 'center',
                soloArrowLeftHOffset: 20,
                soloArrowLeftVOffset: 0,
                soloArrowRightHalign: 'right',
                soloArrowRightValign: 'center',
                soloArrowRightHOffset: 20,
                soloArrowRightVOffset: 0,
                shadow: 0,
                fullWidth: 'on',
                fullScreen: 'off',
                stopLoop: 'off',
                stopAfterLoops: -1,
                stopAtSlide: -1,
                shuffle: 'off',
                autoHeight: 'off',
                forceFullWidth: 'on',
                fullScreenAlignForce: 'off',
                minFullScreenHeight: 0,
                hideNavDelayOnMobile: 1500,
                hideThumbsOnMobile: 'off',
                hideBulletsOnMobile: 'off',
                hideArrowsOnMobile: 'off',
                hideThumbsUnderResolution: 0,
                hideSliderAtLimit: 0,
                hideCaptionAtLimit: 0,
                hideAllCaptionAtLilmit: 0,
                startWithSlide: 0,
                fullScreenOffsetContainer: ''
            });
        });
        </script>
</body>
</html>
