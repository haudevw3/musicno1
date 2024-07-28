<div class="form-container bg-color-white rounded-6 box-shadow-01">
    <div class="form-top">
        <div class="box-text bg-color-gray-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
        <div class="divider-01"></div>
    </div>
    <div class="form-body p-20">
        <form method="post" action="<?php echo route('adm-update-album-for-playlist') ?>">
            <input name="id" type="text" class="d-none" value="<?php echo $playlist['id'] ?>" />

            <div class="mb-3">
                <label class="form-label fw-600">Chọn album:</label>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr);">
                    <?php
                        $albumIds = isset($albumIds) ? $albumIds : (old('album_ids') ?? []);
                        foreach ($albums as $key => $album) {
                            $key++;
                            ?>
                                <div class="form-check form-check-01">
                                    <input name="album_ids[]" type="checkbox" id="checkbox-<?php echo $key ?>" class="form-check-input"
                                            value="<?php echo $album['id'] ?>" <?php echo in_array($album['id'], $albumIds) ? 'checked' : null ?>>
                                    <label class="form-check-label fw-600" for="checkbox-<?php echo $key ?>"><?php echo $album['name'] ?></label>
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