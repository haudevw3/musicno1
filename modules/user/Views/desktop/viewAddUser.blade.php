@extends('layout.desktop-backend')

@push('scripts')
    <script src="{{ asset('js/user/manage-user.js?=').time() }}"></script>
@endpush

@section('content')
    @include('components.toast')
    
    <main id="page-body" class="page-body">
        @include('user::components.backend.form-add-user')
    </main>
@endsection