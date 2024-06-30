<div id="table-artist" class="table-container bg-color-white rounded-6 box-shadow-01">
    <div class="table-top">
        <div class="box-text bg-color-gray-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
        <div class="divider-01"></div>
        <?php include_one('adm.components.action-manager-artist') ?>
    </div>
    <div class="table-body mt-20 pl-20 pr-20">
        <table>
            <thead>
                <tr>
                    <th style="width:2%">
                        <div class="form-check form-check-01">
                            <input id="choose-all" class="form-check-input cursor-pointer" type="checkbox">
                            <label for="choose-all" class="form-check-label"></label>
                        </div>
                    </th>
                    <?php
                        foreach (config('adm.artist.table.column') as $column) {
                            ?> <th><?php echo $column ?></th> <?php
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (! empty($artists)) {
                        foreach ($artists as $key => $artist) {
                            $key++;
                            ?>
                                <tr id="row-<?php echo $key ?>">
                                    <td>
                                        <div class="form-check form-check-01">
                                            <input id="check-box-<?php echo $key ?>" name="ids[]" value="<?php echo $artist['id'] ?>" class="form-check-input cursor-pointer" type="checkbox">
                                            <label for="check-box-<?php echo $key ?>" class="form-check-label"></label>
                                        </div>
                                    </td>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $artist['name'] ?></td>
                                    <td><?php echo $artist['biography'] ?></td>
                                    <td><?php echo $artist['tags'] ?></td>
                                    <td><?php echo date_format(date_create($artist['created_at']), 'd-m-Y') ?></td>
                                    <td><?php echo date_format(date_create($artist['updated_at']), 'd-m-Y | H:i') ?></td>
                                    <td>
                                        <div class="d-flex position-relative">
                                            <div row-id="<?php echo $key ?>" class="table-btn center-items choose-detail-artist"><i class="fa-regular fa-ellipsis-vertical fw-600"></i></div>
                                            <a href="<?php echo route('adm-edit-artist', $artist['id']) ?>" class="table-btn center-items ml-10"><i class="fa-regular fa-pen-to-square"></i></a>
                                            <div data-url="<?php echo route('adm-delete-artist', $artist['id']) ?>" class="table-btn center-items ml-10 choose-delete-artist"><i class="fa-regular fa-trash-can"></i></div>
                                            <?php _require('adm.components.dropdown-manager-artist', compact('key')) ?>
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
    <div class="table-bottom d-flex justify-content-end p-20">
        <?php include_one('components.adm.pagination', compact('pagination')) ?>
    </div>
</div>