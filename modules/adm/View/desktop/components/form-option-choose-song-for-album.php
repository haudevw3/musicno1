<div class="form-container bg-color-white rounded-6 box-shadow-01">
    <div class="form-top">
        <div class="box-text bg-color-gray-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
        <div class="divider-01"></div>
    </div>
    <div class="form-body p-20">
        <form method="post" action="<?php echo route('adm-update-song-for-album') ?>">
            <input name="id" type="text" class="d-none" value="<?php echo $album['id'] ?>" />

            <div class="mb-3">
                <label class="form-label fw-600">Chọn bài hát:</label>
                <div <?php echo ($album['type'] == 1) ? 'class = "checkbox-container" data-rows="'.count($songs).'"' : null ?> style="display: grid; grid-template-columns: repeat(2, 1fr);">
                    <?php
                        $songIds = isset($songIds) ? $songIds : (old('song_ids') ?? []);
                        foreach ($songs as $key => $song) {
                            $key++;
                            ?>
                                <div class="form-check form-check-01">
                                    <input name="song_ids[]" type="checkbox" data-key="<?php echo $key ?>" id="checkbox-<?php echo $key ?>"
                                           class="form-check-input <?php echo ($album['type'] == 1) ? 'checkbox-once' : null ?>"
                                           value="<?php echo $song['id'] ?>" <?php echo in_array($song['id'], $songIds) ? 'checked' : null ?>>
                                    <label class="form-check-label fw-600" for="checkbox-<?php echo $key ?>"><?php echo $song['name'] ?></label>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>

            <div class="form-bottom mt-20 col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-md-01 bg-color-blue-01">Cập nhật dữ liệu</button>
            </div>
        </form>
    </div>
</div>