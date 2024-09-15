<div id="form-manage-playlist" class="card shadow col-9"
    data-id="<?php echo isset($playlist) ? $playlist['id'] : 0 ?>"
    data-url="<?php echo isset($playlist) ? route('adm-update-playlist', $playlist['id']) : route('adm-create-playlist') ?>">

    <div class="card-header fs-16 fw-semibold text-blue"><?php echo 'Biểu mẫu '. mb_strtolower($title) ?></div>
    <div class="card-body">
        <div class="form-content p-20">
            <div id="name" class="mb-3">
                <label>Tên danh sách phát:</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-pen"></i>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên danh sách phát..."
                        value="<?php echo isset($playlist) ? $playlist['name'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>
        
            <div id="slug" class="mb-3">
                <label>Đường dẫn hiển thị:</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-link"></i>
                    <input type="text" name="slug" class="form-control" placeholder="Tự thay đổi theo tên danh sách phát..."
                        value="<?php echo isset($playlist) ? $playlist['slug'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="priority" class="mb-3">
                <label>Độ ưu tiên danh mục:</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-flag"></i>
                    <input type="number" name="priority" class="form-control" placeholder="Nhập độ ưu tiên danh mục..."
                        value="<?php echo isset($playlist) ? $playlist['priority'] : 0 ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="image" class="mb-3">
                <label>Hình ảnh: ( chỉ chấp nhận các tập tin có đuôi jpg, jpeg, png )</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-camera"></i>
                    <input type="text" name="image" class="form-control ofm" placeholder="Nhấn vào đây để chọn hình ảnh..."
                        value="<?php echo isset($playlist) ? $playlist['image'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="description" class="mb-3">
                <label>Mô tả cho danh sách phát:</label>
                <textarea rows="3" name="description" class="form-control" placeholder="Nhập mô tả cho danh sách phát..."><?php
                    echo isset($playlist) ? $playlist['description'] : null ?></textarea>
                <span class="invalid-feedback"></span>
            </div>

            <div id="search" class="mb-3">
                <label>Gắn thẻ các album để hiển thị: ( nhập @ và 1 kí tự đi kèm để tìm kiếm )</label>
                <div id="text-box" class="text-box form-control" name="textbox" contenteditable="true" aria-placeholder="Tìm kiếm theo tên album..."><?php
                    if (isset($playlist)) {
                        foreach ($albums as $album) {
                            ?><span class="mention text-blue fw-semibold" data-id="<?php echo $album['id'] ?>"
                            data-mention="<?php echo '@'.$album['name'] ?>"></span><?php echo '&nbsp;' ?><?php
                        }
                    }
                ?></div>
                <div class="position-relative mt-5">
                    <div id="mention-box" class="dropdown-menu shadow animated-fade-in-up col-12 scroll-bar"></div>
                </div>
            </div>

            <div class="mt-20 items-align-vertical-center-end">
                <button id="submit-form-playlist" class="btn btn-primary">
                    <?php echo isset($playlist) ? 'Cập nhật danh sách phát' : 'Tạo danh sách phát' ?>
                </button>
            </div>
        </div>
    </div>
</div>