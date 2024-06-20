const CATEGORIES_MANAGER = (function () {

    var ctrls = {};
    var rows = 0;

    const bindControl = function () {
        var self = {};
        self.table = $("#table-categories");
        self.wrapper = self.table.find(".wrapper");
        self.chooseDetailCategory = self.table.find(".choose-detail-category");
        self.chooseDeleteCategory = self.table.find(".choose-delete-category");
        self.chooseDeleteMultipleCategory = self.table.find(".delete-multiple-category");
        return self;
    }

    const bindFunction = function () {
        ctrls.chooseDetailCategory.on("click", chooseDetailCategory);
        ctrls.chooseDeleteCategory.on("click", chooseDeleteCategory);
        ctrls.chooseDeleteMultipleCategory.on("click", chooseDeleteMultipleCategory);
    }

    const chooseDetailCategory = function () {
        var id = $(this).attr("row-id");
        var rowId = "#row-" + id;
        addFocusButton(true, this);
        $(rowId).find(".dropdown-menu-" + id).css({display: "block"});
        ctrls.wrapper.css({display: "block"});
        ctrls.wrapper.on("click", function () {
            ctrls.wrapper.css({ display: "none" });
            addFocusButton(false, ctrls.chooseDetailCategory);
            $(rowId).find(".dropdown-menu-" + id).css({display: "none"});
        })
    }

    const chooseDeleteCategory = function () {
        var url = $(this).attr("data-url");
        addFocusButton(true, this);
        DIALOG.show(url);
    }

    const addFocusButton = function (status, subject) {
        if (status) {
            $(subject).addClass("btn-sm-01-focus");
        } else {
            $(subject).removeClass("btn-sm-01-focus");
        }
    }

    const chooseDeleteMultipleCategory = function () {
        if (TABLE.getStatusChecbox()) {
            var url = $(this).attr("data-url");
            DIALOG.show(url, "#form-category");
        } else {
            ALERT.show(ALERT.WARNING, "Vui lòng tích vào các ô để sử dụng chức năng này.");
        }
    }

    $(document).ready(function () {
        rows = TABLE.getRows();
        ctrls.table.wrap("<form id='form-category' method='post'></form>");
        DIALOG.init({
            subject: ctrls.chooseDeleteCategory,
            name: "btn-sm-01-focus"
        })
    })

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        addFocusButton: addFocusButton
    }

})();

CATEGORIES_MANAGER.init();