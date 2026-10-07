@extends('admin.layouts.master')

@section('title', 'Thông tin công ty')

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
                  <th scope="col">Công ty</th>
                  <th scope="col">Địa chỉ</th>
                  <th scope="col">Email</th>
                  <th scope="col">Điện thoại</th>
                  <th scope="col">Fax</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                {{-- Dữ liệu do AngularJS render --}}
                @verbatim
                <tr ng-repeat="sv in dscom">
                  <td>{{ sv.id }}</td>
                  <td>{{ sv.name }}</td>
                  <td>{{ sv.address }}</td>
                  <td>{{ sv.email }}</td>
                  <td>{{ sv.phone }}</td>
                  <td>{{ sv.fax }}</td>
                  <td>
                    <a class="btn btn-primary btn-sm" ng-click="modal('edit',sv.id)"><i class="fa fa-fw fa-edit"></i> Edit</a>
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

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="companyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="companyModalLabel">@verbatim{{ frmTitle }}@endverbatim</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Đóng" ng-click="addHotline('exit')">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="frmEditCompany" name="frmEditCompany">
          {{ csrf_field() }}
          <div class="modal-body">
            <div class="form-group">
              <label for="com-name">Công ty | Nhà xưởng</label>
              <textarea id="com-name" class="form-control" placeholder="Công ty" required ng-model="hotline.name"></textarea>
            </div>
            <div class="form-group">
              <label for="com-address">Địa chỉ</label>
              <textarea id="com-address" class="form-control" placeholder="Địa chỉ" required ng-model="hotline.address"></textarea>
            </div>
            <div class="form-group">
              <label for="com-phone">Số điện thoại</label>
              <input id="com-phone" type="text" class="form-control" placeholder="Số điện thoại" required ng-model="hotline.phone">
            </div>
            <div class="form-group">
              <label for="com-fax">Số fax</label>
              <input id="com-fax" type="text" class="form-control" placeholder="Số fax" ng-model="hotline.fax">
            </div>
            <div class="form-group">
              <label for="com-email">Địa chỉ email</label>
              <input id="com-email" type="email" class="form-control" placeholder="Email" ng-model="hotline.email">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" ng-click="addHotline('exit')">Thoát</button>
            <button type="submit" class="btn btn-primary" ng-disabled="frmEditCompany.$invalid" ng-click="addHotline(state,id)">Lưu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('public/js/angular/controller/SettingController.js') }}"></script>
@endpush
