@extends('layout.desktop-backend')

@push('scripts')
    <script src="{{ asset('js/table.js?=').time() }}"></script>
    <script src="{{ asset('js/filemanager/file-manager.js?=').time() }}"></script>
    <script src="{{ asset('js/categories/manage-category.js?=').time() }}"></script>
@endpush

@section('content')
    @include('components.toast')
    @include('components.file-manager')
    
    <main id="page-body" class="page-body">
        @include('categories::components.backend.form-add-category')
    </main>
@endsection