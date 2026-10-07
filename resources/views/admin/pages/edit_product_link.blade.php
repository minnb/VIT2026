@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa sản phẩm liên kết')

@section('content')
  <div class="container-fluid backgroud_white">
    <form name="frm-edit-product-link" action="{{ route('post.admin.edit.product.link', ['id' => $post_id]) }}" method="POST" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="row backgroud_white">
        <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
          <div class="form-group">
            <label for="name">Thương hiệu</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $data['title'] ?? '') }}" required>
          </div>
          <div class="form-group">
            <label for="description">Tên sản phẩm</label>
            <input id="description" type="text" name="description" class="form-control" value="{{ old('description', $data['description'] ?? '') }}" required>
          </div>
          <div class="form-group">
            <label for="filer_example2">Upload hình ảnh</label>
            <input type="file" name="fileImage[]" id="filer_example2" multiple>
          </div>
          @foreach($images as $key => $item)
            <div class="form-group" id="{{ $key }}">
              <label>Hình sản phẩm</label><br>
              <img class="img-responsive dis-image-from-database-detail" src="{{ url('/') . '/' . $item->image }}" id="{{ $key }}" idHinh="{{ $item->id }}" alt="Hình sản phẩm">
              <a id="del-imge-detail" class="btn btn-danger icon-del" href="javascript:void(0)"><i class="fa fa-times"></i></a>
            </div>
          @endforeach
          <div class="form-group">
            <label for="content">Giới thiệu về sản phẩm</label>
            <textarea id="content" name="content" class="form-control" rows="30">{{ old('content', $data['content'] ?? '') }}</textarea>
          </div>
        </div>
      </div>
      <div class="row backgroud_white">
        <div class="col-md-12 col-lg-12">
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu chỉnh sửa</button>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  @include('admin.partials.form_scripts')
@endpush
