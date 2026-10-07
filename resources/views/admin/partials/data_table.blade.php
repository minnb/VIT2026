{{--
  Khung bảng dữ liệu dùng chung cho các trang danh sách.
  Biến: $headers (array), $addUrl (string|null), $addLabel (string|null),
         $paginator (LengthAwarePaginator|null) để hiện phân trang
  Nội dung <tbody> truyền qua slot $slot khi dùng @component,
  hoặc dùng trực tiếp khối markup trong trang.
--}}
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-hover display">
                        <thead>
                            <tr>
                                @foreach($headers as $header)
                                    <th scope="col">{{ $header }}</th>
                                @endforeach
                                <th scope="col">
                                    @if(!empty($addUrl))
                                        <a class="btn btn-danger" href="{{ $addUrl }}"><i class="fa fa-fw fa-plus"></i> {{ $addLabel ?? 'Thêm mới' }}</a>
                                    @else
                                        Action
                                    @endif
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {{ $slot }}
                        </tbody>
                    </table>
                </div>

                @if(!empty($paginator) && method_exists($paginator, 'links') && $paginator->hasPages())
                    <nav aria-label="Phan trang danh sach">
                        {!! $paginator->links() !!}
                    </nav>
                @endif
            </div>
        </div><!-- end card-->
    </div>
</div>
