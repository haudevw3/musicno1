const CATEGORIES_MANAGER = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.deleteMultipleCategory = $(".delete-multiple-category");
        return self;
    }

    const bindFunction = function () {
        ctrls.deleteMultipleCategory.on("click", eventOnclickDeleteMultipleCategory);
    }

    const eventOnclickDeleteMultipleCategory = function () {
        if (TABLE.getStatusChecbox()) {
            var url = $(this).attr("data-url");
            DIALOG.show(url, "#form-container");
        } else {
            ALERT.show(ALERT.WARNING, "Vui lòng tích vào các ô để sử dụng chức năng này.");
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

CATEGORIES_MANAGER.init();