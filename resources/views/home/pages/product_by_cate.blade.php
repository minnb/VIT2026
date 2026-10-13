@extends('home.layouts.master')

@section('title', ($cate_name ?? 'Sản phẩm') . ' - Báo giá & Tiêu chuẩn kỹ thuật' . ((int) request('page') > 1 ? ' - Trang ' . (int) request('page') : ''))

@section('meta_description', 'Sản xuất và cung cấp ' . mb_strtolower($cate_name ?? 'sản phẩm', 'UTF-8') . ' tiêu chuẩn ISO/PCCC, đa dạng quy cách, giá tại xưởng. Nhận gia công theo yêu cầu, giao hàng toàn quốc.')

{{-- Canonical dựng lại từ slug chuẩn: route /{id}/{title} không kiểm tra {title} nên mọi slug sai đều trả cùng nội dung --}}
@section('canonical', seo_canonical(route('get.product.cate', ['id' => fencrypt($id), 'name' => makeUnicode($cate_name)]))
    . ((int) request('page') > 1 ? '?page=' . (int) request('page') : ''))

@section('content')
  @include('home.partials.breadcrumbs', ['items' => [
      ['label' => 'Sản phẩm', 'url' => route('get.product.all')],
      ['label' => $cate_name ?? ''],
  ]])

  @php
    // Structured Data: danh sach san pham hien tren trang (ItemList)
    $listItems = [];
    foreach ($data as $listValue) {
        $listItems[] = [
            'name' => $listValue['title'],
            'url'  => route('get.product.single', [
                'id'   => fencrypt($listValue['id']),
                'name' => makeUnicode($listValue['title']),
            ]),
        ];
    }
  @endphp
  @include('home.partials.itemlist_jsonld', [
    'listName'   => $cate_name ?? 'Sản phẩm',
    'listItems'  => $listItems,
    'listOffset' => method_exists($data, 'firstItem') ? ($data->firstItem() ?: 1) : 1,
  ])


  <div class="main-container col1-layout">
    <div class="container">
      <div class="row">
        <div class="col-main col-sm-12 col-xs-12">
          <div class="shop-inner">
            <div class="product-grid-area">
              <div class="page-title">
                <h1>{{ $cate_name ?? '' }}</h1>
                <h2 class="sr-only">Danh sách {{ $cate_name ?? 'sản phẩm' }} do VITDUCT sản xuất</h2>
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
                  <li class="item col-xs-12"><p>Chưa có sản phẩm nào trong danh mục này.</p></li>
                @endforelse
              </ul>
            </div>
            <div class="pagination-area">
              {{ $data->onEachSide(2)->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
