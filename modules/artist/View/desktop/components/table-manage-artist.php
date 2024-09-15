<div id="table-manage-artist" class="datatable card shadow">
    <div class="card-header fs-16 fw-semibold text-blue">Bảng dữ liệu</div>

    <div class="card-body">
        <div class="datatable-top d-flex justify-content-between">
            <div class="datatable-dropdown">
                <select class="datatable-selector form-select">
                    <option value="5">5</option>
                    <option value="10" selected="">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>
            </div>
            <div class="datatable-search">
                <input class="form-control" placeholder="Search..." type="search">
            </div>
        </div>

        <div class="datatable-container mt-20">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <div class="form-check">
                                <input class="form-check-input" id="checkbox" type="checkbox">
                                <label class="form-check-label" for="checkbox"></label>
                            </div>
                        </th>
                        <th>STT</th>
                        <th>Tên nghệ sĩ</th>
                        <th>Cập nhật gần đây</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (! empty($artists)) {
                            foreach ($artists as $key => $artist) {
                                $key++;
                                ?>
                                    <tr data-index="<?php echo $key ?>">
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" id="checkbox-<?php echo $key ?>" type="checkbox" name="artist_ids[]" value="<?php echo $artist['id'] ?>">
                                                <label class="form-check-label" for="checkbox-<?php echo $key ?>"></label>
                                            </div>
                                        </td>
                                        <td><?php echo $key ?></td>
                                        <td><?php echo $artist['name'] ?></td>
                                        <td><?php echo date_format(date_create($artist['updated_at']), 'd-m-Y | H:i') ?></td>
                                        <td>
                                            <div class="d-flex position-relative">
                                                <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 show-options" data-index="<?php echo $key ?>">
                                                    <i class="fa-regular fa-ellipsis-vertical"></i>
                                                </button>

                                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="<?php echo route('adm-edit-artist', $artist['id']) ?>">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>

                                                <button class="btn btn-datatable btn-icon btn-transparent-dark delete-artist"
                                                    data-id="<?php echo $artist['id'] ?>"
                                                    data-url="<?php echo route('adm-delete-artist', $artist['id']) ?>">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>

                                                <?php require _namespace('artist.components.options-manage-artist') ?>
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

        <div class="datatable-bottom items-align-vertical-center-end mt-20">
            <?php require _namespace('components.adm.pagination') ?>
        </div>
    </div>
</div>