@extends('admin.layouts.master')

@section('title', 'Danh sách tài liệu')

@section('content')
  @component('admin.partials.data_table', [
      'headers' => ['#', 'Tên tài liệu', 'Danh mục', 'Link Google Drive'],
      'paginator' => $data,
      'addUrl'  => route('get.admin.add.document'),
  ])
    @forelse($data as $key => $item)
      <tr>
        <td>{{ $data->firstItem() + $key }}</td>
        <td>{{ $item['title'] }}</td>
        <td>{{ $cateNames[$item['categorieID']] ?? '' }}</td>
        <td><a target="_blank" rel="noopener" href="{{ $item['description'] }}"><i class="fa fa-low-vision bigfonts"></i> Xem</a></td>
        <td>
          <a href="{{ route('get.admin.edit.document', ['id' => $item['id']]) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
          @include('admin.partials.delete_button', ['url' => route('post.admin.delete.document', ['id' => $item['id']])])
        </td>
      </tr>
    @empty
      <tr><td colspan="5">Chưa có tài liệu nào.</td></tr>
    @endforelse
  @endcomponent
@endsection
