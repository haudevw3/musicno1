@extends('adm::layout')

@push('scripts')
    <script src="{{ asset('js/artist/manage-artist.js?=').time() }}"></script>
@endpush

@section('page-header')
    <x-adm::page-header-title icon="layer-group" name="Quản lý nghệ sĩ"></x-adm::page-header-title>

    @include('adm::components.action-manage-artist')
@endsection

@section('page-body')
    @include('adm::components.table-manage-artist')
@endsection