<div id="form-manage-song" class="form-container bg-white rounded shadow"
    data-id="<?php echo isset($song) ? $song['id'] : 0 ?>"
    data-url="<?php echo isset($song) ? route('adm-update-song', $song['id']) : route('adm-create-song') ?>">

    <div class="form-header vertical-center-align-items fs-16 fw-semibold text-blue p-20 rounded-top">
        <?php echo $title ?>
    </div>

    <div class="form-wrapper p-20">
        <div class="form-content rounded p-20">
            <div id="name" class="mb-3">
                <label>Tên bài hát:</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-pen"></i>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên bài hát..."
                        value="<?php echo isset($song) ? $song['name'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>
        
            <div id="slug" class="mb-3">
                <label>Đường dẫn hiển thị:</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-link"></i>
                    <input type="text" name="slug" class="form-control" placeholder="Tự thay đổi theo tên bài hát..."
                        value="<?php echo isset($song) ? $song['slug'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="image" class="mb-3">
                <label>Hình ảnh: ( chỉ chấp nhận các tập tin có đuôi jpg, jpeg, png )</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-camera"></i>
                    <input type="text" name="image" class="form-control ofm" placeholder="Nhấn vào đây để chọn hình ảnh..."
                        value="<?php echo isset($song) ? $song['image'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="audio" class="mb-3">
                <label>Âm thanh: ( chỉ chấp nhận các tập tin có đuôi mp3, mpeg )</label>
                <div class="input-group-icon">
                    <i class="fa-regular fa-volume"></i>
                    <input type="text" name="audio" class="form-control ofm" placeholder="Nhấn vào đây để chọn âm thanh..."
                        value="<?php echo isset($song) ? $song['audio'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="search" class="mb-3">
                <label>Gắn thẻ nghệ sĩ góp mặt: ( nhập @ và 1 kí tự đi kèm để tìm kiếm )</label>
                <div class="text-box-group">
                    <div id="text-box" class="text-box form-control" name="textbox" contenteditable="true" aria-placeholder="Tìm kiếm theo tên nghệ sĩ...">
                        <?php
                            if (isset($song) && ! empty($subArtists)) {
                                foreach ($subArtists as $subArtist) {
                                    ?><span class="mention text-blue fw-semibold" data-id="<?php echo $subArtist['id'] ?>"
                                    data-mention="<?php echo '@'.$subArtist['name'] ?>"></span><?php echo '&nbsp;' ?><?php
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

            <div id="tags" class="mb-3">
                <label>Gắn thẻ cho bài hát:</label>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr);">
                    <?php
                        $tags = isset($song) ? explode(',', $song['tags']) : [];
                        foreach (config('song.tags') as $key => $value) {
                            ?>
                                <div class="form-check">
                                    <input class="form-check-input" id="check-box-<?php echo $key ?>" type="checkbox" name="tags[]"
                                        value="<?php echo $key ?>" <?php echo in_array($key, $tags) ? 'checked' : null ?>>
                                    <label class="form-check-label" for="check-box-<?php echo $key ?>"><?php echo $value ?></label>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>

            <div class="mb-0 mt-20 d-flex justify-content-end">
                <button id="submit-form-song" class="btn btn-primary">
                    <?php echo isset($song) ? 'Cập nhật bài hát' : 'Tạo bài hát' ?>
                </button>
            </div>
        </div>
    </div>
</div>