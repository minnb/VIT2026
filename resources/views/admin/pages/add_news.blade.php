@extends('admin.layouts.master')

@section('title', 'Thêm tin tức')

@section('content')
  <div class="container-fluid backgroud_white">
    <form name="frm-add-news" action="{{ route('post.admin.add.news') }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="row backgroud_white">
        <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
          <div class="form-group">
            <label for="name">Tiêu đề</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
          </div>
          <div class="form-group">
            <label for="description">Tóm tắt</label>
            <textarea id="description" name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
          </div>
          <div class="form-group">
            <label for="content">Nội dung</label>
            <textarea id="content" name="content" class="form-control" rows="30" required>{{ old('content') }}</textarea>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
          <div class="form-group">
            <label for="cate_id">Danh mục</label>
            <select id="cate_id" class="form-control" name="cate_id">
              {!! menuMulti($categories, 3, "--", old('cate_id', 0)) !!}
            </select>
          </div>
          <div class="form-group">
            <label for="filer_example2">Upload hình ảnh</label>
            <input type="file" name="fileImage[]" id="filer_example2" multiple>
          </div>
        </div>
      </div>
      <div class="row backgroud_white">
        <div class="col-md-12 col-lg-12">
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Thêm mới</button>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  @include('admin.partials.form_scripts')
@endpush
