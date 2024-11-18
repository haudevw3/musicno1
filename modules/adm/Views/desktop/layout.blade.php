@extends('layout.desktop-backend')

@prepend('scripts')
    <script src="{{ asset('js/table.js?=').time() }}"></script>
@endprepend

@section('content')
    @include('components.toast')
    
    @include('components.dialog')

    <header id="page-header" class="page-header d-flex bg-white border-bottom">
        @yield('page-header')
    </header>
    
    <main id="page-body" class="page-body">
        @yield('page-body')
    </main>
@endsection