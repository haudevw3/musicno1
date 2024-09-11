<div id="form-manage-playlist" class="form-container bg-white rounded shadow"
    data-id="<?php echo isset($playlist) ? $playlist['id'] : 0 ?>"
    data-url="<?php echo isset($playlist) ? route('adm-update-playlist', $playlist['id']) : route('adm-create-playlist') ?>">

    <div class="form-header vertical-center-align-items fs-16 fw-semibold text-blue p-20 rounded-top">
        <?php echo $title ?>
    </div>

    <div class="form-wrapper p-20">
        <div class="form-content rounded p-20">
            <div id="name" class="mb-3">
                <label>Tên danh sách phát:</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-pen"></i>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên danh sách phát..."
                        value="<?php echo isset($playlist) ? $playlist['name'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>
        
            <div id="slug" class="mb-3">
                <label>Đường dẫn hiển thị:</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-link"></i>
                    <input type="text" name="slug" class="form-control" placeholder="Tự thay đổi theo tên danh sách phát..."
                        value="<?php echo isset($playlist) ? $playlist['slug'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="priority" class="mb-3">
                <label>Độ ưu tiên danh mục:</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-flag"></i>
                    <input type="number" name="priority" class="form-control" placeholder="Nhập độ ưu tiên danh mục..."
                        value="<?php echo isset($playlist) ? $playlist['priority'] : 0 ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="image" class="mb-3">
                <label>Hình ảnh: ( chỉ chấp nhận các tập tin có đuôi jpg, jpeg, png )</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-camera"></i>
                    <input type="text" name="image" class="form-control ofm" placeholder="Nhấn vào đây để chọn hình ảnh..."
                        value="<?php echo isset($playlist) ? $playlist['image'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="description" class="mb-3">
                <label>Mô tả cho danh sách phát:</label>
                <textarea rows="3" name="description" class="form-control" placeholder="Nhập mô tả cho danh sách phát..."
                ><?php echo isset($playlist) ? $playlist['description'] : null ?></textarea>
                <span class="invalid-feedback"></span>
            </div>

            <div id="search" class="mb-3">
                <label>Gắn thẻ các album để hiển thị: ( nhập @ và 1 kí tự đi kèm để tìm kiếm )</label>
                <div class="text-box-group">
                    <div id="text-box" class="text-box form-control" name="textbox" contenteditable="true" aria-placeholder="Tìm kiếm theo tên nghệ sĩ...">
                        <?php
                            if (isset($playlist)) {
                                foreach ($albums as $album) {
                                    ?><span class="mention text-blue fw-semibold" data-id="<?php echo $album['id'] ?>"
                                    data-mention="<?php echo '@'.$album['name'] ?>"></span><?php echo '&nbsp;' ?><?php
                                }
                            }
                        ?>
                    </div>
                    <span class="invalid-feedback"></span>
                </div>
                <div class="input-group">
                    <div id="mention-box" class="dropdown-menu position-absolute shadow animated-fade-in-up col-12 mt-10"></div>
                </div>
            </div>

            <div class="mb-0 mt-20 d-flex justify-content-end">
                <button id="submit-form-playlist" class="btn btn-primary">
                    <?php echo isset($playlist) ? 'Cập nhật danh sách phát' : 'Tạo danh sách phát' ?>
                </button>
            </div>
        </div>
    </div>
</div>