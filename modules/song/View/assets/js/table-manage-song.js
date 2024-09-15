const TABLE_MANAGE_SONG = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.tableManageSong = $("#table-manage-song");
        self.deleteMultipleSong = $("#delete-multiple-song");
        return self;
    }

    const bindFunction = function () {
        ctrls.tableManageSong.find(".delete-song").on("click", deleteSong);
        ctrls.deleteMultipleSong.on("click", deleteMultipleSong);
    }

    const deleteSong = function () {
        var id = $(this).attr("data-id");
        var url = $(this).attr("data-url");
        
        _showDialog("Thông báo", "Bạn có muốn xóa bài hát này không? Khi xóa mọi dữ liệu liên quan sẽ bị mất vĩnh viễn.")
        .then(function (b) {
            if (b) {
                _apiDelete(url, {id: id}).then(function (res) {
                    if (res.message == "Success") {
                        window.location = "/songs/list/page-1";
                        SESSION.set("message", "Xóa bài hát thành công.");
                    }
                });
            }
        });
    }

    const deleteMultipleSong = function () {
        if (TABLE.getStateOfCheckbox()) {
            var url = $(this).attr("data-url");
            var array = ctrls.tableManageSong.find("[name='song_ids[]']:checkbox:checked").map(function () {
                return $(this).val();
            }).get();

            var formData = new FormData;
            for (var i = 0; i < array.length; i++) {
                formData.append("song_ids[" + i + "]", array[i]);
            }
               
            _showDialog("Thông báo", "Bạn có muốn xóa những bài hát này không? Khi xóa mọi dữ liệu liên quan sẽ bị mất vĩnh viễn.")
            .then(function (b) {
                if (b) {
                    _apiUpload(url, formData).then(function (res) {
                        if (res.message == "Success") {
                            window.location = "/songs/list/page-1";
                            SESSION.set("message", "Xóa bài hát thành công.");
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

TABLE_MANAGE_SONG.init();