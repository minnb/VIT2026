@extends('home.layouts.master')

@php
    // checkImageProduct() query thang vao bang images -> goi 1 lan roi tai su dung
    // cho og:image, JSON-LD va the <img>, tranh 3 query trung nhau.
    $pdImageSrc = App\Models\Images::checkImageProduct($data['id']);
@endphp

@section('title', $title ?? ($data['title'] ?? ''))

@section('meta_description', seo_description($data['content'] ?? '', 160))
@section('og_type', 'product')
@section('og_image', $pdImageSrc)

{{-- Canonical dung lai tu slug chuan: route /san-pham/{id}/{title} khong kiem tra {title} --}}
@section('canonical', seo_canonical(route('get.product.single', ['id' => fencrypt($data['id']), 'name' => makeUnicode($data['title'])])))

@push('jsonld')
@php
    $pdUrl   = seo_canonical(route('get.product.single', ['id' => fencrypt($data['id']), 'name' => makeUnicode($data['title'])]));
    $pdImage = seo_abs($pdImageSrc);
    // Khong khai 'offers' vi bang posts khong co cot gia - khai Offer rong se bi Google bao loi.
    // Cung khong khai aggregateRating: so sao tren giao dien la trang tri, khong phai danh gia that.
    $pdSchema = [
        '@context'         => 'https://schema.org',
        '@type'            => 'Product',
        '@id'              => $pdUrl . '#product',
        'mainEntityOfPage' => $pdUrl,
        'name'             => $data['title'],
        'sku'              => (string) $data['id'],
        'url'              => $pdUrl,
        'image'            => $pdImage,
        'description'      => seo_description($data['content'] ?? '', 300, $data['title'] . ' do VITDUCT sản xuất theo tiêu chuẩn kỹ thuật.'),
        'category'         => $cateName,
        'brand'            => ['@type' => 'Brand', 'name' => config('seo.brand')],
        'manufacturer'     => ['@id' => config('seo.base_url') . '/#organization'],
        'itemCondition'    => 'https://schema.org/NewCondition',
    ];
@endphp
<script type="application/ld+json">{!! json_encode($pdSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@endpush

@section('content')
  @include('home.partials.breadcrumbs', ['items' => [
      ['label' => $cateName, 'url' => route('get.product.cate', ['id' => fencrypt($data['categorieID']), 'name' => makeUnicode($cateName)])],
      ['label' => $data['title']],
  ]])

  <div class="main-container col2-left-layout">
    <div class="container">
      <div class="row">
        <div class="col-main col-sm-9 col-xs-12">
          <div class="product-view-area">
            <div class="product-big-image col-xs-12 col-sm-5 col-lg-5 col-md-5">
              <div class="large-image">
                <a href="#" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20">
                  <img class="zoom-img" src="{{ $pdImageSrc }}" alt="{{ $data['title'] }}" loading="eager" fetchpriority="high" decoding="async">
                </a>
              </div>
            </div>
            <div class="col-xs-12 col-sm-7 col-lg-7 col-md-7 product-details-area">
              <div class="product-name">
                <h1>{{ $data['title'] }}</h1>
              </div>
              <div class="ratings">
                <div class="rating">
                  <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>
                </div>
                <p class="rating-links"></p>
                <p class="availability in-stock pull-right">Sản xuất: <span>Việt Nam</span></p>
              </div>
              <div class="short-description">
                <h2>Liên hệ báo giá {{ $data['title'] }}</h2>
                <p>Điện thoại: <a href="tel:{{ telLink($hotline) }}">{{ $hotline }}</a></p>
                <p>Email: <a href="mailto:contact@vitduct.com.vn">contact@vitduct.com.vn</a></p>
              </div>
              <div class="short-description">
                <p><b>Sản xuất:</b> Ống thông gió, van gió, cửa gió. Lò xo chống rung giảm chấn các loại. Cung cấp, thi công Hệ thống điều hòa không khí và thông gió</p>
                <p>Thi công lắp đặt các hệ thống ME cho các tòa nhà và nhà máy công nghiệp</p>
              </div>
            </div>
          </div>
          <div class="product-overview-tab">
            <div class="product-tab-inner">
              <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                <li class="active"><a href="#description" data-toggle="tab">Chi tiết sản phẩm</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade in active" id="description">
                  <div class="std">
                    {{-- HTML tu trinh soan thao: seo_content() bo sung lazy-load + alt cho anh --}}
                    {!! seo_content($data['content'], $data['title']) !!}
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
                    @foreach($lstCate as $item)
                      <li>
                        <a href="{{ route('get.product.cate', ['id'=>fencrypt($item['id']),'name'=>makeUnicode($item['name'])]) }}">
                          <span class="button"></span> {{ $item['name'] }}
                          <span class="count">({{ $catePostCount[$item['id']] ?? 0 }})</span>
                        </a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="block special-product">
            <div class="sidebar-bar-title">
              <h3>{{ $parentCateName }}</h3>
            </div>
            <div class="block-content">
              <ul>
                @foreach($relatedProducts as $value)
                  @php
                      $relUrl = route('get.product.single', ['id'=>fencrypt($value['id']),'name'=>makeUnicode($value['title'])]);
                  @endphp
                  <li class="item">
                    <div class="products-block-left">
                      <a href="{{ $relUrl }}" title="{{ $value['title'] }}" class="product-image"><img src="{{ App\Models\Images::checkImageProduct($value['id']) }}" alt="{{ $value['title'] }}" loading="lazy" decoding="async"></a>
                    </div>
                    <div class="products-block-right">
                      <p class="product-name"><a href="{{ $relUrl }}">{{ $value['title'] }}</a></p>
                      <span class="price"></span>
                    </div>
                  </li>
                @endforeach
              </ul>
              <a class="link-all" href="{{ route('get.product.all') }}">Xem toàn bộ sản phẩm</a>
            </div>
          </div>

          <div class="block special-product">
            <div class="sidebar-bar-title">
              <h3>Báo giá &amp; Catalog</h3>
            </div>
            <div class="block-content">
              <ul>
                @foreach($sidebarDocs as $value)
                  <li class="item">
                    <p class="product-name">
                      <i class="fa fa-download" aria-hidden="true"></i>
                      <a target="_blank" rel="noopener" href="{{ $value['description'] }}">{{ $value['title'] }}</a>
                    </p>
                    <span class="price"></span>
                  </li>
                @endforeach
              </ul>
              <a class="link-all" href="{{ route('get.document.all') }}">Tất cả Báo giá &amp; Catalog</a>
            </div>
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
      <div class="tab-content">
        <div class="tab-pane active in">
          <div class="featured-pro">
            <div class="slider-items-products">
              <div class="product-flexslider hidden-buttons js-product-slider">
                <div class="slider-items slider-width-col4">
                  @foreach($otherProducts as $value)
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
  </div>
@endsection
