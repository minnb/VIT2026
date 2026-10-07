@extends('admin.layouts.master')

@section('title', 'Giới thiệu công ty')

@section('content')
  <div class="container-fluid backgroud_white">
    <form name="frm-about" action="{{ route('post.admin.list.about') }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="row backgroud_white">
        <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
          <div class="form-group">
            <label for="content">Nội dung</label>
            <textarea id="content" name="content" class="form-control" rows="60" required>{{ old('content', $content ?? '') }}</textarea>
          </div>
        </div>
      </div>
      <div class="row backgroud_white">
        <div class="col-md-12 col-lg-12">
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu thông tin</button>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  @include('admin.partials.form_scripts')
@endpush
