<div class="d-flex">
    <div class="form-container box-shadow-01 rounded-6 bg-color-white">
        <div class="form-top">
            <div class="box-text bg-color-white-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
            <div class="divider-01"></div>
        </div>
        <div class="form-body p-20">
            <form method="post" action="<?php echo isset($song) ? route('adm-update-song') : route('adm-create-song') ?>" enctype="multipart/form-data">
                <input class="d-none" type="text" name="<?php echo isset($song) ? 'id' : null ?>" value="<?php echo isset($song) ? $song['id'] : null ?>" />
                <input class="d-none" type="text" name="<?php echo isset($song) ? 'duration' : null ?>" value="<?php echo isset($song) ? $song['duration'] : null ?>" />
                <input class="d-none" type="text" name="<?php echo isset($song) ? 'image_url' : null ?>" value="<?php echo isset($song) ? $song['image'] : null ?>" />
                <input class="d-none" type="text" name="<?php echo isset($song) ? 'audio_url' : null ?>" value="<?php echo isset($song) ? $song['audio'] : null ?>" />

                <div class="mb-3">
                    <label for="name" class="form-label fw-600">Tên bài hát:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-pen"></i>
                        <input id="name" type="text" name="name" class="form-control need-convert-to-slug" placeholder="Nhập tên bài hát" value="<?php echo isset($song) ? $song['name'] : old('name') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('name') ?></div>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-600">Đường dẫn hiển thị:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-link"></i>
                        <input id="slug" type="text" name="slug" class="form-control converted-slug" placeholder="Nhập đường dẫn hiển thị" value="<?php echo isset($song) ? $song['slug'] : old('slug') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('slug') ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-600">Nghệ sĩ:</label>
                    <select class="form-select" name="artist_id">
                        <option value="0" selected disabled hidden>Chọn nghệ sĩ</option>
                        <?php
                            $artistId = old('artist_id');
                            foreach ($artists as $artist) {
                                ?>
                                    <option value="<?php echo $artist['id'] ?>" <?php echo isset($song) ? (($song['artist_id'] == $artist['id']) ? 'selected' : null) : (($artistId == $artist['id']) ? 'selected' : null) ?>><?php echo $artist['name'] ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <div class="form-text text-color-red"><?php echo error('artist_id') ?></div>
                </div>

                <div class="mb-3">
                    <label for="audio-upload" class="form-label fw-600">Âm thanh bài hát:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-sharp fa-regular fa-volume"></i>
                        <input class="col-12 file-upload" id="audio-upload" type="file" name="audio">
                    </div>
                    <div class="form-text text-color-red"></div>
                </div>

                <div class="mb-3">
                    <label for="file-upload" class="form-label fw-600">Ảnh bài hát: ( được bỏ trống )</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-camera"></i>
                        <input class="col-12 file-upload" id="file-upload" type="file" name="image">
                    </div>
                    <div class="form-text text-color-red"></div>
                </div>

                <div class="mb-3">
                    <label for="composer" class="form-label fw-600">Đóng góp chung với nghệ sĩ: ( được bỏ trống )</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-user-group"></i>
                        <input id="composer" type="text" name="composer" class="form-control" placeholder="Nhập các nghệ sĩ đóng góp chung" value="<?php echo isset($song) ? $song['composer'] : old('composer') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('composer') ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-600">Chọn danh mục để hiển thị: ( được bỏ trống )</label>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr);">
                        <?php
                            $tags = [];
                            if (isset($song['tags'])) {
                                $tags = explode(',', $song['tags']);
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
                    <button type="submit" class="btn btn-md-01 bg-color-blue-01"><?php echo isset($song) ? 'Cập nhật bài hát' : 'Tạo bài hát' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>