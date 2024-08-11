const ARTIST_MANAGE = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.deleteMultipleArtist = $(".delete-multiple-artist");
        return self;
    }

    const bindFunction = function () {
        ctrls.deleteMultipleArtist.on("click", eventOnclickDeleteMultipleArtist);
    }

    const eventOnclickDeleteMultipleArtist = function () {
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

ARTIST_MANAGE.init();