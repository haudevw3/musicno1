<div id="table-manage-album" class="datatable table-container bg-white rounded shadow">
    <div class="table-header vertical-center-align-items fs-16 fw-semibold text-blue p-20 rounded-top">
        Bảng dữ liệu album
    </div>

    <?php include_one('album.components.actions-manage-album') ?>

    <div class="table-wrapper pl-20 pr-20">
        <table class="table-content">
            <thead>
                <tr>
                    <th>
                        <div class="form-check">
                            <input class="form-check-input" id="checkbox" type="checkbox">
                            <label class="form-check-label" for="checkbox"></label>
                        </div>
                    </th>
                    <th>STT</th>
                    <th>Tên album</th>
                    <th>Cập nhật gần đây</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (! empty($albums)) {
                        foreach ($albums as $key => $album) {
                            $key++;
                            ?>
                                <tr data-index="<?php echo $key ?>">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" id="checkbox-<?php echo $key ?>" type="checkbox" name="album_ids[]" value="<?php echo $album['id'] ?>">
                                            <label class="form-check-label" for="checkbox-<?php echo $key ?>"></label>
                                        </div>
                                    </td>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $album['name'] ?></td>
                                    <td><?php echo date_format(date_create($album['updated_at']), 'd-m-Y | H:i') ?></td>
                                    <td>
                                        <div class="d-flex position-relative">
                                            <a class="btn-table center-align-items show-options" data-index="<?php echo $key ?>">
                                                <i class="fa-regular fa-ellipsis-vertical"></i>
                                            </a>
                                            <a class="btn-table center-align-items ml-10" href="<?php echo route('adm-edit-album', $album['id']) ?>">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a class="btn-table center-align-items ml-10 delete-album"
                                                data-id="<?php echo $album['id'] ?>"
                                                data-url="<?php echo route('adm-delete-album', $album['id']) ?>">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>

                                            <?php _require('album.components.options-manage-album', compact('key', 'album')) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

    <div class="table-bottom p-20 d-flex justify-content-end">
        <?php include_one('components.adm.pagination', compact('pagination')) ?>
    </div>
</div>