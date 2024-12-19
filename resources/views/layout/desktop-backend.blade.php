<!DOCTYPE html>
<html lang="vi">

@include('components.desktop.backend.render-layout-head')

<body class="be-theme">
    <div id="overlay" class="overlay"></div>

    @include('components.desktop.backend.topnav', ['isBackend' => true])

    <div id="layout-content" class="layout-content d-flex">
        @include('components.desktop.backend.sidenav')

        <div id="main-content" class="main-content">
            @yield('content')
        </div>
    </div>
    
    @include('components.desktop.backend.render-layout-js')
</body>
</html>