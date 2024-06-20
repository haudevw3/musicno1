<div id="table-categories" class="table-container bg-color-white rounded-6 box-shadow-01">
    <div class="table-top">
        <div class="box-text bg-color-white-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-04"><?php echo isset($title) ? $title : 'Bảng dữ liệu' ?></div>
        <div class="divider-01"></div>
        <?php include_one('adm.components.action-manager-categories') ?>
    </div>
    <div class="table-body mt-20 pl-20 pr-20">
        <table>
            <thead>
                <tr>
                    <th style="width:2%">
                        <div class="form-check">
                            <input id="choose-all" class="form-check-input cursor-pointer"
                                type="checkbox" value="">
                            <label for="choose-all" class="form-check-label"></label>
                        </div>
                    </th>
                    <?php
                        foreach (config('adm.categories.table.column') as $column) {
                            ?> <th><?php echo $column ?></th> <?php
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (! empty($categories)) {
                        foreach ($categories as $key => $category) {
                            $key++;
                            ?>
                                <tr id="row-<?php echo $key ?>">
                                    <td>
                                        <div class="form-check">
                                            <input id="check-box-<?php echo $key ?>" name="ids[]" value="<?php echo $category['id'] ?>" class="form-check-input cursor-pointer"
                                                type="checkbox" value="">
                                            <label for="check-box-<?php echo $key ?>" class="form-check-label"></label>
                                        </div>
                                    </td>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $category['name'] ?></td>
                                    <td><?php echo $category['priority'] ?></td>
                                    <td><?php echo $category['sub_id'] ?></td>
                                    <td><?php echo $category['display_limit'] ?></td>
                                    <td><?php echo $category['slug'] ?></td>
                                    <td><?php echo $category['created_at'] ?></td>
                                    <td>
                                        <div class="d-flex position-relative">
                                            <div row-id="<?php echo $key ?>" class="btn btn-sm-01 center-items choose-detail-category"><i class="fa-regular fa-ellipsis-vertical fw-600"></i></div>
                                            <a href="<?php echo route('adm-edit-category', $category['id']) ?>" class="btn btn-sm-01 center-items ml-10"><i class="fa-regular fa-pen-to-square"></i></a>
                                            <div data-url="<?php echo route('adm-delete-category', $category['id']) ?>" class="btn btn-sm-01 center-items ml-10 choose-delete-category"><i class="fa-regular fa-trash-can"></i></div>
                                            <?php _require('adm.components.dropdown-manager-categories', compact('key')) ?>
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