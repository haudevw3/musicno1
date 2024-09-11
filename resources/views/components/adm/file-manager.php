<div id="fm" class="file-manager animated-fade-in-up">
    <div class="fm-container bg-white rounded shadow mx-auto">
        <header class="fm-header d-flex justify-content-between p-20 rounded-top">
            <div class="fs-16 fw-semibold text-blue">Quản lý tập tin</div>
            <div class="fm-actions vertical-center-align-items">
                <button class="btn btn-icon btn-primary bg-primary mr-10" id="fm-check" title="Xác nhận các lựa chọn">
                    <i class="fa-solid fa-check"></i>
                </button>
                <div class="input-group-file btn-icon bg-blue position-relative center-align-items">
                    <input type="file" title="Chọn tập tin" id="fm-input" multiple>
                    <img width="15" height="15" class="position-absolute" src="<?php echo asset('images/icons/upload-solid.svg') ?>">
                </div>
            </div>
        </header>
        <main class="fm-content p-20 position-relative scroll-bar">
            <div id="fm-loading" class="fm-loading position-absolute center-align-items">
                <div class="card col-2 p-20 rounded-4 center-align-items">
                    <div class="loader"></div>
                    <div class="loader-text fs-16 fw-semibold"></div>
                </div>
            </div>
            <div id="files-waiting-confirm" class="files-waiting-confirm border rounded p-10"></div>
            <div id="fm-table" class="fm-table">
                <table>
                    <thead>
                        <tr>
                            <th class="col-1"></th>
                            <th class="col-4">Tên tập tin</th>
                            <th class="col-2">Loại</th>
                            <th class="col-3">Cập nhật gần đây</th>
                            <th class="col-2">Hành động</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </main>
        <footer class="fm-footer vertical-center-align-items-end p-20">
            <button class="btn btn-secondary" type="button" id="cfm">Đóng</button>
            <button class="btn btn-warning" type="button" id="dfm"
                style="display: none; margin-left: 10px;">Hủy bỏ</button>
            <button class="btn btn-primary" type="button" id="sfm"
                style="display: none; margin-left: 10px;"
                data-url="<?php echo route('adm-create-file') ?>">Xác nhận</button>
        </footer>
    </div>
</div>