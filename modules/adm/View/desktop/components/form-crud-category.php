<div class="d-flex">
    <div class="form-container box-shadow-01 rounded-6 bg-color-white">
        <div class="form-top">
            <div class="box-text bg-color-white-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
            <div class="divider-01"></div>
        </div>
        <div class="form-body p-20">
            <form method="post" action="<?php echo isset($category) ? route('adm-update-category') : route('adm-create-category') ?>">
                <input name="<?php echo isset($category) ? 'id' : null ?>" type="text" class="d-none"
                       value="<?php echo isset($category) ? $category['id'] : null ?>" />

                <div class="mb-3">
                    <label for="name" class="form-label fw-600">Tên danh mục:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-pen"></i>
                        <input name="name" type="text" id="name" class="form-control need-convert-to-slug" placeholder="Nhập tên danh mục"
                               value="<?php echo isset($category) ? $category['name'] : old('name') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('name') ?></div>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-600">Đường dẫn hiển thị:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-link"></i>
                        <input name="slug" type="text" id="slug" class="form-control converted-slug" placeholder="Nhập đường dẫn hiển thị"
                               value="<?php echo isset($category) ? $category['slug'] : old('slug') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('slug') ?></div>
                </div>

                <div class="mb-3">
                    <label for="priority" class="form-label fw-600">Độ ưu tiên danh mục:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-flag"></i>
                        <input name="priority" type="number" id="priority" class="form-control" placeholder="Nhập độ ưu tiên cho danh mục"
                               value="<?php echo isset($category) ? $category['priority'] : (old('priority') ?? 0) ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('priority') ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-600">Chọn danh mục để hiển thị: ( được bỏ trống )</label>
                    <div class="checkbox-container" data-rows="<?php echo count($categories) ?>" style="display: grid; grid-template-columns: repeat(2, 1fr);">
                        <?php
                            $parentId = isset($category['parent_id']) ? $category['parent_id'] : (old('parent_id') ?? 0);
                            if (! empty($categories)) {
                                foreach ($categories as $key => $cate) {
                                    $key++;
                                    if ((isset($category['id']) && $cate['id'] == $category['id'])) {
                                        continue;
                                    }
                                    ?>
                                        <div class="form-check form-check-01">
                                            <input name="parent_id" type="checkbox" data-key="<?php echo $key ?>" id="checkbox-cate-<?php echo $key ?>" class="form-check-input checkbox-once"
                                                   value="<?php echo $cate['id'] ?>" <?php echo ($cate['id'] == $parentId) ? 'checked' : null ?>>
                                            <label class="form-check-label fw-600" for="checkbox-cate-<?php echo $key ?>"><?php echo $key.'. '.$cate['name'] ?></label>
                                        </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>
                
                <?php
                    if (! empty($playlists)) {
                        ?>
                            <div class="mb-3">
                                <label class="form-label fw-600">Chọn playlist cho danh mục: ( được bỏ trống )</label>
                                <div style="display: grid; grid-template-columns: repeat(2, 1fr);">
                                    <?php
                                        $playlistIds = isset($playlistIds) ? $playlistIds : (old('playlist_ids') ?? []);
                                        foreach ($playlists as $key => $playlist) {
                                            ?>
                                                <div class="form-check form-check-01">
                                                    <input name="playlist_ids[]" type="checkbox" value="<?php echo $playlist['id'] ?>" id="checkbox-playlist-<?php echo $key ?>" class="form-check-input"
                                                    <?php echo in_array($playlist['id'], $playlistIds) ? 'checked' : null ?>>
                                                    <label class="form-check-label fw-600" for="checkbox-playlist-<?php echo $key ?>"><?php echo $playlist['name'] ?></label>
                                                </div>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php
                    }
                ?>

                <div class="form-bottom mt-20 col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-md-01 bg-color-blue-01"><?php echo isset($category) ? 'Cập nhật danh mục' : 'Tạo danh mục' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>