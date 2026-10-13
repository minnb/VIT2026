@extends('home.layouts.master')

@section('title', 'Giới thiệu năng lực và lịch sử hình thành')

@section('meta_description', 'Công ty Cổ phần VITDUCT - Hơn 20 năm chuyên sản xuất ống gió, van gió, cửa gió và thi công hệ thống cơ điện ME uy tín, chuyên nghiệp tại Việt Nam.')
@section('canonical', seo_canonical(route('get.about')))
@section('og_type', 'article')

@section('content')
  @include('home.partials.breadcrumbs', ['items' => [['label' => $title ?? 'Giới thiệu']]])

  <div class="main container">
    <div class="about-page">
      <div class="row">
        <div class="col-xs-12 col-sm-12">
          <div class="page-title">
            <h1>{{ $title ?? 'Thông tin giới thiệu công ty' }}</h1>
            <h2 class="sr-only">Lịch sử phát triển và năng lực sản xuất của VITDUCT</h2>
          </div>
          {{-- HTML từ trình soạn thảo: in thô có chủ đích, seo_content() bổ sung lazy-load + alt cho ảnh --}}
          {!! seo_content($data ?? '', $title ?? '') !!}
        </div>
      </div>
    </div>
  </div>
@endsection
