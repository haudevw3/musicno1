<div id="form-save-artist" class="card shadow mt-20 col-8" data-artist-id="{{ isset($artist) ? $artist->_id : '' }}">
    <div class="card-header fw-semibold">Thêm nghệ sĩ</div>

    <div class="card-body">
        <div class="form-content p-20">
            @include('components.alert')

            <div class="mb-3">
                <x-core::input-group-feedback id="name" label="Tên nghệ sĩ" icon="pen" type="text"
                name="name" placeholder="Nhập tên nghệ sĩ" value="{{ isset($artist) ? $artist->name : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <x-core::input-group-feedback id="slug" label="Tên đường dẫn" icon="link" type="text"
                name="slug" placeholder="Nhập tên đường dẫn" value="{{ isset($artist) ? $artist->slug : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <x-core::input-group-feedback id="image" class="ofm" label="Ảnh đại diện:" icon="camera" type="text"
                name="image" placeholder="Nhấn vào đây để chọn ảnh" value="{{ isset($artist) ? $artist->image : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-0 items-align-vertical-center-end">
                <x-core::button id="btn-save-artist" class="btn-primary" name="{{ isset($artist) ? 'Cập nhật nghệ sĩ' : 'Tạo nghệ sĩ' }}"></x-core::button>
            </div>
        </div>
    </div>
</div>