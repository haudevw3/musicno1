<div id="fm" class="file-manager animated-fade-in-up">
    <div class="fm-container card bg-white rounded shadow mx-auto">
        <header class="fm-header card-header d-flex">
            <div class="fs-16 fw-semibold text-blue col-3 items-align-vertical-center">Quản lý tập tin</div>
            <div class="fm-actions col-9 items-align-vertical-center-end">
                <button class="btn btn-icon btn-primary mr-10" id="fm-check" title="Xác nhận các lựa chọn">
                    <i class="fa-solid fa-check"></i>
                </button>

                <div class="input-group-file btn-icon bg-red position-relative items-align-center">
                    <input type="file" title="Chọn tập tin" id="fm-input" multiple>
                    <img width="15" height="15" class="position-absolute" src="<?php echo asset('images/icons/upload-solid.svg') ?>">
                </div>
            </div>
        </header>

        <main class="fm-content card-body position-relative scroll-bar">
            <div id="fm-loading" class="fm-loading position-absolute items-align-center">
                <div class="card items-align-center rounded-3 p-10 col-2">
                    <div class="loader-dot"></div>
                    <div class="loader-classic fw-semibold"></div>
                </div>
            </div>
            <div id="files-waiting-confirm" class="files-waiting-confirm border rounded p-10"></div>
            <div id="fm-table" class="fm-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tên tập tin</th>
                            <th>Loại</th>
                            <th>Cập nhật gần đây</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </main>

        <footer class="fm-footer card-footer items-align-vertical-center-end">
            <button class="btn btn-secondary" type="button" id="cfm">Đóng</button>
            <button class="btn btn-warning" type="button" id="dfm"
                style="display: none; margin-left: 10px;">Hủy bỏ</button>
            <button class="btn btn-primary" type="button" id="sfm"
                style="display: none; margin-left: 10px;"
                data-url="<?php echo route('adm-create-file') ?>">Xác nhận</button>
        </footer>
    </div>
</div>