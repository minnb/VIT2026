@extends('home.layouts.master')

@section('body_class', 'cms-index-index cms-home-page')

@section('title', 'Sản xuất ống gió, van gió, cửa gió - Thi công hệ thống ME')

@section('meta_description', config('seo.default_description'))
@section('canonical', seo_canonical('/'))

@section('content')
  @include('home.partials.slide')

  <div class="inner-box">
    <div class="container">
      <div class="page-title">
        <h1>Sản xuất ống gió, van gió, cửa gió &amp; thi công hệ thống ME</h1>
      </div>
      @php
          // Chi nhan link web that: cot `description` do admin nhap tu do,
          // khong rang buoc dinh dang -> loc bo ca chuoi rong lan scheme la.
          $docs = array_values(array_filter($topDocs ?? [], function ($doc) {
              return \Illuminate\Support\Str::startsWith($doc['url'], ['http://', 'https://', '/']);
          }));
          $hasDoc = count($docs) > 0;
      @endphp
      <div class="row">
        @if($hasDoc)
          <div class="col-md-3 top-banner hidden-sm">
            <aside class="vit-doc-cta js-doc-rotator" data-interval="5000"
                   aria-roledescription="carousel" aria-label="Tài liệu kỹ thuật nổi bật">
              <h2 class="sr-only">Tài liệu kỹ thuật nổi bật</h2>

              <div class="vit-doc-cta__slides">
                @foreach($docs as $doc)
                  <article class="vit-doc-cta__slide{{ $loop->first ? ' is-active' : '' }}"
                           aria-hidden="{{ $loop->first ? 'false' : 'true' }}">
                    <div class="vit-doc-cta__head">
                      <span class="vit-doc-cta__icon"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span>
                      <p class="vit-doc-cta__eyebrow">{{ $doc['cate'] }}</p>
                      <p class="vit-doc-cta__title">{{ $doc['title'] }}</p>
                    </div>
                    <div class="vit-doc-cta__foot">
                      <a class="vit-doc-cta__btn" target="_blank" rel="noopener"
                         href="{{ $doc['url'] }}">Xem ngay</a>
                      <p class="vit-doc-cta__note">Bản đầy đủ &middot; Xem &amp; tải miễn phí</p>
                    </div>
                  </article>
                @endforeach
              </div>

              @if(count($docs) > 1)
                <div class="vit-doc-cta__dots">
                  @foreach($docs as $doc)
                    <button type="button"
                            class="vit-doc-cta__dot{{ $loop->first ? ' is-active' : '' }}"
                            data-index="{{ $loop->index }}"
                            aria-label="Xem tài liệu: {{ $doc['title'] }}"></button>
                  @endforeach
                </div>
              @endif
            </aside>
          </div>
        @endif
        <div class="col-sm-12 {{ $hasDoc ? 'col-md-9' : 'col-md-12' }} jtv-best-sale special-pro">
          <div class="jtv-best-sale-list">
            <div class="wpb_wrapper">
              <div class="best-title text-left">
                <h2>Sản phẩm tiêu biểu</h2>
              </div>
            </div>
            <div class="slider-items-products">
              <div id="jtv-best-sale-slider" class="product-flexslider">
                <div class="slider-items">
                  @foreach($topProducts as $item)
                    @include('home.partials.product_card', [
                        'item'         => $item,
                        'showNewLabel' => true,
                    ])
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    @foreach($productCategories as $cate)
      <div class="home-tab">
        <div class="tab-title text-left">
          <h2>{{ $cate['name'] }}</h2>
        </div>
        <div class="tab-content">
          <div class="tab-pane active in">
            <div class="featured-pro">
              <div class="slider-items-products">
                <div class="product-flexslider hidden-buttons js-product-slider">
                  <div class="slider-items slider-width-col4">
                    @foreach($cate['posts'] as $value)
                      @include('home.partials.product_card', [
                          'item'       => $value,
                          'largeImage' => true,
                      ])
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="container">
    @foreach($projectCategories as $cate)
      <div class="home-tab">
        <div class="tab-title text-left">
          <h2>{{ $cate['name'] }}</h2>
        </div>
        <div class="tab-content">
          <div class="tab-pane active in">
            <div class="featured-pro">
              <div class="slider-items-products">
                <div class="product-flexslider hidden-buttons js-product-slider">
                  <div class="slider-items slider-width-col4">
                    @foreach($cate['posts'] as $value)
                      @include('home.partials.product_card', [
                          'item'       => $value,
                          'largeImage' => true,
                          'imageSrc'   => getImageInContent($value['content']),
                      ])
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="container">
    @include('home.partials.product_link')
  </div>
@endsection
