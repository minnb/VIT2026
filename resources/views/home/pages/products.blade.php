@extends('home.layouts.master')

@section('title', 'Sản phẩm ống gió, van gió, cửa gió' . ((int) request('page') > 1 ? ' - Trang ' . (int) request('page') : ''))

@section('meta_description', 'Danh mục sản phẩm VITDUCT: ống thông gió, van gió, cửa gió, phụ kiện và lò xo chống rung. Sản xuất quy chuẩn, báo giá cạnh tranh, giao hàng toàn quốc.')

@section('canonical', seo_canonical(route('get.product.all')) . ((int) request('page') > 1 ? '?page=' . (int) request('page') : ''))

@section('content')
  @include('home.partials.breadcrumbs', ['items' => [['label' => 'Sản phẩm']]])

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
    'listName'   => 'Sản phẩm',
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
                <h1>Sản phẩm</h1>
                <h2 class="sr-only">Toàn bộ danh mục sản phẩm ống gió & phụ kiện VITDUCT</h2>
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
                  <li class="item col-xs-12"><p>Chưa có sản phẩm nào.</p></li>
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
