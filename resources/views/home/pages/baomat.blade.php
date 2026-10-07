@extends('home.layouts.master')

@section('title', $title ?? '')

@section('meta_description', seo_description($data ?? '', 160, 'Chính sách bảo mật thông tin khách hàng của CÔNG TY CỔ PHẦN VITDUCT.'))
@section('og_type', 'article')

@section('content')
  @include('home.partials.breadcrumbs', ['items' => [['label' => $title ?? '']]])

  <div class="main container">
    <div class="about-page">
      <div class="row">
        <div class="col-xs-12 col-sm-12">
          <div class="page-title">
            <h1>{{ $title ?? '' }}</h1>
          </div>
          {{-- HTML từ trình soạn thảo: in thô có chủ đích, seo_content() bổ sung lazy-load + alt cho ảnh --}}
          {!! seo_content($data ?? '', $title ?? '') !!}
        </div>
      </div>
    </div>
  </div>
@endsection
