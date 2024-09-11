const TABLE_MANAGE_CATEGORY = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.tableManageCategory = $("#table-manage-category");
        return self;
    }

    const bindFunction = function () {
        ctrls.tableManageCategory.find(".delete-category").on("click", deleteCategory);
        ctrls.tableManageCategory.find("#delete-multiple-category").on("click", deleteMultipleCategory);
    }

    const deleteCategory = function () {
        var id = $(this).attr("data-id");
        var url = $(this).attr("data-url");
        UI_CONTROL.addStateFocusOfButton(true, this);
        _showDialog("Thông báo", "Bạn có muốn xóa danh mục này không? Khi xóa mọi dữ liệu liên quan sẽ bị mất vĩnh viễn.")
        .then(function (b) {
            if (b) {
                _apiDelete(url, {id: id}).then(function (res) {
                    if (res.message == "Success") {
                        window.location = "/categories/list/page-1";
                        SESSION.set("message", "Xóa danh mục thành công.");
                    }
                });
            }
            TABLE.removeStateOfTable();
        });
    }

    const deleteMultipleCategory = function () {
        if (TABLE.getStateOfCheckbox()) {
            var url = $(this).attr("data-url");
            var array = ctrls.tableManageCategory.find("[name='category_ids[]']:checkbox:checked").map(function () {
                return $(this).val();
            }).get();
            var formData = new FormData;
            for (var i = 0; i < array.length; i++) {
                formData.append("category_ids[" + i + "]", array[i]);
            }            
            _showDialog("Thông báo", "Bạn có muốn xóa những danh mục này không? Khi xóa mọi dữ liệu liên quan sẽ bị mất vĩnh viễn.")
            .then(function (b) {
                if (b) {
                    _apiUpload(url, formData).then(function (res) {
                        if (res.message == "Success") {
                            window.location = "/categories/list/page-1";
                            SESSION.set("message", "Xóa danh mục thành công.");
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

TABLE_MANAGE_CATEGORY.init();