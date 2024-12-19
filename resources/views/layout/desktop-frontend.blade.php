<!DOCTYPE html>
<html lang="vi">

@include('components.desktop.frontend.render-layout-head')

<body class="fe-theme">
    @include('components.desktop.frontend.topnav', ['isFrontend' => true])

    <div id="layout-content" class="layout-content d-flex">
        @include('components.desktop.frontend.sidenav')

        <div id="main-content" class="main-content">
            @yield('content')
        </div>
    </div>

    @include('components.desktop.frontend.footer')
    @include('components.desktop.frontend.render-layout-js')
</body>
</html>