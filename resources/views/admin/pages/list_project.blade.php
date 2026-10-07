@extends('admin.layouts.master')

@section('title', 'Danh sách dự án')

@section('content')
  @component('admin.partials.data_table', [
      'headers' => ['#', 'Dự án', 'Diễn giải', 'Hình ảnh'],
      'paginator' => $data,
      'addUrl'  => route('get.admin.add.project'),
  ])
    @forelse($data as $key => $item)
      <tr>
        <td>{{ $data->firstItem() + $key }}</td>
        <td>{{ $item['title'] }}</td>
        <td>{{ $cateNames[$item['categorieID']] ?? '' }}</td>
        <td><img class="img-thumbnail img-thumb" src="{{ getImage($images[$item['id']] ?? '') }}" loading="lazy" decoding="async" alt="{{ $item['title'] }}"></td>
        <td>
          <a href="{{ route('get.admin.edit.project', ['id' => $item['id']]) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
          @include('admin.partials.delete_button', ['url' => route('post.admin.delete.project', ['id' => $item['id']])])
        </td>
      </tr>
    @empty
      <tr><td colspan="5">Chưa có dự án nào.</td></tr>
    @endforelse
  @endcomponent
@endsection
