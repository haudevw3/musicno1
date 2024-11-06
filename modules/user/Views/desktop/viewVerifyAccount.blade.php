@extends('layout/desktop-frontend-none')

@push('scripts')
    <script src="{{ asset('js/user/verify-account.js?=').time() }}"></script>
@endpush

@section('content')
    @include('components.loading')
    @include('user::components.frontend.form-verify-account')
@endsection