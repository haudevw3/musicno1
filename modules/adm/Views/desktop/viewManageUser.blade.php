@extends('adm::layout')

@push('scripts')
    <script src="{{ asset('js/user/manage-user.js?=').time() }}"></script>
@endpush

@section('page-header')
    <x-adm::page-header-title icon="user" name="Quản lý người dùng"></x-adm::page-header-title>

    @include('adm::components.action-manage-user')
@endsection

@section('page-body')
    @include('adm::components.table-manage-user')
@endsection