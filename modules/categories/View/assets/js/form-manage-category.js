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
    }

    const postFormCategory = function () {
        var id = ctrls.formManageCategory.attr("data-id");
        var url = ctrls.formManageCategory.attr("data-url");
        var tags = ctrls.formManageCategory.find("[name='tags[]']:checkbox:checked").map(function () {
            return $(this).val();
        }).get();
        var data = {
            name: _getValInput(ctrls.formManageCategory.find("[name=name]")),
            slug: _getValInput(ctrls.formManageCategory.find("[name=slug]")),
            type: _getValInput(ctrls.formManageCategory.find("[name=type]")),
            priority: _getValInput(ctrls.formManageCategory.find("[name=priority]")),
            parent_id: _getValInput(ctrls.formManageCategory.find("[name=parent_id]")),
            image: _getValInput(ctrls.formManageCategory.find("[name=image]"), false),
            tags: tags.join(',')
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
        var name = _getValInput(ctrls.formManageCategory.find("[name=name]"));
        ctrls.formManageCategory.find("[name=slug]").val(_renderSlug(name));
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
    }

})();

FORM_MANAGE_CATEGORY.init();