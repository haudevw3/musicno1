const ALERT = (function () {

    var ctrls = {};
    const PRIMARY = "PRIMARY";
    const SUCCESS = "SUCCESS";
    const DANGER = "FAIL";
    const WARNING = "WARNING";

    const bindControl = function () {
        var self = {};
        self.alertData = $(".alert-data");
        self.alert = $(".alert");
        return self;
    }

    const bindFunction = function () {

    }

    const set = function () {
        var key = ctrls.alertData.data("key");
        var message = ctrls.alertData.data("message");
        if (key != '' && message != '') {
            show(key, message);
        }
    }

    const show = function (key, message) {
        if (key == PRIMARY) {
            ctrls.alert.addClass("alert-primary");
        } else if (key == SUCCESS) {
            ctrls.alert.addClass("alert-success");
        } else if (key == DANGER) {
            ctrls.alert.addClass("alert-danger");
        } else if (key == WARNING) {
            ctrls.alert.addClass("alert-warning");
        }

        ctrls.alert.text(message).css({ display: "block" });

        setTimeout(function () {
            ctrls.alert.css({ display: "none" });
        }, 3000)
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    $(document).ready(function () {
        set();
    });

    return {
        init: init,
        show: show,
        PRIMARY: PRIMARY,
        SUCCESS: SUCCESS,
        ERROR: DANGER,
        WARNING: WARNING
    }

})();

ALERT.init();