{{-- $productLinks: cung cấp bởi HomeController@index --}}
<div class="home-tab">
  <div class="row">
    <div class="col-sm-12 col-md-12 jtv-best-sale special-pro">
      <div class="jtv-best-sale-list">
        <div class="wpb_wrapper">
          <div class="best-title text-left">
            <h2>Sản phẩm liên kết</h2>
          </div>
        </div>
        <div class="slider-items-products">
          <div class="product-flexslider js-product-slider">
            <div class="slider-items">
              @foreach($productLinks as $item)
                @php
                    $itemUrl = route('get.product.single', [
                        'id'   => fencrypt($item['id']),
                        'name' => makeUnicode($item['title']),
                    ]);
                @endphp
                <div class="product-item">
                  <div class="item-inner">
                    <div class="product-thumbnail text-center">
                      <div class="pr-img-area product-image">
                        <a title="{{ $item['title'] }}" href="{{ $itemUrl }}">
                          <figure><img class="first-img" src="{{ App\Models\Images::checkImageProduct($item['id']) }}" alt="{{ $item['title'] }}" loading="lazy" decoding="async"></figure>
                        </a>
                      </div>
                    </div>
                    <div class="item-info">
                      <div class="info-inner">
                        <div class="item-title">
                          <a title="{{ $item['title'] }}" href="{{ $itemUrl }}"><strong>{{ $item['title'] }}</strong></a>
                        </div>
                        <div class="item-content">
                          <div class="item-price">
                            <div class="price-box"><span class="regular-price"><span class="price"></span>{{ $item['description'] }}</span></div>
                          </div>
                          <div class="pro-action"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
