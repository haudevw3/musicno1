const NAVBAR = (function () {

    var ctrls = {};
    var status = true;
    var alias = null;

    const bindControl = function () {
        var self = {};
        self.boxbar = $(".header .box-bar");
        self.navbar = $(".nav-bar");
        self.content = $(".content");
        return self;
    }

    const bindFunction = function () {
        ctrls.boxbar.on("click", eventOnclickChangeToogle);
        ctrls.navbar.find(".nav-link").on("click", eventOnclickNavlink);
    }

    const eventOnclickChangeToogle = function () {
        if (status) {
            status = false;
            $(this).addClass("header-focus");
            ctrls.navbar.css({transform: "translateX(-240px)"});
            ctrls.content.css({width: "100%", "margin-left": 0});
            ctrls.content.find(".content-top").css({ padding: "20px 80px" });
            ctrls.content.find(".content-body").css({ padding: "20px 80px" });
        } else {
            status = true;
            $(this).removeClass("header-focus");
            ctrls.navbar.css({transform: "translateX(0)"});
            ctrls.content.css({width: "calc(100% - 240px)", "margin-left": "240px"});
            ctrls.content.find(".content-top").css({ padding: "20px" });
            ctrls.content.find(".content-body").css({ padding: "20px" });
        }
    }
    
    const eventOnclickNavlink = function () {
        alias = $(this).attr("data-alias");
        localStorage.setItem("alias", alias);
    }

    const focusNavlinkWhileOnlick = function (subject, alias) {
        ctrls.navbar.find(".nav-link").removeClass("bg-color-gray");
        if (alias == "home" || alias == "top-100") {
            $(subject).addClass("bg-color-dark-03");
        }
    }

    $(document).ready(function () {
        alias = localStorage.getItem("alias");
        ctrls.navbar.find(".nav-link").removeClass("bg-color-gray");
        if (alias == "home" || alias == "user" || alias == "categories" || alias == "artist" ||
            alias == "song" || alias == "album" || alias == "page" || alias == "trash"
        ) {
            ctrls.navbar.find(".nav-link[data-alias='" + alias + "']").css({"background-color": "rgba(33, 40, 50, 0.1019607843)"});
        }
        console.log(alias);
    });

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init
    }

})();

NAVBAR.init();