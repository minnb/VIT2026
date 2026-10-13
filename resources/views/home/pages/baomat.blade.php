@extends('home.layouts.master')

@section('title', 'Chính sách bảo mật thông tin khách hàng')

@section('meta_description', 'Chính sách bảo mật thông tin khách hàng tại VITDUCT: cam kết bảo vệ an toàn tuyệt đối dữ liệu cá nhân và thông tin doanh nghiệp theo quy định pháp luật.')
@section('canonical', seo_canonical(route('get.baomat')))
@section('og_type', 'article')

@section('content')
  @include('home.partials.breadcrumbs', ['items' => [['label' => $title ?? 'Chính sách bảo mật']]])

  <div class="main container">
    <div class="about-page">
      <div class="row">
        <div class="col-xs-12 col-sm-12">
          <div class="page-title">
            <h1>{{ $title ?? 'Chính sách bảo mật' }}</h1>
            <h2 class="sr-only">Cam kết bảo mật dữ liệu và thông tin khách hàng</h2>
          </div>
          {{-- HTML từ trình soạn thảo: in thô có chủ đích, seo_content() bổ sung lazy-load + alt cho ảnh --}}
          {!! seo_content($data ?? '', $title ?? '') !!}
        </div>
      </div>
    </div>
  </div>
@endsection
