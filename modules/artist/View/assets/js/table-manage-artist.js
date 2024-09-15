const TABLE_MANAGE_ARTIST = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.tableManageArtist = $("#table-manage-artist");
        self.deleteMultipleArtist = $("#delete-multiple-artist");
        return self;
    }

    const bindFunction = function () {
        ctrls.tableManageArtist.find(".delete-artist").on("click", deleteArtist);
        ctrls.deleteMultipleArtist.on("click", deleteMultipleArtist);
    }

    const deleteArtist = function () {
        var id = $(this).attr("data-id");
        var url = $(this).attr("data-url");
       
        _showDialog("Thông báo", "Bạn có muốn xóa nghệ sĩ này không? Khi xóa mọi dữ liệu liên quan sẽ bị mất vĩnh viễn.")
        .then(function (b) {
            if (b) {
                _apiDelete(url, {id: id}).then(function (res) {
                    if (res.message == "Success") {
                        window.location = "/artists/list/page-1";
                        SESSION.set("message", "Xóa nghệ sĩ thành công.");
                    }
                });
            }
        });
    }

    const deleteMultipleArtist = function () {
        if (TABLE.getStateOfCheckbox()) {
            var url = $(this).attr("data-url");
            var array = ctrls.tableManageArtist.find("[name='artist_ids[]']:checkbox:checked").map(function () {
                return $(this).val();
            }).get();

            var formData = new FormData;
            for (var i = 0; i < array.length; i++) {
                formData.append("artist_ids[" + i + "]", array[i]);
            }
            
            _showDialog("Thông báo", "Bạn có muốn xóa những nghệ sĩ này không? Khi xóa mọi dữ liệu liên quan sẽ bị mất vĩnh viễn.")
            .then(function (b) {
                if (b) {
                    _apiUpload(url, formData).then(function (res) {
                        if (res.message == "Success") {
                            window.location = "/artists/list/page-1";
                            SESSION.set("message", "Xóa nghệ sĩ thành công.");
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

TABLE_MANAGE_ARTIST.init();