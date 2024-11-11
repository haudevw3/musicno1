@extends('layout.desktop-backend')

@push('scripts')
    <script src="{{ asset('js/table.js?=').time() }}"></script>
    <script src="{{ asset('js/user/manage-user.js?=').time() }}"></script>
@endpush

@section('content')
    @include('components.toast')
    @include('components.dialog')
    
    @include('adm::components.page-header-user')

    <main id="page-body" class="page-body">
        @include('adm::components.table-manage-user')
    </main>
@endsection