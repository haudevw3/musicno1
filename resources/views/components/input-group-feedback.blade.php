<label>{{ $label }}</label>
<div id="{{ $id }}" class="input-group-validation">
    <x-core::fa-icon icon="{{ $icon }}"></x-core::fa-icon>
    <x-core::input class="{{ $class }}" type="{{ $type }}" name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ $value }}"></x-core::input>
    <span class="invalid-feedback"></span>
</div>