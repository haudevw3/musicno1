<div class="form-container bg-color-white rounded-6 box-shadow-01">
    <div class="form-top">
        <div class="box-text bg-color-gray-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
        <div class="divider-01"></div>
    </div>
    <div class="form-body p-20">
        <form method="post" action="<?php echo route('adm-update-playlist-for-category') ?>">
            <input name="id" type="text" class="d-none" value="<?php echo $id ?>" />

            <div class="mb-3">
                <label class="form-label fw-600">Chọn danh sách phát:</label>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr);">
                    <?php
                        $playlistIds = isset($playlistIds) ? $playlistIds : (old('playlist_ids') ?? []);
                        foreach ($playlists as $key => $playlist) {
                            $key++;
                            ?>
                                <div class="form-check form-check-01">
                                    <input name="playlist_ids[]" type="checkbox" id="checkbox-<?php echo $key ?>" class="form-check-input"
                                           value="<?php echo $playlist['id'] ?>" <?php echo in_array($playlist['id'], $playlistIds) ? 'checked' : null ?>>
                                    <label class="form-check-label fw-600" for="checkbox-<?php echo $key ?>"><?php echo $playlist['name'] ?></label>
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