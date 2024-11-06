@extends('layout/desktop-frontend-none')

@push('scripts')
    <script src="{{ asset('js/user/forget-password.js?=').time() }}"></script>
@endpush

@section('content')
    @include('user::components.frontend.form-forget-password')
@endsection