@extends('admin.layouts.master')

@section('title', 'Thêm tài liệu')

@section('content')
  <div class="container-fluid backgroud_white">
    <form name="frm-add-document" action="{{ route('post.admin.add.document') }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="row backgroud_white">
        <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
          <div class="form-group">
            <label for="name">Tên tài liệu</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
          </div>
          <div class="form-group">
            <label for="cate_id">Danh mục</label>
            <select id="cate_id" class="form-control" name="cate_id">
              {!! menuMulti($categories, 11, "--", old('cate_id', 0)) !!}
            </select>
          </div>
          <div class="form-group">
            <label for="description">Link Google Drive</label>
            <input id="description" type="text" name="description" class="form-control" value="{{ old('description') }}" required>
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
