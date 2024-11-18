@extends('adm::layout')

@push('scripts')
    <script src="{{ asset('js/categories/manage-category.js?=').time() }}"></script>
@endpush

@section('page-header')
    <x-adm::page-header-title icon="layer-group" name="Quản lý danh mục"></x-adm::page-header-title>

    @include('adm::components.action-manage-category')
@endsection

@section('page-body')
    @include('adm::components.table-manage-category')
@endsection