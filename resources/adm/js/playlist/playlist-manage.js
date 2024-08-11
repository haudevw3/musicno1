const PLAYLIST_MANAGE = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.deleteMultiplePlaylist = $(".delete-multiple-playlist");
        return self;
    }

    const bindFunction = function () {
        ctrls.deleteMultiplePlaylist.on("click", eventOnclickDeleteMultiplePlaylist);
    }

    const eventOnclickDeleteMultiplePlaylist = function () {
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

PLAYLIST_MANAGE.init();