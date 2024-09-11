const UI_CONTROL = (function () {

    var ctrls = {};
    var isToggle = false;
    var isShowNavbarDropdownOfUser = false;

    const bindControl = function () {
        var self = {};
        self.overlay = $("#overlay");
        self.topnav = $("#topnav");
        self.sidenav = $("#sidenav");
        self.sidenavToggle = $("#sidenav-toggle");
        self.mainContent = $("#main-content");
        self.pageHeader = $("#page-header");
        self.pageMainContent = $("#page-main-content");
        self.navbarDropdownUserImage = $("#navbar-dropdown-user-image");
        return self;
    }

    const bindFunction = function () {
        ctrls.sidenavToggle.on("click", toggleStateOfSidebar);
        ctrls.navbarDropdownUserImage.on("click", showNavbarDropdownOfUser);
        ctrls.overlay.on("click", removeAllStatePrevious);
    }

    const toggleStateOfSidebar = function () {
        if (! isToggle) {
            isToggle = true;
            addStateFocusOfButton(true, this);
            ctrls.sidenav.css({transform: "translateX(-240px)"});
            ctrls.mainContent.css({width: "100%", "margin-left": 0});
            ctrls.pageHeader.css({ padding: "20px 80px" });
            ctrls.pageMainContent.css({ padding: "20px 80px" });
        } else {
            isToggle = false;
            addStateFocusOfButton(false, this);
            ctrls.sidenav.css({transform: "translateX(0)"});
            ctrls.mainContent.css({width: "calc(100% - 240px)", "margin-left": "240px"});
            ctrls.pageHeader.css({ padding: "20px" });
            ctrls.pageMainContent.css({ padding: "20px" });
        }
    }

    const showNavbarDropdownOfUser = function () {
        if (! isShowNavbarDropdownOfUser) {
            isShowNavbarDropdownOfUser = true;
            addStateFocusOfButton(true, this);
            ctrls.overlay.css({ display: "block" });
            ctrls.navbarDropdownUserImage.find(".dropdown-menu").css({ display: "block" });
        } else {
            isShowNavbarDropdownOfUser = false;
            addStateFocusOfButton(false, this);
            ctrls.overlay.css({ display: "none" });
            ctrls.navbarDropdownUserImage.find(".dropdown-menu").css({ display: "none" });
        }
    }

    const removeAllStatePrevious = function () {
        if (isShowNavbarDropdownOfUser) {
            isShowNavbarDropdownOfUser = false;
            addStateFocusOfButton(false, ctrls.navbarDropdownUserImage);
            ctrls.navbarDropdownUserImage.find(".dropdown-menu").css({ display: "none" });
        }

        if (TABLE.getIsShowOptions()) {
            TABLE.removeStateOfTable();
        }

        ctrls.overlay.css({ display: "none" });
    }

    const overlay = function () {
        return ctrls.overlay;
    }

    const addStateFocusOfButton = function (status, subject) {
        if (status) {
            $(subject).addClass("btn-icon-focus");
        } else {
            $(subject).removeClass("btn-icon-focus");
        }
    }

    $(document).ready(function () {
        if (SESSION.get("message")) {
            _showAlert("success", SESSION.get("message"));
            SESSION.remove("message");
        }
    });

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        overlay: overlay,
        addStateFocusOfButton: addStateFocusOfButton
    }

})();

UI_CONTROL.init();