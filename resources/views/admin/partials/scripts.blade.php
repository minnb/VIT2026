<script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/detect.js') }}"></script>
<script src="{{ asset('assets/js/fastclick.js') }}"></script>
<script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('assets/js/pikeadmin.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('assets/plugins/func_ckfinder.js') }}"></script>
<script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/plugins/counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery.filer/js/jquery.filer.min.js') }}"></script>
<script src="{{ asset('js/angular/lib/angular.min.js') }}"></script>
<script src="{{ asset('js/angular/app.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
    $(document).ready(function () {
        if ($.fn.DataTable) {
            $('#example1').DataTable();
        }
        if ($.fn.counterUp) {
            $('.counter').counterUp({ delay: 10, time: 600 });
        }
        // Tự ẩn thông báo flash sau 5 giây
        window.setTimeout(function () {
            $("#flash-message").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 5000);
    });
</script>
