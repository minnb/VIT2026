{{-- $com, $lstCateFooter: cung cấp bởi ViewComposerServiceProvider --}}
<footer>
  <div class="container">
    <div class="row">
      <div class="zalo-chat-widget" data-oaid="886745792358844995" data-welcome-message="Rất vui khi được hỗ trợ bạn!" data-autopopup="0" data-width="" data-height=""></div>
      <script src="https://sp.zalo.me/plugins/sdk.js" async></script>

      <div class="col-sm-6 col-md-3 col-xs-12">
        <div class="footer-logo" style="text-align: left;">
          <b style="color:white">{{ $com[0]['name'] ?? '' }}</b>
        </div>
        <div class="footer-description"><strong>Địa chỉ: </strong>Số 16 - Ngõ 85 - Đường Lĩnh Nam - P. Mai Động - Q. Hoàng Mai - TP. Hà Nội</div>
        <div class="footer-description"><strong>VPGD: </strong>Tầng 11 - toà nhà ADI (Vietcombank) - Đường Tố Hữu - P.Vạn Phúc - Q.Hà Đông - TP.Hà Nội</div>
        <div class="footer-description"><b>Điện thoại:</b> {{ $com[0]['phone'] ?? '' }}</div>
        <div class="footer-description"><b>Email:</b> {{ $com[0]['email'] ?? '' }}</div>
      </div>
      <div class="col-sm-6 col-md-4 col-xs-12 collapsed-block">
        <div class="footer-links">
          <h3 class="links-title">Sản phẩm<a class="expander visible-xs" href="#TabBlock-1" aria-label="Mở rộng danh sách sản phẩm" aria-expanded="false" aria-controls="TabBlock-1">+</a></h3>
          <div class="tabBlock" id="TabBlock-1">
            <ul class="list-links list-unstyled">
              @foreach($lstCateFooter as $item)
                <li><a class="a-footer-product-list" href="{{ route('get.product.cate', ['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['name'])]) }}">{{ $item['name'] }}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-3 col-md-2 col-xs-12 collapsed-block">
        <div class="footer-links">
          <h3 class="links-title">Danh mục<a class="expander visible-xs" href="#TabBlock-4" aria-label="Mở rộng danh mục" aria-expanded="false" aria-controls="TabBlock-4">+</a></h3>
          <div class="tabBlock" id="TabBlock-4">
            <ul class="list-links list-unstyled">
              <li><a href="{{ route('get.product.all') }}">Sản phẩm</a></li>
              <li><a href="{{ route('get.project.all') }}">Dự án</a></li>
              <li><a href="{{ route('get.document.all') }}">Báo giá &amp; Catalog</a></li>
              <li><a href="{{ route('get.baohanh') }}">Chính sách bảo hành</a></li>
              <li><a href="{{ route('get.baomat') }}">Chính sách bảo mật</a></li>
              <li><a href="{{ route('get.about') }}">Giới thiệu</a></li>
              <li><a href="{{ route('get.about') }}">Liên hệ</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-3 col-xs-12 collapsed-block">
        <div class="footer-links">
          <h3 class="links-title">NHÀ MÁY SẢN XUẤT<a class="expander visible-xs" href="#TabBlock-5" aria-label="Mở rộng thông tin nhà máy" aria-expanded="false" aria-controls="TabBlock-5">+</a></h3>
          <div class="tabBlock" id="TabBlock-5">
            <div class="footer-description"><strong>Miền Bắc: </strong>Cụm CN Yên Bình, Xã Yên Bình, H.Thạch Thất, TP. Hà Nội</div>
            <div class="footer-description"><strong>Miền Nam: </strong>Cụm công nghiệp Đức Hoà Đông, Xã Đức Hoà Đông, H.Đức Hoà, Tỉnh Long An</div>
          </div>
          <br>
          <div>
            <ul>
              <li>
                {{-- Logo phuc vu tu may chu nha, KHONG hotlink online.gov.vn:
                     duong dan cu /Content/EndUser/... da 404 sau khi ho doi he
                     thong, va cong 443 ben ho khong phan hoi -> anh bi mat.
                     Quy dinh chi bat buoc logo co lien ket toi trang thong bao. --}}
                <a title="Xem thông báo website với Bộ Công Thương" target="_blank" rel="noopener" href="https://online.gov.vn/Home/WebDetails/53965">
                  <img src="{{ asset_v('public/home/images/bo-cong-thuong.png') }}"
                       alt="Đã thông báo với Bộ Công Thương"
                       width="132" height="50" loading="lazy" decoding="async">
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
        <div class="col-sm-6 col-xs-12 coppyright"> Copyright &copy; {{ date('Y') }} <a href="{{ route('index') }}">VITDUCT</a>. All Rights Reserved. </div>
        <div class="col-sm-6 col-xs-12">
          <ul class="footer-company-links">
            <li><a href="{{ route('index') }}">Trang chủ</a></li>
            <li><a href="{{ route('get.about') }}">Giới thiệu</a></li>
            <li><a href="{{ route('get.product.all') }}">Sản phẩm</a></li>
            <li><a href="{{ route('get.about') }}">Liên hệ</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>
<a href="#" id="back-to-top" title="Lên đầu trang" aria-label="Lên đầu trang"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
