<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - VITDUCT</title>
    <meta name="description" content="Vitduct">
    <meta name="author" content="Vitduct">
    {{-- Khu quan tri: tuyet doi khong cho cong cu tim kiem lap chi muc --}}
    <meta name="robots" content="noindex,nofollow,noarchive">
    <link rel="icon" type="image/x-icon" href="{{ asset('public/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/assets/icons/favicon-32x32.png') }}">
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/plugins/jquery.filer/css/jquery.filer.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
    @stack('styles')
    <script type="text/javascript">
        var baseURL = "{{ url('/') }}";
    </script>
</head>
