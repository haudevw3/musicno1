const UI_CONTROL = (function () {

    var ctrls = {};
    var isToggle = true;

    const bindControl = function () {
        var self = {};
        self.header = $(".header");
        self.navbar = $(".nav-bar");
        self.content = $(".content");
        return self;
    }

    const bindFunction = function () {
        ctrls.header.find(".box-bar").on("click", toggleDisplayMode);
        ctrls.header.find(".box-user").on("click", showDropdownMenu);
        ctrls.header.find(".wrapper").on("click", hideDropdownMenu);
    }

    const toggleDisplayMode = function () {
        if (isToggle) {
            isToggle = false;
            $(this).addClass("header-focus");
            ctrls.navbar.css({transform: "translateX(-240px)"});
            ctrls.content.css({width: "100%", "margin-left": 0});
            ctrls.content.find(".content-top").css({ padding: "20px 80px" });
            ctrls.content.find(".content-body").css({ padding: "20px 80px" });
        } else {
            isToggle = true;
            $(this).removeClass("header-focus");
            ctrls.navbar.css({transform: "translateX(0)"});
            ctrls.content.css({width: "calc(100% - 240px)", "margin-left": "240px"});
            ctrls.content.find(".content-top").css({ padding: "20px" });
            ctrls.content.find(".content-body").css({ padding: "20px" });
        }
    }

    const showDropdownMenu = function () {
        setDropdownMenu("block");
        $(this).addClass("header-focus");
    }

    const hideDropdownMenu = function () {
        setDropdownMenu("none");
        ctrls.header.find(".box-user").removeClass("header-focus");
    }

    const setDropdownMenu = function (value) {
        ctrls.header.find(".wrapper").css({ display: value });
        ctrls.header.find(".dropdown-menu").css({ display: value });
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
    }

})();

UI_CONTROL.init();