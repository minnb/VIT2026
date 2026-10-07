@extends('admin.layouts.master')

@section('title', 'Danh sách tin tức')

@section('content')
  @component('admin.partials.data_table', [
      'headers' => ['#', 'ID', 'Tiêu đề', 'Danh mục', 'Hình ảnh'],
      'paginator' => $data,
      'addUrl'  => route('get.admin.add.news'),
  ])
    @forelse($data as $key => $item)
      <tr>
        <td>{{ $data->firstItem() + $key }}</td>
        <td>{{ $item['id'] }}</td>
        <td>{{ $item['title'] }}</td>
        <td>{{ $cateNames[$item['categorieID']] ?? '' }}</td>
        <td><img class="img-thumbnail img-thumb" src="{{ getImage($images[$item['id']] ?? '') }}" loading="lazy" decoding="async" alt="{{ $item['title'] }}"></td>
        <td>
          <a href="{{ route('get.admin.edit.news', ['id' => $item['id']]) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
          @include('admin.partials.delete_button', ['url' => route('post.admin.delete.news', ['id' => $item['id']])])
        </td>
      </tr>
    @empty
      <tr><td colspan="6">Chưa có tin tức nào.</td></tr>
    @endforelse
  @endcomponent
@endsection
