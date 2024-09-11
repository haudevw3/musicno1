const FILE_MANAGER = (function () {

    var ctrls = {};
    var inputName = null;
    const imageTypes = ["image/jpeg", "image/jpg", "image/png"];
    const audioTypes = ["audio/mpeg", "audio/mp3"];

    const bindControl = function () {
        var self = {};
        self.fm = $("#fm");
        self.ofm = $(".ofm");
        self.cfm = $("#cfm");
        self.dfm = $("#dfm");
        self.sfm = $("#sfm");
        self.fmCheck = $("#fm-check");
        self.fmTable = $("#fm-table");
        self.fmInput = $("#fm-input");
        self.fmLoading = $("#fm-loading");
        self.filesWaitingConfirm = $("#files-waiting-confirm");
        return self;
    }

    const bindFunction = function () {
        ctrls.ofm.on("click", showFileManager);
        ctrls.cfm.on("click", hiddenFileManager);
        ctrls.dfm.on("click", destroyProcessUploaded);
        ctrls.fmInput.on("change", uploadedFilesAndWaitingConfirm);
        ctrls.fmCheck.on("click", checkboxCheckedAndWaitingConfirm);
    }

    const uploadedFilesAndWaitingConfirm = function (e) {
        var files = e.target.files;
        var formData = new FormData;
        if (files.length > 0) {
            ctrls.fmTable.css({ display: "none" });
            ctrls.filesWaitingConfirm.css({ display: "grid" }).empty();
            $.each(files, function (i, file) {
                var fileReader = new FileReader;
                fileReader.onload = function (e) {
                    var src = e.target.result;
                    var html = `<img class="thumbnail card" src="${src}"></img>`;
                    ctrls.filesWaitingConfirm.append(html);
                }
                fileReader.readAsDataURL(file);
                formData.append("files[" + i + "]", file);
            });
            ctrls.dfm.css({ display: "block" });
            ctrls.sfm.css({ display: "block" });
            ctrls.sfm.on("click", function () {
                ctrls.fmLoading.css({ display: "flex" });
                // ctrls.filesWaitingConfirm.css({ display: "none" });
                var url = $(this).attr("data-url");
                _apiUpload(url, formData).then(function (res) {
                    if (res.message == "Success") {
                        setTimeout(function () {
                            _showAlert("success", "Tải tệp tin thành công.");
                            showFmTable();
                        }, 3000);
                    }
                });
            });
        }
    }

    const checkboxCheckedAndWaitingConfirm = function () {
        var array = ctrls.fmTable.find("[name='fm_links[]']:checkbox:checked").map(function () {
            return $(this).val();
        }).get();
        if (array.length == 0) {
            _showAlert("warning", "Vui lòng tích vào các ô để sử dụng chức năng này.");
        } else {
            var hasInvalidFileType = false;

            if (inputName == "audio" && array.length > 1) {
                _showAlert("warning", "Chỉ được chọn tối đa một tệp âm thanh.");
                return;
            }

            $.each(array, function (key, value) {
                const parts = value.split('.');
                const mimeType = inputName + "/" + parts[2];
                
                if ((inputName == "image" && imageTypes.indexOf(mimeType) == -1) ||
                    (inputName == "audio" && audioTypes.indexOf(mimeType) == -1)) {
                        _showAlert("warning", "Loại tệp tin không đúng định dạng. Vui lòng kiểm tra lại.");
                        hasInvalidFileType = true;
                        return;
                }
            });

            if (hasInvalidFileType) return;
            $("#" + inputName).find("input").val(array.join("|"));
            hiddenFileManager();
        }
    }

    const showFmTable = function () {
        ctrls.sfm.css({ display: "none" });
        ctrls.dfm.css({ display: "none" });
        ctrls.fmLoading.css({ display: "none" });
        ctrls.filesWaitingConfirm.css({ display: "none" });
        _apiGet("/api/upload/list", {}).then(function (res) {
            if (res.message == "Success") {
                var html = "";
                $.each(res.data, function (key, value) {
                    let [mime, type] = value.type.split('/');
                    let [date, time] = value.updated_at.split(' ')
                    let [year, month, day] = date.split('-');
                    html += `
                    <tr>
                        <td class="col-1">
                            <div class="form-check">
                                <input class="form-check-input" id="checkbox-${key}" type="checkbox" value="${value.link}" name="fm_links[]">
                                <label class="form-check-label" for="checkbox-${key}"></label>
                            </div>
                        </td>
                        <td class="col-4"><div style="width: 200px;" class="text-overflow-on-one-line">${value.name}</div></td>
                        <td class="col-2">${type}</td>
                        <td class="col-3">${day}-${month}-${year} | ${time}</td>
                        <td class="col-2">
                            <div class="d-flex">
                                <a class="btn-table center-align-items" href="${value.link}" target="_blank">
                                    <i class="fa-regular fa-link"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`;
                });
                ctrls.fmTable.find("tbody").html(html).end().css({ display: "block" });
            }
        });
    }

    const showFileManager = function () {
        inputName = $(this).attr("name");
        ctrls.fm.css({ display: "block" });
        showFmTable();
    }

    const hiddenFileManager = function () {
        ctrls.fm.css({ display: "none" });
    }

    const destroyProcessUploaded = function () {
        ctrls.filesWaitingConfirm.empty();
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
    }

})();

FILE_MANAGER.init();