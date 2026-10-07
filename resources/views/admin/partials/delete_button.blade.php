{{--
  Nút xoá dùng chung. Xoá phải đi bằng POST + CSRF: link GET có thể bị
  trình duyệt prefetch hoặc nhúng vào thẻ img để xoá dữ liệu từ xa.

  Biến: $url (bắt buộc), $label (tuỳ chọn), $confirm (tuỳ chọn)
--}}
<form action="{{ $url }}" method="POST" class="d-inline"
      onsubmit="return confirm('{{ $confirm ?? 'Bạn có chắc chắn muốn xoá?' }}');">
    {{ csrf_field() }}
    <button type="submit" class="btn btn-link p-0 align-baseline" style="color:red">
        <i class="fa fa-fw fa-trash" aria-hidden="true"></i> {{ $label ?? 'Delete' }}
    </button>
</form>
