<div id="fm" class="datatable fm animated-fade-in-up d-none">
    <div class="fm-container card bg-white rounded shadow mx-auto">
        <header class="fm-top card-header d-flex">
            <div class="fw-semibold col-3 items-align-vertical-center">Quản lý tập tin</div>
            <div class="col-9 items-align-vertical-center-end">
                <button class="btn btn-icon btn-primary mr-10" id="btn-fm-check" title="Xác nhận các lựa chọn">
                    <i class="fa-solid fa-check"></i>
                </button>

                <div class="input-group-file btn btn-icon bg-primary position-relative items-align-center">
                    <input type="file" class="btn-input" id="btn-fm-upload" title="Chọn tập tin" multiple>
                    <img width="15" height="15" class="position-absolute" src="{{ asset('images/icons/upload-solid.svg') }}">
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

            <div id="files-waiting-confirm" class="files-waiting-confirm border rounded p-10">
                <img class="thumbnail card"></img>
            </div>

            <div id="file-manager-table">
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

        <footer class="fm-bottom card-footer items-align-vertical-center-end">
            <button class="btn btn-secondary" type="button" id="btn-fm-cancle">Đóng</button>
            <button class="btn btn-warning d-none ml-10" type="button" id="btn-fm-destroy">Hủy bỏ</button>
            <button class="btn btn-primary d-none ml-10" type="button" id="btn-fm-confirm">Xác nhận</button>
        </footer>
    </div>
</div>