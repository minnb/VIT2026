  <div id="mobile-menu">
    <ul>
      <li><a href="<?php echo route('index'); ?>" class="home1">Trang chủ</a></li>
  <?php 
      $lstCate = App\Models\Category::getList(1); 
      foreach($lstCate as $key=>$item) {
  ?>
      <li><a href="<?php echo route('get.product.cate', ['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['name'])] ) ?>"><?php echo e($item['name']); ?></a>
  <?php } ?>
      <li><a href="#">Dự án tiêu biểu</a></li>
      <li><a href="#">Báo giá & Catalog</a></li>
      <li><a href="#">Giới thiệu</a></li>
      <li><a href="#">Hình ảnh</a></li>
      <li><a href="#">Liên hệ</a></li>
    </ul>
  </div>
  <div id="page"> 
  <header>
    <div class="header-container">
      <div class="header-inner">
        <div class="container">
          <div class="row">
            <div class="col-sm-3 col-xs-12 jtv-logo-block"> 
              <div class="logo"><a title="CÔNG TY CỔ PHẦN VITDUCT" href="<?php echo route('index'); ?>"><img class="img-responsive" alt="CÔNG TY CỔ PHẦN VITDUCT" title="CÔNG TY CỔ PHẦN VITDUCT" src="<?php echo asset('public/home/images/logo.jpg') ?>"></a> </div>
            </div>
            <div class="col-xs-12 col-sm-5 col-md-6 jtv-top-search"> 
              <div class="top-search">
                <div id="search">
                  <form method="post" action="<?php echo route('post.search') ?>">
                    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Tìm kiếm..." name="search" value="<?php echo old('search'); ?>">
                      <button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 top-cart">
              <div class="link-wishlist hidden-xs"> <a href="#"> <i class="icon-phone"></i> </i><b><?php echo e(App\Models\Setting::getHotline()); ?> </b></a> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</header>
<nav>
  <div class="container">
    <div class="row">
      <div class="mm-toggle-wrap">
        <div class="mm-toggle"><i class="fa fa-align-justify"></i> </div>
        <span class="mm-label">Danh mục</span> </div>
      <div class="col-md-3 col-sm-3 mega-container hidden-xs">
        <div class="navleft-container">
          <div class="mega-menu-title">
            <h3><span>Danh mục</span></h3>
          </div>
          <div class="mega-menu-category">
            <ul class="nav">
              <?php 
                $lstCate = App\Models\Category::getList(1); 
                foreach($lstCate as $key=>$item) {
              ?>
              <li class="nosub"><a href="<?php echo route('get.product.cate', ['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['name'])] ) ?>"><?php echo e($item['name']); ?></a></li>
              <?php } ?>
              <li class="nosub"><a href="<?php echo route('get.project.all'); ?>">Dự án tiêu biểu</a></li>
              <li class="nosub"><a href="<?php echo route('get.document.all'); ?>">Tải báo giá và Catalog</a></li>
              <li class="nosub"><a href="<?php echo route('get.project.all'); ?>">Hình ảnh nhà máy</a></li>
              <li class="nosub"><a href="<?php echo route('get.project.all'); ?>">Tin tức nội bộ</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-9 col-sm-9 jtv-megamenu">
        <div class="mtmegamenu">
          <ul class="hidden-xs">
            <li class="mt-root demo_custom_link_cms">
              <div class="mt-root-item"><a href="<?php echo route('index'); ?>">
                <div class="title title_font"><span class="title-text">Trang chủ</span></div>
                </a></div>
            </li>
            <li class="mt-root">
              <div class="mt-root-item"><a href="#">
                <div class="title title_font"><span class="title-text">Sản phẩm</span></div>
                </a></div>
              <ul class="menu-items col-xs-12">
                <li class="menu-item depth-1 menucol-1-3 ">
                  <ul class="submenu">
                    <?php foreach($lstCate as $key=>$item) { ?>
                    <li class="menu-item">
                      <div class="title"> <a href="<?php echo route('get.product.cate', ['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['name'])] ) ?>"><?php echo e($item['name']); ?></a></div>
                    </li>
                    <?php } ?>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="mt-root">
              <div class="mt-root-item"><a href="<?php echo route('get.document.all'); ?>">
                <div class="title title_font"><span class="title-text">Báo giá & Catalog</span></div>
                </a></div>
              <ul class="menu-items col-xs-12">
                <li class="menu-item depth-1 menucol-1-3 ">
                  <ul class="submenu">
                    <?php 
                      $lstDoc = App\Models\Category::getList(11); 
                      foreach($lstDoc as $key=>$item) { ?>
                    <li class="menu-item">
                      <div class="title"> <a href="<?php echo route('get.document.all'); ?>"><?php echo e($item['name']); ?></a></div>
                    </li>
                    <?php } ?>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="mt-root">
              <div class="mt-root-item"><a href="<?php echo route('get.project.all'); ?>">
                <div class="title title_font"><span class="title-text">Dự án</span> </div>
                </a></div>
            </li>
            <li class="mt-root">
              <div class="mt-root-item"><a href="<?php echo route('get.about'); ?>">
                <div class="title title_font"><span class="title-text">Giới thiệu</span></div>
                </a></div>
            </li>
            <li class="mt-root">
              <div class="mt-root-item"><a href="<?php echo route('get.about'); ?>">
                <div class="title title_font"><span class="title-text">Liên hệ</span></div>
                </a></div>
            </li>
            <li><a href="#"></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>
  