@extends('home.layouts.master')

@section('title', 'Dự án thi công cơ điện & hệ thống thông gió' . ((int) request('page') > 1 ? ' - Trang ' . (int) request('page') : ''))

@section('meta_description', 'Tổng hợp các dự án tiêu biểu VITDUCT đã thi công: hệ thống thông gió, điều hòa không khí và cơ điện ME cho các tòa nhà, khu đô thị và nhà máy công nghiệp.')

@section('canonical', seo_canonical(route('get.project.all')) . ((int) request('page') > 1 ? '?page=' . (int) request('page') : ''))

@section('content')
  @include('home.partials.breadcrumbs', ['items' => [['label' => 'Dự án tiêu biểu']]])

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
    'listName'   => 'Dự án tiêu biểu',
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
                <h1>Dự án tiêu biểu</h1>
                <h2 class="sr-only">Hạng mục công trình và dự án tiêu biểu VITDUCT đã thi công</h2>
              </div>
              <ul class="products-grid">
                @forelse($data as $value)
                  <li class="item col-lg-3 col-md-4 col-sm-6 col-xs-6">
                    @include('home.partials.product_card', [
                        'item'       => $value,
                        'largeImage' => true,
                        'imageSrc'   => getImageInContent($value['content']),
                    ])
                  </li>
                @empty
                  <li class="item col-xs-12"><p>Chưa có dự án nào.</p></li>
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
