<div class="d-flex">
    <div class="form-container box-shadow-01 rounded-6 bg-color-white">
        <div class="form-top">
            <div class="box-text bg-color-white-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
            <div class="divider-01"></div>
        </div>
        <div class="form-body p-20">
            <form method="post" action="<?php echo isset($category) ? route('adm-update-category') : route('adm-create-category') ?>">
                <input class="d-none" name="<?php echo isset($category) ? 'id' : null ?>" value="<?php echo isset($category) ? $category['id'] : null ?>" />

                <div class="mb-3">
                    <label for="category-name" class="form-label fw-600">Tên danh mục:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-pen"></i>
                        <input id="category-name" type="text" name="name" class="form-control" placeholder="Nhập tên danh mục" value="<?php echo isset($category) ? $category['name'] : old('name') ?>" required>
                    </div>
                    <div class="form-text text-color-red"><?php echo error('name') ?></div>
                </div>

                <div class="mb-3">
                    <label for="priority" class="form-label fw-600">Độ ưu tiên: ( được bỏ trống )</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-flag"></i>
                        <input id="priority" type="number" name="priority" class="form-control" placeholder="Nhập độ ưu tiên cho danh mục" value="<?php echo isset($category) ? $category['priority'] : old('priority') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('priority') ?></div>
                </div>

                <div class="mb-3">
                    <label for="display_limit" class="form-label fw-600">Chế độ hiển thị: ( được bỏ trống )</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-flag"></i>
                        <input id="display_limit" type="number" name="display_limit" class="form-control" placeholder="Nhập số mục muốn hiển thị" value="<?php echo isset($category) ? $category['display_limit'] : old('display_limit') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('display_limit') ?></div>
                </div>

                <div class="mb-3">
                    <label for="category-slug" class="form-label fw-600">Đường dẫn hiển thị:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-link"></i>
                        <input id="category-slug" type="text" name="slug" class="form-control" placeholder="Nhập đường dẫn hiển thị" value="<?php echo isset($category) ? $category['slug'] : old('slug') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('slug') ?></div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label fw-600">Ảnh đại diện: ( được bỏ trống )</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-camera"></i>
                        <input id="image" type="text" name="image" class="form-control" placeholder="Chọn ảnh đại diện" value="<?php echo isset($category) ? $category['image'] : old('image') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('image') ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-600">Chọn danh mục phụ:</label>
                    <div class="d-flex" style="display: grid; grid-template-columns: repeat(2, 1fr);">
                        <?php
                            $subs = [];
                            if (isset($category['sub_id'])) {
                                $subs = explode(',', $category['sub_id']);
                            }
                            if (! empty($categories)) {
                                foreach ($categories as $key => $cate) {
                                    if (isset($category['id']) && $cate['id'] == $category['id']) {
                                        continue;
                                    }
                                    ?>
                                        <div class="col-6">
                                            <div class="form-check form-check-01">
                                                <input class="form-check-input" id="check-box-<?php echo $key ?>" type="checkbox" name="subs[]" value="<?php echo $cate['id'] ?>" <?php echo in_array($cate['id'], $subs) ? 'checked' : null ?>>
                                                <label class="form-check-label fw-600" for="check-box-<?php echo $key ?>"><?php echo $cate['name'] ?></label>
                                            </div>
                                        </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>

                <div class="form-bottom mt-20 col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-md-01 bg-color-blue-01"><?php echo isset($category) ? 'Cập nhật danh mục' : 'Tạo danh mục' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>