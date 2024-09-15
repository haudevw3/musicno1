const TABLE_MANAGE_PLAYLIST = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.tableManagePlaylist = $("#table-manage-playlist");
        self.deleteMultiplePlaylist = $("#delete-multiple-playlist");
        return self;
    }

    const bindFunction = function () {
        ctrls.tableManagePlaylist.find(".delete-playlist").on("click", deletePlaylist);
        ctrls.deleteMultiplePlaylist.on("click", deleteMultiplePlaylist);
    }

    const deletePlaylist = function () {
        var id = $(this).attr("data-id");
        var url = $(this).attr("data-url");
       
        _showDialog("Thông báo", "Bạn có muốn xóa danh sách phát này không? Khi xóa mọi dữ liệu liên quan sẽ bị mất vĩnh viễn.")
        .then(function (b) {
            if (b) {
                _apiDelete(url, {id: id}).then(function (res) {
                    if (res.message == "Success") {
                        window.location = "/playlists/list/page-1";
                        SESSION.set("message", "Xóa dữ liệu danh sách phát thành công.");
                    }
                });
            }
        });
    }

    const deleteMultiplePlaylist = function () {
        if (TABLE.getStateOfCheckbox()) {
            var url = $(this).attr("data-url");
            var array = ctrls.tableManagePlaylist.find("[name='playlist_ids[]']:checkbox:checked").map(function () {
                return $(this).val();
            }).get();

            var formData = new FormData;
            for (var i = 0; i < array.length; i++) {
                formData.append("playlist_ids[" + i + "]", array[i]);
            }
               
            _showDialog("Thông báo", "Bạn có muốn xóa những danh sách phát này không? Khi xóa mọi dữ liệu liên quan sẽ bị mất vĩnh viễn.")
            .then(function (b) {
                if (b) {
                    _apiUpload(url, formData).then(function (res) {
                        if (res.message == "Success") {
                            window.location = "/playlists/list/page-1";
                            SESSION.set("message", "Xóa dữ liệu danh sách phát thành công.");
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

TABLE_MANAGE_PLAYLIST.init();