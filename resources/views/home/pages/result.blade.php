@extends('home.layouts.master')

@section('title', 'Kết quả tìm kiếm: ' . ($keyword ?? ''))

{{-- Trang kết quả tìm kiếm là nội dung mỏng, không cho index nhưng vẫn cho bot đi theo link --}}
@section('robots', 'noindex,follow')

@section('content')
  @include('home.partials.breadcrumbs', ['items' => [
      ['label' => 'Kết quả tìm kiếm'],
      ['label' => $keyword ?? ''],
  ]])

  <div class="main-container col1-layout">
    <div class="container">
      <div class="row">
        <div class="col-main col-sm-12 col-xs-12">
          <div class="shop-inner">
            <div class="product-grid-area">
              <div class="page-title">
                <h1>Kết quả tìm kiếm cho &ldquo;{{ $keyword }}&rdquo;</h1>
              </div>
              <ul class="products-grid">
                @forelse($data as $value)
                  <li class="item col-lg-3 col-md-4 col-sm-6 col-xs-6">
                    @include('home.partials.product_card', [
                        'item'       => $value,
                        'largeImage' => true,
                    ])
                  </li>
                @empty
                  <li class="item col-xs-12"><p>Không tìm thấy sản phẩm nào phù hợp với từ khoá &ldquo;{{ $keyword }}&rdquo;.</p></li>
                @endforelse
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
