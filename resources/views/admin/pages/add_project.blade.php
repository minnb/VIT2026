@extends('admin.layouts.master')

@section('title', 'Thêm dự án')

@section('content')
  <div class="container-fluid backgroud_white">
    <form name="frm-add-project" action="{{ route('post.admin.add.project') }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="row backgroud_white">
        <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
          <div class="form-group">
            <label for="name">Tên dự án</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
          </div>
          <div class="form-group">
            <label for="content">Chi tiết</label>
            <textarea id="content" name="content" class="form-control" rows="30" required>{{ old('content') }}</textarea>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
          <div class="form-group">
            <label for="cate_id">Danh mục</label>
            <select id="cate_id" class="form-control" name="cate_id">
              {!! menuMulti($categories, 2, "--", old('cate_id', 0)) !!}
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
