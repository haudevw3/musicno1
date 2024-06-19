const USER_MANAGER = (function () {

    var ctrls = {};
    var rows = 0;
    var isClickCheckbox = false;

    const bindControl = function () {
        var self = {};

        self.table = $(".table-container");
        self.chooseAllUser = $(".table-container #choose-all-user");

        return self;
    }

    const bindFunction = function () {
        ctrls.chooseAllUser.on("click", chooseAllUser);
    }

    const chooseAllUser = function () {
        console.log(rows);
    }

    const setStatusCheckbox = function (isClickCheckbox) {
        for (var i = 0; i <= rows; i++) {
            var id = "#check-box-" + i;

            $(id).prop("checked", isClickCheckbox);
        }
    }

    const getStatusCheckbox = function () {
        var status = false;

        if (isClickCheckbox) {
            status = true;
        }

        for (var i = 0; i <= rows; i++) {
            var id = "#check-box-" + i;

            if ($(id).prop("checked")) {
                status = true;

                break;
            } else {
                status = false;
            }
        }

        return status;
    }

    const handleCheckbox = function () {
        if (! isClickCheckbox) {
            isClickCheckbox = true;

            setStatusCheckbox(isClickCheckbox);
        } else {
            isClickCheckbox = false;

            setStatusCheckbox(isClickCheckbox);
        }
    }

    const handleButton = function () {
        var id = "#" + $(this).attr("data-id");
        openDropdownMenu(id);
        closeDropdownMenu(id);
    }

    const openDropdownMenu = function (id) {
        setDisplayDropdownMenu(id, 'block');
    }

    const closeDropdownMenu = function (id) {
        $(id).find(".wrapper").on("click", function () {
            setDisplayDropdownMenu(id, 'none');
        });
    }

    const setDisplayDropdownMenu = function (id, value) {
        $(id).find(".wrapper").css({ display: value });
        $(id).find(".dropdown-menu").css({ display: value });
    }

    $(document).ready(function () {
        rows = ctrls.table.find("tr:last td:eq(1)").text();

        console.log(rows);
    })

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        getStatusCheckbox: getStatusCheckbox,
        setStatusCheckbox: setStatusCheckbox
    }

})();

USER_MANAGER.init();