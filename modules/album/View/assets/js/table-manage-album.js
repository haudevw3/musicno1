const TABLE_MANAGE_ALBUM = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.tableManageAlbum = $("#table-manage-album");
        return self;
    }

    const bindFunction = function () {
        ctrls.tableManageAlbum.find(".delete-album").on("click", deleteAlbum);
        ctrls.tableManageAlbum.find("#delete-multiple-album").on("click", deleteMultipleAlbum);
    }

    const deleteAlbum = function () {
        var id = $(this).attr("data-id");
        var url = $(this).attr("data-url");
        
        _showDialog("Thông báo", "Bạn có muốn xóa album này không? Khi xóa mọi dữ liệu liên quan sẽ bị mất vĩnh viễn.")
        .then(function (b) {
            if (b) {
                _apiDelete(url, {id: id}).then(function (res) {
                    if (res.message == "Success") {
                        window.location = "/albums/list/page-1";
                        SESSION.set("message", "Xóa album thành công.");
                    }
                });
            }
        });
    }

    const deleteMultipleAlbum = function () {
        if (TABLE.getStateOfCheckbox()) {
            var url = $(this).attr("data-url");
            var array = ctrls.tableManageAlbum.find("[name='album_ids[]']:checkbox:checked").map(function () {
                return $(this).val();
            }).get();

            var formData = new FormData;
            for (var i = 0; i < array.length; i++) {
                formData.append("album_ids[" + i + "]", array[i]);
            }
                     
            _showDialog("Thông báo", "Bạn có muốn xóa những album này không? Khi xóa mọi dữ liệu liên quan sẽ bị mất vĩnh viễn.")
            .then(function (b) {
                if (b) {
                    _apiUpload(url, formData).then(function (res) {
                        if (res.message == "Success") {
                            window.location = "/albums/list/page-1";
                            SESSION.set("message", "Xóa album thành công.");
                        }
                    });
                }
            });
        } else {
            _showAlert("warning", "Vui lòng tích vào các ô để sử dụng chức năng này.");
        }
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
    }

})();

TABLE_MANAGE_ALBUM.init();