{{-- Layout tổng cho khu vực public. Kế thừa: @extends('home.layouts.master') --}}
<!DOCTYPE html>
<html lang="vi">
@include('home.partials.head')
<body class="@yield('body_class')">
    <a class="sr-only sr-only-focusable" href="#main">Bỏ qua điều hướng, tới nội dung chính</a>

    @include('home.partials.nav')

    <main id="main">
        @yield('content')
    </main>

    @include('home.partials.service')
    @include('home.partials.footer')
</div>{{-- dong <div id="page"> da MO tai home/partials/nav.blade.php --}}

@include('home.partials.scripts')
@stack('scripts')
</body>
</html>
