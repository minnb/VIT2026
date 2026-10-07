 <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="zalo-chat-widget" data-oaid="886745792358844995" data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="0" data-width="" data-height=""></div>
        <script src="https://sp.zalo.me/plugins/sdk.js"></script>

        <div class="col-sm-6 col-md-3 col-xs-12">
          <div class="footer-logo" style="text-align: left;">
            <!--<img src="" alt="vitduct.com.vn"></a>-->
            <b style="color:white"><?php echo e($com[0]['name']); ?></b>
          </div>
          <!--
          <div class="footer-description"><?php echo $com[0]['address'] ?></div>
          <div class="footer-description"><b>Điện thoại:</b> <?php echo e($com[0]['phone']); ?> </div>
          <div class="footer-description"><b>Fax:</b> <?php echo $com[0]['fax'] ?> </div>
          <div class="footer-description"><b>Email:</b> <?php echo e($com[0]['email']); ?> </div>
        -->
          <div class="footer-description"><strong>Địa chỉ: </strong>Số 16 - Ngõ 85 - Đường Lĩnh Nam - P. Mai Động  - Q. Hoàng Mai - TP. Hà Nội</div>
          <div class="footer-description"><strong>VPGD: </strong>Tầng 11 - toà nhà ADI (Vietcombank) - Đường Tố Hữu - P.Vạn Phúc - Q.Hà Đông - TP.Hà Nội</div>
          <div class="footer-description"><b>Điện thoại:</b> <?php echo e($com[0]['phone']); ?> </div>
          <div class="footer-description"><b>Email:</b> <?php echo e($com[0]['email']); ?> </div>
        </div>
        <div class="col-sm-6 col-md-4 col-xs-12 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">Sản phẩm<a class="expander visible-xs" href="#TabBlock-1">+</a></h3>
            <div class="tabBlock" id="TabBlock-1">
              <ul class="list-links list-unstyled">
                <?php 
                  $lstCateP = App\Models\Category::getListTop(1,9); 
                  foreach($lstCateP as $key=>$item) {
                ?>
                  <li><a class="a-footer-product-list" href="<?php echo route('get.product.cate', ['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['name'])] ) ?>"><?php echo e($item['name']); ?></a></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-md-2 col-xs-12 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">Danh mục<a class="expander visible-xs" href="#TabBlock-4">+</a></h3>
            <div class="tabBlock" id="TabBlock-4">
              <ul class="list-links list-unstyled">
                <li><a href="<?php echo route('index'); ?>">Sản phẩm</a></li>
                <li><a href="<?php echo route('index'); ?>">Dự án</a></li>
                <li><a href="<?php echo route('index'); ?>">Báo giá & Catalog</a></li>
                <li><a href="<?php echo route('get.baohanh'); ?>">Chính sách bảo hành </a></li>
                <li><a href="<?php echo route('get.baomat'); ?>">Chính sách bảo mật</a></li>
                <li><a href="<?php echo route('get.about'); ?>">Giới thiệu</a></li>
                <li><a href="<?php echo route('get.about'); ?>">Liên hệ</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xs-12 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">NHÀ MÁY SẢN XUẤT<a class="expander visible-xs" href="#TabBlock-5">+</a></h3>
            <div class="tabBlock" id="TabBlock-5">
              <div class="footer-description"><strong>Miền Bắc: </strong>Cụm CN Yên Bình, Xã Yên Bình, H.Thạch Thất, TP. Hà Nội</div>
              <div class="footer-description"><strong>Miền Nam: </strong>Cụm công nghiệp Đức Hoà Đông, Xã Đức Hoà Đông, H.Đức Hoà, Tỉnh Long An</div>
            </div>
            <br> 
            <div class="">
                <ul class="">
                  <li class="">
                    <a title="Đã đăng ký với Bộ Công Thương" target="_blank" href="http://online.gov.vn/Home/WebDetails/53965">
                      <img src="http://online.gov.vn/Content/EndUser/LogoCCDVSaleNoti/logoSaleNoti.png" style="max-height: 50px;">
                    </a>
                  </li>
                </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-coppyright">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-xs-12 coppyright"> Copyright © 2018 <a href="https://vitduct.com.vn/"> VITDUCT </a>. All Rights Reserved. </div>
          <div class="col-sm-6 col-xs-12">
            <ul class="footer-company-links">
              <li> <a href="<?php echo route('index'); ?>">Trang chủ</a> </li>
              <li> <a href="<?php echo route('get.about'); ?>">Giới thiệu</a> </li>
              <li> <a href="<?php echo route('index'); ?>">Sản phẩm</a> </li>
              <li> <a href="<?php echo route('index'); ?>">Liên hệ</a> </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <a href="#" id="back-to-top" title="Back to top"><i class="fa fa-angle-up"></i></a> 
  <!-- End Footer --> 