<div id="form-manage-artist" class="card shadow col-9"
    data-id="<?php echo isset($artist) ? $artist['id'] : 0 ?>"
    data-url="<?php echo isset($artist) ? route('adm-update-artist', $artist['id']) : route('adm-create-artist') ?>">

    <div class="card-header fs-16 fw-semibold text-blue"><?php echo 'Biểu mẫu '. mb_strtolower($title) ?></div>
    <div class="card-body">
        <div class="form-content p-20">
            <div id="name" class="mb-3">
                <label>Tên nghệ sĩ:</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-pen"></i>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên nghệ sĩ..."
                        value="<?php echo isset($artist) ? $artist['name'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>
        
            <div id="slug" class="mb-3">
                <label>Đường dẫn hiển thị:</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-link"></i>
                    <input type="text" name="slug" class="form-control" placeholder="Tự thay đổi theo tên nghệ sĩ..."
                        value="<?php echo isset($artist) ? $artist['slug'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="image" class="mb-3">
                <label>Hình ảnh: ( chỉ chấp nhận các tập tin có đuôi jpg, jpeg, png )</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-camera"></i>
                    <input type="text" name="image" class="form-control ofm" placeholder="Nhấn vào đây để chọn hình ảnh..."
                        value="<?php echo isset($artist) ? $artist['image'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="description" class="mb-3">
                <label>Mô tả tiểu sử của nghệ sĩ:</label>
                <textarea rows="5" name="description" class="form-control" placeholder="Nhập mô tả tiểu sử của nghệ sĩ..."><?php
                    echo isset($artist) ? $artist['description'] : null ?></textarea>
                <span class="invalid-feedback"></span>
            </div>

            <div class="mt-20 items-align-vertical-center-end">
                <button id="submit-form-artist" class="btn btn-primary">
                    <?php echo isset($artist) ? 'Cập nhật nghệ sĩ' : 'Tạo nghệ sĩ' ?>
                </button>
            </div>
        </div>
    </div>
</div>