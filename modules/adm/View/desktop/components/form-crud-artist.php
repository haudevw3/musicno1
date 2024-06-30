<div class="d-flex">
    <div class="form-container box-shadow-01 rounded-6 bg-color-white">
        <div class="form-top">
            <div class="box-text bg-color-white-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
            <div class="divider-01"></div>
        </div>
        <div class="form-body p-20">
            <form method="post" action="<?php echo isset($artist) ? route('adm-update-artist') : route('adm-create-artist') ?>" enctype="multipart/form-data">
                <input class="d-none" type="text" name="<?php echo isset($artist) ? 'id' : null ?>" value="<?php echo isset($artist) ? $artist['id'] : null ?>" />
                <input class="d-none" type="text" name="<?php echo isset($artist) ? 'image_url' : null ?>" value="<?php echo isset($artist) ? $artist['image'] : null ?>" />

                <div class="mb-3">
                    <label for="name" class="form-label fw-600">Tên nghệ sĩ:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-pen"></i>
                        <input id="name" type="text" name="name" class="form-control need-convert-to-slug" placeholder="Nhập tên nghệ sĩ" value="<?php echo isset($artist) ? $artist['name'] : old('name') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('name') ?></div>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-600">Đường dẫn hiển thị:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-link"></i>
                        <input id="slug" type="text" name="slug" class="form-control converted-slug" placeholder="Nhập đường dẫn hiển thị" value="<?php echo isset($artist) ? $artist['slug'] : old('slug') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('slug') ?></div>
                </div>

                <div class="mb-3">
                    <label for="file-upload" class="form-label fw-600">Ảnh nghệ sĩ: ( được bỏ trống )</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-camera"></i>
                        <input class="col-12 file-upload" id="file-upload" type="file" name="image">
                    </div>
                    <div class="form-text text-color-red"></div>
                </div>

                <div class="mb-3">
                    <label for="biography" class="form-label fw-600">Tiểu sử của nghệ sĩ: ( được bỏ trống )</label>
                    <textarea id="biography" type="text" class="form-control" placeholder="Nhập nội dung tiểu sử, mô tả"><?php echo isset($artist) ? $artist['biography'] : old('biography') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-600">Chọn danh mục để hiển thị: (được bỏ trống)</label>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr);">
                        <?php
                            $tags = [];
                            if (isset($artist['tags'])) {
                                $tags = explode(',', $artist['tags']);
                            } else {
                                $tags = old('tags') ?? [];
                            }
                            if (! empty($categories)) {
                                foreach ($categories as $key => $category) {
                                    ?>
                                        <div class="form-check form-check-01">
                                            <input class="form-check-input" id="check-box-<?php echo $key ?>" type="checkbox" name="tags[]" value="<?php echo $category['id'] ?>" <?php echo in_array($category['id'], $tags) ? 'checked' : null ?>>
                                            <label class="form-check-label fw-600" for="check-box-<?php echo $key ?>"><?php echo $category['name'] ?></label>
                                        </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>

                <div class="form-bottom mt-20 col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-md-01 bg-color-blue-01"><?php echo isset($artist) ? 'Cập nhật nghệ sĩ' : 'Tạo nghệ sĩ' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>