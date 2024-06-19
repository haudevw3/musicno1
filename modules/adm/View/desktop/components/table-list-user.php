<div id="table-user" class="table-container bg-color-white rounded-6 box-shadow-01">
    <div class="table-top">
        <div class="box-text bg-color-white-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-04">Bảng dữ liệu</div>
        <div class="divider-01"></div>
        <?php include_one('adm.components.action-manager-user') ?>
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
                        foreach (config('adm.user.table.column') as $column) {
                            ?> <th><?php echo $column ?></th> <?php
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (! empty($users)) {
                        foreach ($users as $key => $user) {
                            $key++;
                            ?>
                                <tr id="row-<?php echo $key ?>">
                                    <td>
                                        <div class="form-check">
                                            <input id="check-box-<?php echo $key ?>" name="ids[]" value="<?php echo $user['id'] ?>" class="form-check-input cursor-pointer"
                                                type="checkbox" value="">
                                            <label for="check-box-<?php echo $key ?>" class="form-check-label"></label>
                                        </div>
                                    </td>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $user['fullname'] ?></td>
                                    <td><?php echo $user['username'] ?></td>
                                    <td><?php echo $user['tel'] ?></td>
                                    <td><?php echo $user['address'] ?></td>
                                    <td><?php echo $user['email'] ?></td>
                                    <td><div class="bg-color-blue center-items label">Hoạt động</div></td>
                                    <td><?php echo $user['created_at'] ?></td>
                                    <td>
                                        <div class="d-flex position-relative">
                                            <div row-id="<?php echo $key ?>" class="btn btn-sm-01 center-items choose-detail-user"><i class="fa-regular fa-ellipsis-vertical fw-600"></i></div>
                                            <a href="<?php echo route('adm-edit-user', $user['id']) ?>" class="btn btn-sm-01 center-items ml-10"><i class="fa-regular fa-pen-to-square"></i></a>
                                            <div data-url="<?php echo route('adm-delete-user', $user['id']) ?>" class="btn btn-sm-01 center-items ml-10 choose-delete-user <?php echo "delete-user-$key" ?>"><i class="fa-regular fa-trash-can"></i></div>
                                            <?php _require('adm.components.dropdown-manager-user', compact('key')) ?>
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