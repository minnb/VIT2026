@extends('admin.layouts.master')

@section('title', 'Danh sách sản phẩm')

@section('content')
  @component('admin.partials.data_table', [
      'headers'  => ['#', 'ID', 'Tên sản phẩm', 'Danh mục', 'Giá', 'Hình ảnh'],
      'paginator' => $data,
      'addUrl'   => route('get.admin.add.product'),
  ])
    @forelse($data as $key => $item)
      <tr>
        <td>{{ $data->firstItem() + $key }}</td>
        <td>{{ $item['id'] }}</td>
        <td>{{ $item['title'] }}</td>
        <td>{{ $cateNames[$item['categorieID']] ?? '' }}</td>
        <td>{{ $item['price'] }}</td>
        <td><img class="img-thumbnail img-thumb" src="{{ getImage($images[$item['id']] ?? '') }}" loading="lazy" decoding="async" alt="{{ $item['title'] }}"></td>
        <td>
          <a href="{{ route('get.admin.edit.product', ['id' => $item['id']]) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
          @include('admin.partials.delete_button', ['url' => route('post.admin.delete.product', ['id' => $item['id']])])
        </td>
      </tr>
    @empty
      <tr><td colspan="7">Chưa có sản phẩm nào.</td></tr>
    @endforelse
  @endcomponent
@endsection
