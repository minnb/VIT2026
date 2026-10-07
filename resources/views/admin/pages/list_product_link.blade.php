@extends('admin.layouts.master')

@section('title', 'Danh sách sản phẩm liên kết')

@section('content')
  @component('admin.partials.data_table', [
      'headers' => ['#', 'ID', 'Thương hiệu', 'Tên sản phẩm', 'Ảnh'],
      'paginator' => $data,
      'addUrl'  => route('get.admin.add.product.link'),
  ])
    @forelse($data as $key => $item)
      <tr>
        <td>{{ $data->firstItem() + $key }}</td>
        <td>{{ $item['id'] }}</td>
        <td>{{ $item['title'] }}</td>
        <td>{{ $item['description'] }}</td>
        <td><img class="img-thumbnail img-thumb" src="{{ getImage($images[$item['id']] ?? '') }}" loading="lazy" decoding="async" alt="{{ $item['title'] }}"></td>
        <td>
          <a href="{{ route('get.admin.edit.product.link', ['id' => $item['id']]) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
          @include('admin.partials.delete_button', ['url' => route('post.admin.delete.product.link', ['id' => $item['id']])])
        </td>
      </tr>
    @empty
      <tr><td colspan="6">Chưa có sản phẩm liên kết nào.</td></tr>
    @endforelse
  @endcomponent
@endsection
