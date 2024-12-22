@extends('adm::layout')

@push('scripts')
    <script src="{{ asset('js/album/manage-album.js?=').time() }}"></script>
@endpush

@section('page-header')
    <x-adm::page-header-title icon="album-collection" name="Quản lý album"></x-adm::page-header-title>

    @include('adm::components.action-manage-album')
@endsection

@section('page-body')
    @include('adm::components.table-manage-album')
@endsection