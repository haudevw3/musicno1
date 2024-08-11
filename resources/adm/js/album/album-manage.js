const ALBUM_MANAGE = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.deleteMultipleAlbum = $(".delete-multiple-album");
        return self;
    }

    const bindFunction = function () {
        ctrls.deleteMultipleAlbum.on("click", eventOnclickDeleteMultipleAlbum);
    }

    const eventOnclickDeleteMultipleAlbum = function () {
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

ALBUM_MANAGE.init();