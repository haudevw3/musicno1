<div id="form-save-album" class="card shadow mt-20 col-8" data-album-id="{{ isset($album) ? $album->_id : '' }}">
    <div class="card-header fw-semibold">Thêm album</div>

    <div class="card-body">
        <div class="form-content p-20">
            @include('components.alert')

            <div class="mb-3">
                <x-core::input-group-feedback id="name" label="Tên album" icon="pen" type="text"
                name="name" placeholder="Nhập tên album" value="{{ isset($album) ? $album->name : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <x-core::input-group-feedback id="slug" label="Tên đường dẫn" icon="link" type="text"
                name="slug" placeholder="Nhập tên đường dẫn" value="{{ isset($album) ? $album->slug : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <x-core::input-group-feedback id="image" class="ofm" label="Ảnh đại diện" icon="camera" type="text"
                name="image" placeholder="Nhấn vào đây để chọn ảnh" value="{{ isset($album) ? $album->image : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <x-core::input-group-feedback id="release_year" label="Năm phát hành" icon="calendar" type="text"
                name="release_year" placeholder="Nhập năm phát hành" value="{{ isset($album) ? $album->release_year : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <label>Chọn loại album</label>
                <select class="form-control" name="album_type">
                    @foreach (config('album.album_types') as $albumType)
                        <option value="{{ $albumType }}" {{ isset($album) && ($albumType == $album->album_type) ? 'selected' : '' }}>{{ ucfirst($albumType) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Nghệ sĩ</label>
                <div id="text-editor" class="text-editor form-control" name="text-editor" contenteditable="true" text-content="Gõ @ và từ khóa hoặc tên nghệ sĩ cần tìm..."></div>
                <div id="mention-box" class="dropdown-menu shadow animated-fade-in-up col-12 scroll-bar position-relative"></div>
            </div>

            <div class="mb-0 items-align-vertical-center-end">
                <x-core::button id="btn-save-album" class="btn-primary" name="{{ isset($album) ? 'Cập nhật album' : 'Tạo album' }}"></x-core::button>
            </div>
        </div>
    </div>
</div>