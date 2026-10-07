{{-- Layout tổng khu quản trị. Kế thừa: @extends('admin.layouts.master') --}}
<!DOCTYPE html>
<html lang="vi" ng-app="app-VIT">
@include('admin.partials.head')
<body class="adminbody">
<div id="main">
    @include('admin.partials.headerbar')
    @include('admin.partials.sidebar')

    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                @include('admin.partials.page_title', [
                    'title'  => $pageTitle ?? '',
                    'parent' => $pageParent ?? 'Dashboard',
                ])
                @include('admin.partials.flash_message')

                @yield('content')
            </div><!-- END container-fluid -->
        </div><!-- END content -->
    </div><!-- END content-page -->

    @include('admin.partials.footer')
</div>
@include('admin.partials.scripts')
@stack('scripts')
</body>
</html>
