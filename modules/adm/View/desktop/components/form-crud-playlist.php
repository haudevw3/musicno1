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
                    <label for="name" class="form-label fw-600">Tên danh sách phát:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-pen"></i>
                        <input name="name" type="text" id="name" class="form-control need-convert-to-slug" placeholder="Nhập tên danh sách phát"
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
                    <label for="file-upload" class="form-label fw-600">Ảnh danh sách phát:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-camera"></i>
                        <input name="image[]" type="file" class="col-12 file-upload" id="file-upload" multiple>
                    </div>
                    <div class="form-text text-color-red"></div>
                </div>

                <div class="mb-3">
                    <label for="priority" class="form-label fw-600">Độ ưu tiên cho danh sách phát:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-flag"></i>
                        <input name="priority" type="number" id="priority" class="form-control" placeholder="Nhập độ ưu tiên cho danh sách phát"
                               value="<?php echo isset($playlist) ? $playlist['priority'] : (old('priority') ?? 0) ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('priority') ?></div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-600">Mô tả danh sách phát: ( được bỏ trống )</label>
                    <textarea name="description" type="text" id="description" class="form-control" placeholder="Nhập nội dung giới thiệu, mô tả"><?php
                    echo isset($playlist) ? $playlist['description'] : old('description') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-600">Gắn thẻ cho danh sách phát: ( được bỏ trống )</label>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr);">
                        <?php
                            $tags = isset($tags) ? $tags : (old('tags') ?? []);
                            foreach (config('adm.playlist.tags') as $key => $value) {
                                ?>
                                    <div class="form-check form-check-01">
                                        <input name="tags[]" type="checkbox" id="checkbox-<?php echo $key ?>" class="form-check-input"
                                            value="<?php echo $key ?>" <?php echo in_array($key, $tags) ? 'checked' : null ?>>
                                        <label class="form-check-label fw-600" for="checkbox-<?php echo $key ?>"><?php echo $value ?></label>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>

                <div class="form-bottom mt-20 col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-md-01 bg-color-blue-01"><?php echo isset($playlist) ? 'Cập nhật danh sách phát' : 'Tạo danh sách phát' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>