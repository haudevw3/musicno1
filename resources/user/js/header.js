const HEADER = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.header = $(".header");
        self.boxUser = self.header.find(".box-user");
        self.wrapper = self.header.find(".wrapper");
        self.dropdownMenu = self.header.find(".dropdown-menu");
        return self;
    }

    const bindFunction = function () {
        ctrls.boxUser.on("click", showDropdownMenu);
        ctrls.wrapper.on("click", hideDropdownMenu);
    }

    const showDropdownMenu = function () {
        setDropdownMenu("block");
    }

    const hideDropdownMenu = function () {
        setDropdownMenu("none");
    }

    const setDropdownMenu = function (value) {
        ctrls.wrapper.css({ display: value });
        ctrls.dropdownMenu.css({ display: value });
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init
    }

})();

HEADER.init();