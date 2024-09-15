const UI_CONTROL = (function () {

    var ctrls = {};
    var isToggleSidenav = false;

    const bindControl = function () {
        var self = {};
        self.overlay = $("#overlay");
        self.topnav = $("#topnav");
        self.sidenav = $("#sidenav");
        self.sidenavToggle = $("#sidenav-toggle");
        self.mainContent = $("#main-content");
        return self;
    }

    const bindFunction = function () {
        ctrls.overlay.on("click", removeAllStateCurrent);
        ctrls.sidenavToggle.on("click", toggleStateOfSidebar);
    }

    const toggleStateOfSidebar = function () {
        if (! isToggleSidenav) {
            isToggleSidenav = true;
            ctrls.sidenav.css({transform: "translateX(-240px)"});
            ctrls.topnav.find(".left").css({ padding: "20px 5px" });
            ctrls.mainContent.css({width: "100%", "margin-left": 0});
        } else {
            isToggleSidenav = false;
            ctrls.sidenav.css({transform: "translateX(0)"});
            ctrls.topnav.find(".left").css({ padding: "20px" });
            ctrls.mainContent.css({width: "calc(100% - 240px)", "margin-left": "240px"});
        }
    }

    const removeAllStateCurrent = function () {
        TABLE.removeStateOfTable();
        ctrls.overlay.css({ display: "none" });
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
    }

})();

UI_CONTROL.init();