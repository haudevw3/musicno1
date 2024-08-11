const USER_MANAGE = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.deleteMultipleUser = $(".delete-multiple-user");
        return self;
    }

    const bindFunction = function () {
        ctrls.deleteMultipleUser.on("click", eventOnclickDeleteMultipleUser);
    }

    const eventOnclickDeleteMultipleUser = function () {
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

USER_MANAGE.init();