@extends('admin.layouts.master')

@section('title', 'Cài đặt Hotline')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card mb-3">
        <div class="card-body">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-hover display">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Liên hệ</th>
                  <th scope="col">Số điện thoại</th>
                  <th scope="col">Email</th>
                  <th scope="col">Trạng thái</th>
                  <th scope="col">
                    <button class="btn btn-info btn-sm" ng-click="modal('add')"><i class="fa fa-plus-square-o bigfonts"></i> Thêm mới</button>
                  </th>
                </tr>
              </thead>
              <tbody>
                {{-- Dữ liệu do AngularJS render, bọc verbatim để Blade bỏ qua cú pháp nội suy của Angular --}}
                @verbatim
                <tr ng-repeat="sv in dsphone">
                  <td>{{ sv.id }}</td>
                  <td>{{ sv.name }}</td>
                  <td>{{ sv.phone }}</td>
                  <td>{{ sv.email }}</td>
                  <td>{{ sv.status }}</td>
                  <td>
                    <a class="btn btn-primary btn-sm" ng-click="modal('edit',sv.id)"><i class="fa fa-fw fa-edit"></i> Edit</a>
                    <a class="btn btn-danger btn-sm" ng-click="confirmDelete(sv.id)"><i class="fa fa-fw fa-trash"></i> Delete</a>
                  </td>
                </tr>
                @endverbatim
              </tbody>
            </table>
          </div>
        </div>
      </div><!-- end card-->
    </div>
  </div>

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="hotlineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="hotlineModalLabel">@verbatim{{ frmTitle }}@endverbatim</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Đóng" ng-click="addHotline('exit')">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frmAddHotline" name="frmAddHotline">
          {{ csrf_field() }}
          <div class="modal-body">
            <div class="form-group">
              <label for="hotline-name">Họ tên</label>
              <input id="hotline-name" type="text" class="form-control" placeholder="Họ tên" required ng-model="hotline.name">
            </div>
            <div class="form-group">
              <label for="hotline-phone">Số điện thoại</label>
              <input id="hotline-phone" type="text" class="form-control" placeholder="Số điện thoại" required ng-model="hotline.phone">
            </div>
            <div class="form-group">
              <label for="hotline-email">Địa chỉ email</label>
              <input id="hotline-email" type="email" class="form-control" placeholder="Email" ng-model="hotline.email">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" ng-click="addHotline('exit')">Thoát</button>
            <button type="submit" class="btn btn-primary" ng-disabled="frmAddHotline.$invalid" ng-click="addHotline(state,id)">Lưu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/angular/controller/SettingController.js') }}"></script>
@endpush
