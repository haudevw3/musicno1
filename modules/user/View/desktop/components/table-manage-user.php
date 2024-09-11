<div id="table-manage-user" class="datatable table-container bg-white rounded shadow">
    <div class="table-header vertical-center-align-items fs-16 fw-semibold text-blue p-20 rounded-top">
        Bảng dữ liệu người dùng
    </div>

    <?php include_one('user.components.actions-manage-user') ?>

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
                    <th>Họ và tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Trạng thái</th>
                    <th>Cập nhật gần đây</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (! empty($users)) {
                        foreach ($users as $key => $user) {
                            $key++;
                            ?>
                                <tr data-index="<?php echo $key ?>">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" id="checkbox-<?php echo $key ?>" type="checkbox" name="user_ids[]" value="<?php echo $user['id'] ?>">
                                            <label class="form-check-label" for="checkbox-<?php echo $key ?>"></label>
                                        </div>
                                    </td>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $user['fullname'] ?></td>
                                    <td><?php echo $user['username'] ?></td>
                                    <td><?php echo $user['email'] ?></td>
                                    <td><?php echo $user['tel'] ?></td>
                                    <td><span class="badge bg-blue">Hoạt động</span></td>
                                    <td><?php echo date_format(date_create($user['updated_at']), 'd-m-Y | H:i') ?></td>
                                    <td>
                                        <div class="d-flex position-relative">
                                            <a class="btn-table center-align-items show-options" data-index="<?php echo $key ?>">
                                                <i class="fa-regular fa-ellipsis-vertical"></i>
                                            </a>
                                            <a class="btn-table center-align-items ml-10" href="<?php echo route('adm-edit-user', $user['id']) ?>">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a class="btn-table center-align-items ml-10 delete-user"
                                                data-id="<?php echo $user['id'] ?>"
                                                data-url="<?php echo route('adm-delete-user', $user['id']) ?>">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>

                                            <?php _require('user.components.options-manage-user', compact('key', 'user')) ?>
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