<head>
    @include('components.render-base-head')
    <link rel="stylesheet" href="{{ asset('css/frontend/style.css?=').time() }}">
    @stack('css')
</head>