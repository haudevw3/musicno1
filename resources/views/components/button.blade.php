<{{ $tag }} class="btn {{ $class }}" {{ ($tag == 'a') ? 'href='.$url : 'type='.$type }} {{ empty($id) ? '' : 'id='.$id }}>
    @if (empty($icon))
        {{ $name }}
    @else
        <x-core::fa-icon icon="{{ $icon }}"></x-core::fa-icon>
        <span class="ml-5">{{ $name }}</span>
    @endif
</{{ $tag }}>