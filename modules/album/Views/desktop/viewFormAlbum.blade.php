@extends('layout.desktop-backend')

@push('scripts')
    <script src="{{ asset('js/table.js?=').time() }}"></script>
    <script src="{{ asset('js/text-editor.js?=').time() }}"></script>
    <script src="{{ asset('js/filemanager/file-manager.js?=').time() }}"></script>
    <script src="{{ asset('js/album/manage-album.js?=').time() }}"></script>
@endpush

@section('content')
    @include('components.toast')
    @include('components.file-manager')
    
    <main id="page-body" class="page-body">
        @include('album::components.backend.form-save-album')
    </main>
@endsection