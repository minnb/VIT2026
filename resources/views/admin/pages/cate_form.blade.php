@extends('admin.layouts.master')

@section('title', $category ? 'Sửa danh mục' : 'Thêm danh mục')

@section('content')
  <div class="container-fluid backgroud_white">
    @include('admin.partials.flash_message')

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ $action }}" method="POST">
      {{ csrf_field() }}

      <div class="row backgroud_white">
        <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
          <div class="form-group">
            <label for="name">Tên danh mục</label>
            <input id="name" type="text" name="name" class="form-control"
                   value="{{ old('name', $category ? $category->name : '') }}" required maxlength="200">
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
          <div class="form-group">
            <label for="sort">Thứ tự hiển thị</label>
            <input id="sort" type="number" name="sort" class="form-control" min="0"
                   value="{{ old('sort', $category ? $category->sort : 0) }}">
          </div>
        </div>
      </div>

      <div class="row backgroud_white">
        <div class="col-md-12 col-lg-12">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-save" aria-hidden="true"></i> {{ $category ? 'Lưu thay đổi' : 'Thêm mới' }}
          </button>
        </div>
      </div>
    </form>
  </div>
@endsection
