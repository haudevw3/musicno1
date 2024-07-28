<div class="d-flex">
    <div class="form-container box-shadow-01 rounded-6 bg-color-white">
        <div class="form-top">
            <div class="box-text bg-color-white-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
            <div class="divider-01"></div>
        </div>
        <div class="form-body p-20">
            <form method="post" action="<?php echo isset($playlist) ? route('adm-update-playlist') : route('adm-create-playlist') ?>" enctype="multipart/form-data">
                <input name="<?php echo isset($playlist) ? 'id' : null ?>" type="text" class="d-none"
                       value="<?php echo isset($playlist) ? $playlist['id'] : null ?>" />

                <input name="<?php echo isset($playlist) ? 'image_url' : null ?>" type="text" class="d-none"
                       value="<?php echo isset($playlist) ? $playlist['image'] : null ?>" />

                <div class="mb-3">
                    <label for="name" class="form-label fw-600">Tên playlist:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-pen"></i>
                        <input name="name" type="text" id="name" class="form-control need-convert-to-slug" placeholder="Nhập tên playlist"
                               value="<?php echo isset($playlist) ? $playlist['name'] : old('name') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('name') ?></div>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-600">Đường dẫn hiển thị:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-link"></i>
                        <input name="slug" type="text" id="slug" class="form-control converted-slug" placeholder="Nhập đường dẫn hiển thị"
                               value="<?php echo isset($playlist) ? $playlist['slug'] : old('slug') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('slug') ?></div>
                </div>

                <div class="mb-3">
                    <label for="file-upload" class="form-label fw-600">Ảnh playlist:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-camera"></i>
                        <input name="image" type="file" class="col-12 file-upload" id="file-upload">
                    </div>
                    <div class="form-text text-color-red"></div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-600">Mô tả playlist: ( được bỏ trống )</label>
                    <textarea name="description" type="text" id="description" class="form-control" placeholder="Nhập nội dung giới thiệu, mô tả"><?php
                    echo isset($playlist) ? $playlist['description'] : old('description') ?></textarea>
                </div>

                <div class="form-bottom mt-20 col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-md-01 bg-color-blue-01"><?php echo isset($playlist) ? 'Cập nhật playlist' : 'Tạo playlist' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>