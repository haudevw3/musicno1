<div class="d-flex">
    <div class="form-container box-shadow-01 rounded-6 bg-color-white">
        <div class="form-top">
            <div class="box-text bg-color-white-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
            <div class="divider-01"></div>
        </div>
        <div class="form-body p-20">
            <form method="post" action="<?php echo isset($album) ? route('adm-update-album') : route('adm-create-album') ?>" enctype="multipart/form-data">
                <input name="<?php echo isset($album) ? 'id' : null ?>" type="text" class="d-none"
                       value="<?php echo isset($album) ? $album['id'] : null ?>" />

                <input name="<?php echo isset($album) ? 'image_url' : null ?>" type="text" class="d-none"
                       value="<?php echo isset($album) ? $album['image'] : null ?>" />

                <div class="mb-3">
                    <label for="name" class="form-label fw-600">Tên album:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-pen"></i>
                        <input name="name" type="text" id="name" class="form-control need-convert-to-slug" placeholder="Nhập tên album"
                               value="<?php echo isset($album) ? $album['name'] : old('name') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('name') ?></div>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-600">Đường dẫn hiển thị:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-link"></i>
                        <input name="slug" type="text" id="slug" class="form-control converted-slug" placeholder="Nhập đường dẫn hiển thị"
                               value="<?php echo isset($album) ? $album['slug'] : old('slug') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('slug') ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-600">Loại album:</label>
                    <select class="form-select" name="type">
                        <?php
                            foreach (config('album.types') as $key => $value) {
                                ?>
                                    <option value="<?php echo $key ?>" <?php echo isset($album)
                                    ? (($album['type'] == $key) ? 'selected' : null)
                                    : ((old('type') == $key) ? 'selected' : null) ?>><?php echo $value['name'].' - '.$value['describe'] ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <div class="form-text text-color-red"><?php echo error('type') ?></div>
                </div>

                <div class="mb-3">
                    <label for="file-upload" class="form-label fw-600">Ảnh album:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-camera"></i>
                        <input name="image" type="file" class="col-12 file-upload" id="file-upload">
                    </div>
                    <div class="form-text text-color-red"></div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-600">Mô tả album: ( được bỏ trống )</label>
                    <textarea name="description" type="text" id="description" class="form-control" placeholder="Nhập nội dung giới thiệu, mô tả"><?php
                    echo isset($album) ? $album['description'] : old('description') ?></textarea>
                </div>

                <div class="form-bottom mt-20 col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-md-01 bg-color-blue-01"><?php echo isset($album) ? 'Cập nhật album' : 'Tạo album' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>