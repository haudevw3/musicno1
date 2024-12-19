<!DOCTYPE html>
<html lang="vi">

@include('components.desktop.frontend.render-layout-head')

<body class="fe-theme">
    <div id="layout-content" class="layout-content">
        @yield('content')
    </div>

    @include('components.desktop.frontend.render-layout-js')
</body>
</html>