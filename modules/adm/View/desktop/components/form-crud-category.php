<div class="d-flex">
    <div class="form-container box-shadow-01 rounded-6 bg-color-white">
        <div class="form-top">
            <div class="box-text bg-color-white-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo isset($title) ? $title : null ?></div>
            <div class="divider-01"></div>
        </div>
        <div class="form-body p-20">
            <form method="post" action="<?php echo isset($category) ? route('adm-update-category') : route('adm-create-category') ?>">
            <input class="d-none" name="<?php echo isset($category) ? 'id' : null ?>" value="<?php echo isset($category) ? $category['id'] : null ?>" />
                <div class="form-group mb-3 d-flex">
                    <div class="col-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Tên danh mục:</span></div>
                    <div class="col-9 position-relative">
                        <i class="icon-md-02 fa-regular fa-pen"></i>
                        <input id="category-name" type="text" name="name" class="form-control input-md-02" placeholder="Nhập tên danh mục" value="<?php echo isset($category) ? $category['name'] : old('name') ?>" required>
                        <div class="invalid-feedback d-block"><?php echo error('name') ?></div>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <div class="col-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Độ ưu tiên:</span></div>
                    <div class="col-9 position-relative">
                        <i class="icon-md-02 fa-regular fa-flag"></i>
                        <input type="number" name="priority" class="form-control input-md-02" placeholder="Nhập độ ưu tiên cho danh mục" value="<?php echo isset($category) ? $category['priority'] : old('priority') ?>">
                        <div class="invalid-feedback d-block"><?php echo error('priority') ?></div>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <div class="col-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Chế độ hiển thị:</span></div>
                    <div class="col-9 position-relative">
                        <i class="icon-md-02 fa-regular fa-browser"></i>
                        <input type="number" name="display_limit" class="form-control input-md-02" placeholder="Nhập số mục muốn hiển thị" value="<?php echo isset($category) ? $category['display_limit'] : old('display_limit') ?>">
                        <div class="invalid-feedback d-block"><?php echo error('display_limit') ?></div>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <div class="col-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Đường dẫn hiển thị:</span></div>
                    <div class="col-9 position-relative">
                        <i class="icon-md-02 fa-regular fa-link"></i>
                        <input id="category-slug" type="text" name="slug" class="form-control input-md-02" placeholder="Nhập đường dẫn hiển thị" value="<?php echo isset($category) ? $category['slug'] : old('slug') ?>">
                        <div class="invalid-feedback d-block"><?php echo error('slug') ?></div>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <div class="col-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Ảnh đại diện:</span></div>
                    <div class="col-9 position-relative">
                        <i class="icon-md-02 fa-regular fa-camera"></i>
                        <input type="text" name="image" class="form-control input-md-02" placeholder="Chọn ảnh đại diện">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class=" mb-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Chọn danh mục phụ:</span></div>
                    <div class="col-12 position-relative" style="display: grid; grid-template-columns: repeat(2, 1fr);">
                        <?php
                            $subs = [];
                            if (isset($category['sub_id'])) {
                                $subs = explode(',', $category['sub_id']);
                            }
                            foreach ($categories as $key => $cate) {
                                if (isset($category['id']) && $cate['id'] == $category['id']) {
                                    continue;
                                }
                                ?>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input cursor-pointer" id="check-box-<?php echo $key ?>" type="checkbox" name="subs[]" value="<?php echo $cate['id'] ?>" <?php echo in_array($cate['id'], $subs) ? 'checked' : null ?>>
                                            <label class="form-check-label cursor-pointer" for="check-box-<?php echo $key ?>"><?php echo $cate['name'] ?></label>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="form-bottom col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-md-02 bg-color-blue-01"><?php echo isset($category) ? 'Cập nhật danh mục' : 'Tạo danh mục' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>