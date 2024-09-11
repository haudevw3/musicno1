<div id="table-manage-song" class="datatable table-container bg-white rounded shadow">
    <div class="table-header vertical-center-align-items fs-16 fw-semibold text-blue p-20 rounded-top">
        Bảng dữ liệu bài hát
    </div>

    <?php include_one('song.components.actions-manage-song') ?>

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
                    <th>Tên bài hát</th>
                    <th>Cập nhật gần đây</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (! empty($songs)) {
                        foreach ($songs as $key => $song) {
                            $key++;
                            ?>
                                <tr data-index="<?php echo $key ?>">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" id="checkbox-<?php echo $key ?>" type="checkbox" name="song_ids[]" value="<?php echo $song['id'] ?>">
                                            <label class="form-check-label" for="checkbox-<?php echo $key ?>"></label>
                                        </div>
                                    </td>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $song['name'] ?></td>
                                    <td><?php echo date_format(date_create($song['updated_at']), 'd-m-Y | H:i') ?></td>
                                    <td>
                                        <div class="d-flex position-relative">
                                            <a class="btn-table center-align-items show-options" data-index="<?php echo $key ?>">
                                                <i class="fa-regular fa-ellipsis-vertical"></i>
                                            </a>
                                            <a class="btn-table center-align-items ml-10" href="<?php echo route('adm-edit-song', $song['id']) ?>">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a class="btn-table center-align-items ml-10 delete-song"
                                                data-id="<?php echo $song['id'] ?>"
                                                data-url="<?php echo route('adm-delete-song', $song['id']) ?>">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>

                                            <?php _require('song.components.options-manage-song', compact('key', 'song')) ?>
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