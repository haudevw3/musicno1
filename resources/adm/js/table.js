const TABLE = (function () {

    var ctrls = {};
    var rows = 0;
    var status = false;

    const bindControl = function () {
        var self = {};
        self.table = $(".table-container");
        self.wrapper = self.table.find(".wrapper");
        self.checkbox = self.table.find("#checkbox-all");
        self.showOptions = self.table.find(".show-options");
        self.showModal = self.table.find(".show-modal");
        return self;
    }

    const bindFunction = function () {
        ctrls.checkbox.on("click", eventOnclickCheckboxAll);
        ctrls.showOptions.on("click", eventOnclickShowOptions);
        ctrls.showModal.on("click", eventOnclickShowModal);
    }

    const eventOnclickCheckboxAll = function () {
        if (!status) {
            status = true;
        } else {
            status = false;
        }
        setStatusCheckbox(status);
    }

    const setStatusCheckbox = function (status) {
        for (var i = 0; i <= rows; i++) {
            var id = "#checkbox-" + i;
            $(id).prop("checked", status);
        }
    }

    const getStatusChecbox = function () {
        var check = false;
        if (status) {
            check = true;
        }
        for (var i = 0; i <= rows; i++) {
            var id = "#checkbox-" + i;
            if ($(id).prop("checked")) {
                check = true;
                break;
            } else {
                check = false;
            }
        }
        return check;
    }

    const addFocusButton = function (status, subject) {
        if (status) {
            $(subject).addClass("table-btn-focus");
        } else {
            $(subject).removeClass("table-btn-focus");
        }
    }

    const eventOnclickShowOptions = function () {
        var id = $(this).attr("row-id");
        var rowId = "#row-" + id;
        addFocusButton(true, this);
        $(rowId).find(".dropdown-menu-" + id).css({display: "block"});
        ctrls.wrapper.css({display: "block"});
        ctrls.wrapper.on("click", function () {
            ctrls.wrapper.css({ display: "none" });
            addFocusButton(false, ctrls.showOptions);
            $(rowId).find(".dropdown-menu-" + id).css({display: "none"});
        })
    }

    const eventOnclickShowModal = function () {
        var url = $(this).attr("data-url");
        addFocusButton(true, this);
        DIALOG.show(url);
    }

    $(document).ready(function () {
        rows = ctrls.table.find("tr:last td:eq(1)").text();
        ctrls.table.wrap("<form id='form-container' method='post'></form>");
        DIALOG.init({
            subject: ctrls.showModal,
            name: "table-btn-focus"
        });
    })

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        getStatusChecbox: getStatusChecbox,
    }

})();

TABLE.init();