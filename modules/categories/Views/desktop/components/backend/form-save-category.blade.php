<div id="form-save-category" class="card shadow mt-20 col-8" data-category-id="{{ isset($category) ? $category->_id : '' }}">
    <div class="card-header fw-semibold">Thêm danh mục</div>

    <div class="card-body">
        <div class="form-content p-20">
            @include('components.alert')

            <div class="mb-3">
                <x-core::input-group-feedback id="name" label="Tên danh mục" icon="pen" type="text"
                name="name" placeholder="Nhập tên danh mục" value="{{ isset($category) ? $category->name : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <x-core::input-group-feedback id="slug" label="Tên đường dẫn" icon="link" type="text"
                name="slug" placeholder="Nhập tên đường dẫn" value="{{ isset($category) ? $category->slug : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <x-core::input-group-feedback id="priority" label="Độ ưu tiên danh mục" icon="arrow-down-wide-short" type="priority"
                name="priority" placeholder="Nhập độ ưu tiên danh mục" value="{{ isset($category) ? $category->priority : 0 }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <label>Chọn loại danh mục</label>
                <select class="form-control" name="tag_type">
                    @foreach (config('categories.tag_types') as $key => $typeName)
                        <option value="{{ $key }}" {{ isset($category) && ($key == $category->tag_type) ? 'selected' : '' }}>{{ $typeName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Chọn danh mục để hiển thị</label>
                <select class="form-control" name="parent_id">
                    <option value="">Không</option>

                    @if ($primaryCategories->isNotEmpty())
                        @foreach ($primaryCategories as $primaryCategory)
                            <option value="{{ $primaryCategory->_id }}" {{ isset($category) && $category->parent_id == $primaryCategory->_id ? 'selected' : '' }}>
                                {{ $primaryCategory->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="mb-3">
                <x-core::input-group-feedback id="images" class="ofm" label="Ảnh đại diện: (được bỏ trống)" icon="camera" type="text"
                name="images" placeholder="Nhấn vào đây để chọn ảnh"></x-core::input-group-feedback>
            </div>

            <div class="mb-0 items-align-vertical-center-end">
                <x-core::button id="btn-save-category" class="btn-primary" name="{{ isset($category) ? 'Cập nhật danh mục' : 'Tạo danh mục' }}"></x-core::button>
            </div>
        </div>
    </div>
</div>