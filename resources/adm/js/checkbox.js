const CHECKBOX = (function () {

    var ctrls = {};
    var rows = 0;

    const bindControl = function () {
        var self = {};
        self.checkboxContainer = $(".checkbox-container");
        self.checkboxOnce = $(".checkbox-once");
        return self;
    }

    const bindFunction = function () {
        ctrls.checkboxOnce.on("click", eventOnclickChecboxOnce);
    }

    const eventOnclickChecboxOnce = function () {
        var key = $(this).attr("data-key");
        for (var i = 1; i <= rows; i++) {
            if (key == i) {
                continue;
            }
            var id = "#checkbox-" + i;
            $(id).prop("checked", false);
        }
    }

    $(document).ready(function () {
        rows = ctrls.checkboxContainer.attr("data-rows");
    });

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
    }
})();

CHECKBOX.init();