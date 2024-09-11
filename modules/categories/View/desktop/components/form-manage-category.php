<div id="form-manage-category" class="form-container bg-white rounded shadow"
    data-id="<?php echo isset($category) ? $category['id'] : 0 ?>"
    data-url="<?php echo isset($category) ? route('adm-update-category', $category['id']) : route('adm-create-category') ?>">

    <div class="form-header vertical-center-align-items fs-16 fw-semibold text-blue p-20 rounded-top">
        <?php echo $title ?>
    </div>

    <div class="form-wrapper p-20">
        <div class="form-content rounded p-20">
            <div id="name" class="mb-3">
                <label>Tên danh mục:</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-pen"></i>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên danh mục..."
                        value="<?php echo isset($category) ? $category['name'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>
        
            <div id="slug" class="mb-3">
                <label>Đường dẫn hiển thị:</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-link"></i>
                    <input type="text" name="slug" class="form-control" placeholder="Tự thay đổi theo tên danh mục..."
                        value="<?php echo isset($category) ? $category['slug'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="priority" class="mb-3">
                <label>Độ ưu tiên danh mục:</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-flag"></i>
                    <input type="number" name="priority" class="form-control" placeholder="Nhập độ ưu tiên danh mục..."
                        value="<?php echo isset($category) ? $category['priority'] : 0 ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="type" class="mb-3">
                <label>Chọn loại danh mục:</label>
                <select name="type" class="form-control">
                    <?php
                        $type = isset($category) ? $category['type'] : 0;
                        foreach (config('categories.types') as $key => $value) {
                            ?>
                                <option value="<?php echo $key ?>" <?php echo ($key == $type) ? 'selected' : null ?>>
                                    <?php echo $value ?>
                                </option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div id="parent_id" class="mb-3">
                <label>Chọn danh mục phụ thuộc:</label>
                <select name="parent_id" class="form-control">
                    <?php
                        $parentId = isset($category) ? $category['parent_id'] : 0;
                        foreach ($parents as $key => $parent) {
                            ?>
                                <option value="<?php echo $parent['id'] ?>" <?php echo ($parentId == $parent['id']) ? 'selected' : null ?>>
                                    <?php echo $parent['name'] ?>
                                </option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div id="image" class="mb-3">
                <label>Hình ảnh: ( chỉ chấp nhận các tập tin có đuôi jpg, jpeg, png - được bỏ trống )</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-camera"></i>
                    <input type="text" name="image" class="form-control ofm" placeholder="Nhấn vào đây để chọn hình ảnh..."
                        value="<?php echo isset($category) ? $category['image'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="tags" class="mb-3">
                <label>Gắn thẻ cho danh mục:</label>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr);">
                    <?php
                        $tags = isset($category) ? explode(',', $category['tags']) : [];
                        foreach (config('categories.tags') as $key => $value) {
                            ?>
                                <div class="form-check">
                                    <input class="form-check-input" id="checkbox-<?php echo $key ?>" type="checkbox" name="tags[]"
                                        value="<?php echo $key ?>" <?php echo in_array($key, $tags) ? 'checked' : null ?>>
                                    <label class="form-check-label" for="checkbox-<?php echo $key ?>"><?php echo $value ?></label>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>

            <div class="mb-0 mt-20 d-flex justify-content-end">
                <button id="submit-form-category" class="btn btn-primary">
                    <?php echo isset($category) ? 'Cập nhật danh mục' : 'Tạo danh mục' ?>
                </button>
            </div>
        </div>
    </div>
</div>