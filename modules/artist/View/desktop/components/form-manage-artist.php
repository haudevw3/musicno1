<div id="form-manage-artist" class="form-container bg-white rounded shadow"
    data-id="<?php echo isset($artist) ? $artist['id'] : 0 ?>"
    data-url="<?php echo isset($artist) ? route('adm-update-artist', $artist['id']) : route('adm-create-artist') ?>">

    <div class="form-header vertical-center-align-items fs-16 fw-semibold text-blue p-20 rounded-top">
        <?php echo $title ?>
    </div>

    <div class="form-wrapper p-20">
        <div class="form-content rounded p-20">
            <div id="name" class="mb-3">
                <label>Tên nghệ sĩ:</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-pen"></i>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên nghệ sĩ..."
                        value="<?php echo isset($artist) ? $artist['name'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>
        
            <div id="slug" class="mb-3">
                <label>Đường dẫn hiển thị:</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-link"></i>
                    <input type="text" name="slug" class="form-control" placeholder="Tự thay đổi theo tên nghệ sĩ..."
                        value="<?php echo isset($artist) ? $artist['slug'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="image" class="mb-3">
                <label>Hình ảnh: ( chỉ chấp nhận các tập tin có đuôi jpg, jpeg, png - được bỏ trống )</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-camera"></i>
                    <input type="text" name="image" class="form-control ofm" placeholder="Nhấn vào đây để chọn hình ảnh..."
                        value="<?php echo isset($artist) ? $artist['image'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="description" class="mb-3">
                <label>Mô tả tiểu sử của nghệ sĩ:</label>
                <textarea rows="5" name="description" class="form-control" placeholder="Nhập mô tả tiểu sử của nghệ sĩ..."
                ><?php echo isset($artist) ? $artist['description'] : null ?></textarea>
                <span class="invalid-feedback"></span>
            </div>

            <div class="mb-0 mt-20 d-flex justify-content-end">
                <button id="submit-form-artist" class="btn btn-primary">
                    <?php echo isset($artist) ? 'Cập nhật nghệ sĩ' : 'Tạo nghệ sĩ' ?>
                </button>
            </div>
        </div>
    </div>
</div>