@extends('home.layouts.master')

@section('title', 'Báo giá & Catalog sản phẩm ống gió, van gió')

@section('meta_description', 'Tải miễn phí bảng báo giá và tài liệu kỹ thuật catalog các sản phẩm ống gió, van gió, cửa gió, phụ kiện thông gió do VITDUCT sản xuất mới nhất.')

@section('canonical', seo_canonical(route('get.document.all')))

@push('styles')
<link rel="preconnect" href="https://cdn.datatables.net" crossorigin>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
@endpush

@section('content')
  @include('home.partials.breadcrumbs', ['items' => [['label' => 'Báo giá & Catalog sản phẩm']]])

  <section class="main-container col2-right-layout">
    <div class="main container">
      <div class="row">
        <div class="col-main col-sm-12 col-xs-12">
          <div class="my-account">
            <div class="page-title">
              <h1>Báo giá &amp; Catalog sản phẩm</h1>
              <h2 class="sr-only">Bảng danh mục tài liệu kỹ thuật và báo giá vật tư</h2>
            </div>
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-hover display">
                <thead>
                  <tr>
                    <th scope="col" style="width: 60px; text-align: center;">#</th>
                    <th scope="col">Tên tài liệu</th>
                    <th scope="col" style="width: 150px; text-align: center;">Tải file</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($data as $key => $item)
                    <tr>
                      <td style="text-align: center;">{{ $key + 1 }}</td>
                      <td><strong>{{ $item['title'] }}</strong></td>
                      <td style="text-align: center;">
                        <a class="btn-download-doc" target="_blank" rel="noopener" href="{{ $item['description'] }}">
                          <i class="fa fa-download" aria-hidden="true"></i> Tải về
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr><td colspan="3" class="text-center">Chưa có tài liệu nào.</td></tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    if ($.fn.DataTable) {
      $('#example1').DataTable({
        language: {
          search: "Tìm kiếm:",
          lengthMenu: "Hiển thị _MENU_ tài liệu",
          info: "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ tài liệu",
          infoEmpty: "Hiển thị 0 đến 0 trong 0 tài liệu",
          zeroRecords: "Không tìm thấy tài liệu phù hợp",
          paginate: {
            first: "Đầu",
            previous: "Trước",
            next: "Sau",
            last: "Cuối"
          }
        },
        pageLength: 25,
        ordering: false
      });
    }
  });
</script>
@endpush
