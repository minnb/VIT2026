@extends('home.layouts.master')

@section('title', 'Chính sách bảo hành & đổi trả sản phẩm')

@section('meta_description', 'Chính sách bảo hành và đổi trả sản phẩm tại VITDUCT: cam kết bảo hành chính hãng, tiêu chuẩn kỹ thuật nghiêm ngặt và quy trình hỗ trợ khách hàng nhanh chóng.')
@section('canonical', seo_canonical(route('get.baohanh')))
@section('og_type', 'article')

@section('content')
  @include('home.partials.breadcrumbs', ['items' => [['label' => $title ?? 'Chính sách đổi trả bảo hành']]])

  <div class="main container">
    <div class="about-page">
      <div class="row">
        <div class="col-xs-12 col-sm-12">
          <div class="page-title">
            <h1>{{ $title ?? 'Chính sách đổi trả bảo hành' }}</h1>
            <h2 class="sr-only">Quy định và điều kiện bảo hành đổi trả vật tư ống gió</h2>
          </div>
          {{-- HTML từ trình soạn thảo: in thô có chủ đích, seo_content() bổ sung lazy-load + alt cho ảnh --}}
          {!! seo_content($data ?? '', $title ?? '') !!}
        </div>
      </div>
    </div>
  </div>
@endsection
