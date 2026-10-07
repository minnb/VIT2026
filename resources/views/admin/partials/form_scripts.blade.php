{{-- Script khởi tạo CKEditor + jQuery.filer cho các form thêm/sửa --}}
<script type="text/javascript">
    $(document).ready(function () {
        'use strict';
        if ($.fn.filer) {
            $('#filer_example2').filer({
                limit: 3,
                maxSize: 3,
                extensions: ['jpg', 'jpeg', 'png', 'gif', 'psd'],
                changeInput: true,
                showThumbs: true,
                addMore: true
            });
        }
        if (typeof ckeditor === 'function') {
            ckeditor('content');
        }
        if ($.fn.wysihtml5) {
            $('.textarea').wysihtml5();
        }
    });
</script>
