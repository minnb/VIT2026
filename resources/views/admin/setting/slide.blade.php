@extends('admin.layouts.master')

@section('title', 'Hình ảnh slide')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card mb-3">
        <div class="card-body">
          <form action="{{ route('post.admin.setting.slide.list') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="slide-image">File hình ảnh</label>
              <input id="slide-image" class="form-control" type="file" name="fileImage[]">
              <br>
              <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Upload</button>
            </div>
          </form>
        </div>
      </div><!-- end card-->
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card mb-3">
        <div class="card-body">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-hover display">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Hình ảnh</th>
                  <th scope="col">Diễn giải</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data as $item)
                  <tr>
                    <td>{{ $item['id'] }}</td>
                    <td><img src="{{ asset($item['image']) }}" style="max-height: 120px;" alt="Slide {{ $item['id'] }}"></td>
                    <td>{{ $item['description'] }}</td>
                    <td>
                      @include('admin.partials.delete_button', ['url' => route('post.admin.setting.slide.delete', ['id' => $item['id']])])
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="4">Chưa có hình slide nào.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div><!-- end card-->
    </div>
  </div>
@endsection
