<{{ $tag }} class="btn btn-datatable btn-icon btn-transparent-dark {{ $class }}" {{ ($tag == 'a') ? 'href='.$url : '' }}  {{ $extra }}>
    <x-core::fa-icon icon="{{ $icon }}"></x-core::fa-icon>
</{{ $tag }}>