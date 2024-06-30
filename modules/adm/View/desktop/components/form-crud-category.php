<div class="d-flex">
    <div class="form-container box-shadow-01 rounded-6 bg-color-white">
        <div class="form-top">
            <div class="box-text bg-color-white-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
            <div class="divider-01"></div>
        </div>
        <div class="form-body p-20">
            <form method="post" action="<?php echo isset($category) ? route('adm-update-category') : route('adm-create-category') ?>" enctype="multipart/form-data">
                <input class="d-none" type="text" name="<?php echo isset($category) ? 'id' : null ?>" value="<?php echo isset($category) ? $category['id'] : null ?>" />
                <input class="d-none" type="text" name="<?php echo isset($category) ? 'image_url' : null ?>" value="<?php echo isset($category) ? $category['image'] : null ?>" />

                <div class="mb-3">
                    <label for="name" class="form-label fw-600">Tên danh mục:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-pen"></i>
                        <input id="name" type="text" name="name" class="form-control need-convert-to-slug" placeholder="Nhập tên danh mục" value="<?php echo isset($category) ? $category['name'] : old('name') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('name') ?></div>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-600">Đường dẫn hiển thị:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-link"></i>
                        <input id="slug" type="text" name="slug" class="form-control converted-slug" placeholder="Nhập đường dẫn hiển thị" value="<?php echo isset($category) ? $category['slug'] : old('slug') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('slug') ?></div>
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
                    <label for="file-upload" class="form-label fw-600">Ảnh danh mục: ( được bỏ trống )</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-camera"></i>
                        <input class="col-12 file-upload" id="file-upload" type="file" name="image">
                    </div>
                    <div class="form-text text-color-red"></div>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label fw-600">Tiêu đề danh mục: ( được bỏ trống )</label>
                    <textarea id="title" type="text" class="form-control" placeholder="Nhập nội dung tiêu đề"><?php echo isset($category) ? $category['title'] : old('title') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-600">Chọn danh để hiển thị: ( được bỏ trống )</label>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr);">
                        <?php
                            $tags = [];
                            if (isset($category['tags'])) {
                                $tags = explode(',', $category['tags']);
                            } else {
                                $tags = old('tags') ?? [];
                            }
                            if (! empty($categories)) {
                                foreach ($categories as $key => $cate) {
                                    if (isset($category['id']) && $cate['id'] == $category['id']) {
                                        continue;
                                    }
                                    ?>
                                        <div class="form-check form-check-01">
                                            <input class="form-check-input" id="check-box-<?php echo $key ?>" type="checkbox" name="tags[]" value="<?php echo $cate['id'] ?>" <?php echo in_array($cate['id'], $tags) ? 'checked' : null ?>>
                                            <label class="form-check-label fw-600" for="check-box-<?php echo $key ?>"><?php echo $cate['name'] ?></label>
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