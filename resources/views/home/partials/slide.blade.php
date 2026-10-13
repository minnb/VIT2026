{{-- $slides: cung cấp bởi HomeController@index --}}
<div class="main-slider" id="home">
  <div class="container">
    <div class="row">
      {{-- Slider chiếm trọn chiều ngang container --}}
      <div class="col-xs-12">
        <div class="vit-hero-slider owl-carousel">
          @foreach($slides as $value)
            @php
                $slideSrc = !empty($value->image) ? getImage($value->image) : asset('home/images/logo.jpg');
            @endphp
            <div class="vit-hero-slide">
              <img src="{{ $slideSrc }}"
                   alt="{{ $value->title ?: ('Sản xuất ống gió, van gió, cửa gió VITDUCT - Slide ' . ($loop->index + 1)) }}"
                   loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                   @if($loop->first) fetchpriority="high" @endif
                   decoding="async">
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
