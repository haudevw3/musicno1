<div id="table-manage-category" class="datatable table-container bg-white rounded shadow">
    <div class="table-header vertical-center-align-items fs-16 fw-semibold text-blue p-20 rounded-top">
        Bảng dữ liệu danh mục
    </div>

    <?php include_one('categories.components.actions-manage-category') ?>

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
                    <th>Tên danh mục</th>
                    <th>Cập nhật gần đây</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (! empty($categories)) {
                        foreach ($categories as $key => $category) {
                            $key++;
                            ?>
                                <tr data-index="<?php echo $key ?>">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" id="checkbox-<?php echo $key ?>" type="checkbox" name="category_ids[]" value="<?php echo $category['id'] ?>">
                                            <label class="form-check-label" for="checkbox-<?php echo $key ?>"></label>
                                        </div>
                                    </td>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $category['name'] ?></td>
                                    <td><?php echo date_format(date_create($category['updated_at']), 'd-m-Y | H:i') ?></td>
                                    <td>
                                        <div class="d-flex position-relative">
                                            <a class="btn-table center-align-items show-options" data-index="<?php echo $key ?>">
                                                <i class="fa-regular fa-ellipsis-vertical"></i>
                                            </a>
                                            <a class="btn-table center-align-items ml-10" href="<?php echo route('adm-edit-category', $category['id']) ?>">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a class="btn-table center-align-items ml-10 delete-category"
                                                data-id="<?php echo $category['id'] ?>"
                                                data-url="<?php echo route('adm-delete-category', $category['id']) ?>">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>

                                            <?php _require('categories.components.options-manage-category', compact('key', 'category')) ?>
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