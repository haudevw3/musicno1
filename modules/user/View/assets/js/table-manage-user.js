const TABLE_MANAGE_USER = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.tableManageUser = $("#table-manage-user");
        return self;
    }

    const bindFunction = function () {
        ctrls.tableManageUser.find(".delete-user").on("click", deleteUser);
        ctrls.tableManageUser.find("#delete-multiple-user").on("click", deleteMultipleUser);
    }

    const deleteUser = function () {
        var id = $(this).attr("data-id");
        var url = $(this).attr("data-url");
        UI_CONTROL.addStateFocusOfButton(true, this);
        _showDialog("Thông báo", "Bạn có muốn xóa tài khoản này không? Khi xóa mọi dữ liệu liên quan sẽ bị mất vĩnh viễn.")
        .then(function (b) {
            if (b) {
                _apiDelete(url, {id: id}).then(function (res) {
                    if (res.message == "Success") {
                        window.location = "/users/list/page-1";
                        SESSION.set("message", "Xóa dữ liệu tài khoản thành công.");
                    }
                });
            }
            TABLE.removeStateOfTable();
        });
    }

    const deleteMultipleUser = function () {
        if (TABLE.getStateOfCheckbox()) {
            var url = $(this).attr("data-url");
            var array = ctrls.tableManageUser.find("[name='user_ids[]']:checkbox:checked").map(function () {
                return $(this).val();
            }).get();
            var formData = new FormData;
            for (var i = 0; i < array.length; i++) {
                formData.append("user_ids[" + i + "]", array[i]);
            }            
            _showDialog("Thông báo", "Bạn có muốn xóa những tài khoản này không? Khi xóa mọi dữ liệu liên quan sẽ bị mất vĩnh viễn.")
            .then(function (b) {
                if (b) {
                    _apiUpload(url, formData).then(function (res) {
                        if (res.message == "Success") {
                            window.location = "/users/list/page-1";
                            SESSION.set("message", "Xóa dữ liệu tài khoản thành công.");
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

TABLE_MANAGE_USER.init();