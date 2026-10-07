@extends('admin.layouts.master')

@section('title', 'Danh mục sản phẩm')

@section('content')
  @component('admin.partials.data_table', [
      'headers' => ['#', 'Tên danh mục', 'Parent', 'Số bài viết', 'Ngày tạo'],
      'addUrl'  => route('get.admin.cate.add', ['parent' => 1]),
      'addLabel' => 'Thêm danh mục',
  ])
    @forelse($data as $key => $item)
      <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $item['name'] }} #{{ $item['id'] }}</td>
        <td>{{ $item['parent'] }}</td>
        <td>{{ $catePostCount[$item['id']] ?? 0 }}</td>
        <td>{{ $item['created_at'] }}</td>
        <td>
          <a href="{{ route('get.admin.cate.edit', ['id' => $item['id']]) }}"><i class="fa fa-fw fa-edit" aria-hidden="true"></i> Edit</a>
          @include('admin.partials.delete_button', ['url' => route('post.admin.cate.delete', ['id' => $item['id']])])
        </td>
      </tr>
    @empty
      <tr><td colspan="6">Chưa có danh mục nào.</td></tr>
    @endforelse
  @endcomponent
@endsection
