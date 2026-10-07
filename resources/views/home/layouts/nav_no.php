<?php 
$lstCate = App\Models\Category::getList(1); 
?>
<nav>
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 jtv-megamenu">
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
                      <div class="title"> <a href="<?php echo route('get.product.cate', ['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['name'])] ) ?>"><?php echo $item['name'] ?></a></div>
                    </li>
                    <?php } ?>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="mt-root">
              <div class="mt-root-item"><a href="#">
                <div class="title title_font"><span class="title-text">Báo giá & Catalog</span></div>
                </a></div>
              <ul class="menu-items col-xs-12">
                <li class="menu-item depth-1 menucol-1-3 ">
                  <ul class="submenu">
                    <?php 
                      $lstDoc = App\Models\Category::getList(11); 
                      foreach($lstDoc as $key=>$item) { ?>
                    <li class="menu-item">
                      <div class="title"> <a href="#"><?php echo $item['name'] ?></a></div>
                    </li>
                    <?php } ?>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="mt-root">
              <div class="mt-root-item"><a href="#">
                <div class="title title_font"><span class="title-text">Dự án</span> </div>
                </a></div>
            </li>
            <li class="mt-root">
              <div class="mt-root-item"><a href="#">
                <div class="title title_font"><span class="title-text">Giới thiệu</span></div>
                </a></div>
            </li>
            <li class="mt-root">
              <div class="mt-root-item"><a href="#">
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
  