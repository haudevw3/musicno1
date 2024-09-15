const FORM_MANAGE_CATEGORY = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.formManageCategory = $("#form-manage-category");
        self.submitFormCategory = $("#submit-form-category");
        return self;
    }

    const bindFunction = function () {
        ctrls.submitFormCategory.on("click", postFormCategory);
        ctrls.formManageCategory.find("[name=name]").on("change", convertNameToSlug);
        ctrls.formManageCategory.find("[name=type]").on("change", changeType);
    }

    const postFormCategory = function () {
        var id = ctrls.formManageCategory.attr("data-id");
        var url = ctrls.formManageCategory.attr("data-url");

        var tagIds = [];
        var nodeList = $("#text-box")[0].childNodes;
        nodeList.forEach(function (node) {
            if (node.nodeType == Node.ELEMENT_NODE) {
                tagIds.push(node.dataset.id);
            }
        });
        tagIds = (tagIds.length == 0) ? null : tagIds.join(',');

        var pages = ctrls.formManageCategory.find("[name='pages[]']:checkbox:checked").map(function () {
            return $(this).val();
        }).get();

        var data = {
            tag_ids: tagIds,
            pages: pages.join(','),
            name: _getValInput(ctrls.formManageCategory.find("[name=name]")),
            slug: _getValInput(ctrls.formManageCategory.find("[name=slug]")),
            type: _getValInput(ctrls.formManageCategory.find("[name=type]")),
            priority: _getValInput(ctrls.formManageCategory.find("[name=priority]")),
            parent_id: _getValInput(ctrls.formManageCategory.find("[name=parent_id]")),
            image: _getValInput(ctrls.formManageCategory.find("[name=image]"), false),
        }

        const required = [data.name, data.slug];
        if (! required.includes('')) {
            if (id > 0) {
                data = {...data, ...{id: id}};
                _apiUpdate(url, data).then(function (res) {
                    if (res.data == true) {
                        window.location = "/categories/list/page-1";
                        SESSION.set("message", "Cập nhật dữ liệu danh mục thành công.");
                    }
                });
            } else {
                _apiCreate(url, data).then(function (res) {
                    if (res.data == true) {
                        window.location = "/categories/list/page-1";
                        SESSION.set("message", "Tạo danh mục thành công.");
                    }
                });
            }
        } else {
            _showAlert("danger", "Vui lòng nhập đầy đủ thông tin của danh mục.");
        }
    }

    const convertNameToSlug = function () {
        var name = $(this).val();
        ctrls.formManageCategory.find("[name=slug]").val(_renderSlug(name));
    }

    const changeType = function () {
        var type = $(this).val();
        setTextBoxByType(type);
    }

    const setTextBoxByType = function (type) {
        var typeName = "";
        var url = "";
        var text = "";

        if (type == 1) {
            typeName = "danh sách phát";
            url = "/api/playlists/q/";
            ctrls.formManageCategory.find("[name=textbox]").attr("aria-placeholder", "Tìm kiếm theo tên danh sách phát...");
        } else if (type == 2) {
            typeName = "nghệ sĩ";
            url = "/api/artists/q/";
            ctrls.formManageCategory.find("[name=textbox]").attr("aria-placeholder", "Tìm kiếm theo tên nghệ sĩ...");
        } else if (type == 3) {
            typeName = "album";
            url = "/api/albums/q/";
            ctrls.formManageCategory.find("[name=textbox]").attr("aria-placeholder", "Tìm kiếm theo tên album...");
        }

        if (type == 0) {
            url = "";
            text = "Chọn loại danh mục để thực hiện chức năng này: ( được bỏ trống )";
            ctrls.formManageCategory.find("[name=textbox]").attr("aria-placeholder", "Tìm kiếm...");
        } else {
            text = `Gắn thẻ các ${typeName} để hiển thị: ( nhập @ và 1 kí tự đi kèm để tìm kiếm - được bỏ trống )`;
        }

        TEXT_BOX.init({url: url});
        ctrls.formManageCategory.find("#search label").text(text);
    }

    $(document).ready(function () {
        var type = ctrls.formManageCategory.find("[name=type]").val();
        setTextBoxByType(type);
    });

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
    }

})();

FORM_MANAGE_CATEGORY.init();