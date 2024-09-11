<div id="form-manage-album" class="form-container bg-white rounded shadow"
    data-id="<?php echo isset($album) ? $album['id'] : 0 ?>"
    data-url="<?php echo isset($album) ? route('adm-update-album', $album['id']) : route('adm-create-album') ?>"
    data-artist-id="<?php echo isset($artistId) ? $artistId : 0 ?>">

    <div class="form-header vertical-center-align-items fs-16 fw-semibold text-blue p-20 rounded-top">
        <?php echo $title ?>
    </div>

    <div class="form-wrapper p-20">
        <?php
            if (! isset($album)) {
                ?>
                    <div class="alert alert-info position-relative m-0 mb-3" role="alert">
                        <li class="text-primary">Bước 1: Điền đầy đủ thông tin để tạo album</li>
                        <li class="text-primary">Bước 2: Thêm một hoặc nhiều bài hát vào album dựa trên loại album đã tạo trước đó.</li>
                        <li class="text-warning">
                            Lưu ý: Phải thực hiện đầy đủ các bước trên và không được hủy bỏ quá trình hoặc chuyển hướng đến trang khác.
                            Nếu không mọi dữ liệu trước đó sẽ không được cập nhật trên hệ thống.
                        </li>
                    </div>
                <?php
            }
        ?>

        <div class="form-content rounded p-20">
            <div id="name" class="mb-3">
                <label>Tên album:</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-pen"></i>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên album..."
                        value="<?php echo isset($album) ? $album['name'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>
        
            <div id="slug" class="mb-3">
                <label>Đường dẫn hiển thị:</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-link"></i>
                    <input type="text" name="slug" class="form-control" placeholder="Tự thay đổi theo tên album..."
                        value="<?php echo isset($album) ? $album['slug'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="image" class="mb-3">
                <label>Hình ảnh: ( chỉ chấp nhận các tập tin có đuôi jpg, jpeg, png - được bỏ trống )</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-camera"></i>
                    <input type="text" name="image" class="form-control ofm" placeholder="Nhấn vào đây để chọn hình ảnh..."
                        value="<?php echo isset($album) ? $album['image'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="type" class="mb-3">
                <label>Chọn loại album:</label>
                <select name="type" class="form-control">
                    <?php
                        $type = isset($album) ? $album['type'] : 1;
                        foreach (config('album.types') as $key => $value) {
                            ?>
                                <option value="<?php echo $key ?>" <?php echo ($key == $type) ? 'selected' : null ?>>
                                    <?php echo $value['name'].' - '.$value['description'] ?>
                                </option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div id="release_year" class="mb-3">
                <label>Năm phát hành:</label>
                <select name="release_year" class="form-control">
                    <?php
                        $releaseYear = isset($album) ? $album['release_year'] : config('album.years')[0];
                        foreach (config('album.years') as $value) {
                            ?>
                                <option value="<?php echo $value ?>" <?php echo ($value == $releaseYear) ? 'selected' : null ?>>
                                    <?php echo $value ?>
                                </option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div id="description" class="mb-3">
                <label>Mô tả cho album:</label>
                <textarea rows="5" name="description" class="form-control" placeholder="Nhập mô tả cho album..."
                ><?php echo isset($album) ? $album['description'] : null ?></textarea>
                <span class="invalid-feedback"></span>
            </div>

            <div class="mb-0 mt-20 d-flex justify-content-end">
                <button id="submit-form-album" class="btn btn-primary">
                    <?php echo isset($album) ? 'Cập nhật album' : 'Tạo album' ?>
                </button>
            </div>
        </div>
    </div>
</div>

<?php
    if (! isset($album)) {
        _require('song.components.form-manage-song', ['title' => 'Biểu mẫu tạo bài hát', 'style' => 'display:none;']);
    }
?>