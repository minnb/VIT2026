{{--
  Component thẻ sản phẩm dùng chung.
  Biến bắt buộc: $item (array|Model có id, title)
  Tuỳ chọn: $imageSrc (string) - nếu không truyền sẽ lấy ảnh theo id sản phẩm
            $showNewLabel (bool), $largeImage (bool)
  Cách gọi: @include('home.partials.product_card', ['item' => $value])
--}}
@php
    $itemUrl = route('get.product.single', [
        'id'   => fencrypt($item['id']),
        'name' => makeUnicode($item['title']),
    ]);
    $imageSrc     = $imageSrc     ?? App\Models\Images::checkImageProduct($item['id']);
    $showNewLabel = $showNewLabel ?? false;
    $largeImage   = $largeImage   ?? false;
@endphp
<div class="product-item">
  <div class="item-inner">
    <div class="product-thumbnail">
      @if($showNewLabel)
        <div class="icon-new-label new-left">Mới</div>
      @endif
      <div class="pr-img-area {{ $largeImage ? 'product-imgage-lager' : 'product-image' }}">
        <a title="{{ $item['title'] }}" href="{{ $itemUrl }}">
          <figure><img class="first-img" src="{{ $imageSrc }}" alt="{{ $item['title'] }}" loading="lazy" decoding="async"></figure>
        </a>
      </div>
    </div>
    <div class="item-info">
      <div class="info-inner">
        <div class="item-title"><a title="{{ $item['title'] }}" href="{{ $itemUrl }}">{{ $item['title'] }}</a></div>
      </div>
    </div>
  </div>
</div>
