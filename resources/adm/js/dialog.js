const DIALOG = (function () {

    var ctrls = {};
    var vals = {};

    const bindControl = function () {
        var self = {};
        self.dialogHide = $(".dialog-hide");
        self.dialogWrapper = $(".dialog-wrapper");
        self.dialogContainer = $(".dialog-container");
        return self;
    }

    const bindFunction = function () {
        ctrls.dialogHide.on("click", hide);
    }

    const show = function (url, id = null) {
        set({ display: "block" });
        if (id == null) {
            ctrls.dialogContainer.find(".agree a").attr("href", url);
        } else {
            ctrls.dialogContainer.find(".agree").on("click", function () {
                $(id).attr("action", url).submit();
            });
        }
    }

    const set = function (attr) {
        ctrls.dialogWrapper.css(attr);
        ctrls.dialogContainer.css(attr);
    }

    const hide = function () {
        set({ display: "none" });
        $(vals.subject).removeClass(vals.name);
    }

    function bindVals(_vals) {
        var self = $.extend({}, {}, _vals);
        return self;
    }

    function init(_vals) {
        ctrls = bindControl();
        vals = bindVals(_vals);
        bindFunction();
    }

    return {
        init: init,
        show: show,
        set: set,
    }

})();