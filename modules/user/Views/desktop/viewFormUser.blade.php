@extends('layout.desktop-backend')

@push('scripts')
    <script src="{{ asset('js/table.js?=').time() }}"></script>
    <script src="{{ asset('js/user/manage-user.js?=').time() }}"></script>
    <script src="{{ asset('js/filemanager/file-manager.js?=').time() }}"></script>
@endpush

@section('content')
    @include('components.toast')
    @include('components.file-manager')
    
    <main id="page-body" class="page-body">
        @include('user::components.backend.form-save-user')
    </main>
@endsection