<div class="table-container bg-color-white rounded-6 box-shadow-01">
    <div class="table-top">
        <div class="box-text bg-color-gray-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
        <div class="divider-01"></div>
        <?php include_one('adm.components.actions-manage-category') ?>
    </div>
    <div class="table-body mt-20 pl-20 pr-20">
        <table>
            <thead>
                <tr>
                    <th style="width:2%">
                        <div class="form-check form-check-01">
                            <input id="checkbox-all" class="form-check-input cursor-pointer" type="checkbox">
                            <label for="checkbox-all" class="form-check-label"></label>
                        </div>
                    </th>
                    <?php
                        foreach (config('adm.categories.table.columns') as $column) {
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
                                        <div class="form-check form-check-01">
                                            <input id="checkbox-<?php echo $key ?>" name="category_ids[]" value="<?php echo $category['id'] ?>" class="form-check-input cursor-pointer" type="checkbox">
                                            <label for="checkbox-<?php echo $key ?>" class="form-check-label"></label>
                                        </div>
                                    </td>
                                    <td><?php echo $key ?></td>
                                    <td>
                                        <?php
                                            $color = null;
                                            if ($category['parent_id'] == 0) $color = 'bg-color-blue';
                                            else $color = 'bg-color-gray';
                                        ?>
                                        <div class="d-flex">
                                            <div style="width:8px; height:8px; margin-top:8px" class="rounded-circle <?php echo $color ?>"></div>
                                            <span class="ml-5"><?php echo $category['name'] ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo date_format(date_create($category['created_at']), 'd-m-Y') ?></td>
                                    <td><?php echo date_format(date_create($category['updated_at']), 'd-m-Y | H:i') ?></td>
                                    <td>
                                        <div class="d-flex position-relative">
                                            <div row-id="<?php echo $key ?>" class="table-btn center-items show-options"><i class="fa-regular fa-ellipsis-vertical fw-600"></i></div>
                                            <a href="<?php echo route('adm-edit-category', $category['id']) ?>" class="table-btn center-items ml-10"><i class="fa-regular fa-pen-to-square"></i></a>
                                            <div data-url="<?php echo route('adm-delete-category', $category['id']) ?>" class="table-btn center-items ml-10 show-modal"><i class="fa-regular fa-trash-can"></i></div>
                                            <?php _require('adm.components.options-manage-category', compact('key', 'category')) ?>
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