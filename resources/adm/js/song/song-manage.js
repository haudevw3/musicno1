const SONG_MANAGE = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.deleteMultipleSong = $(".delete-multiple-song");
        return self;
    }

    const bindFunction = function () {
        ctrls.deleteMultipleSong.on("click", eventOnclickDeleteMultipleSong);
    }

    const eventOnclickDeleteMultipleSong = function () {
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

SONG_MANAGE.init();