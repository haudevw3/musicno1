const APP = (function () {

    var controls = {};
    var changed = false;

    const bindControls = function () {
        var self = {};

        self.overlay = $('#overlay');
        self.topnav = $('#topnav');
        self.sidenav = $('#sidenav');
        self.sidenavToggle = $('#sidenav-toggle');
        self.mainContent = $('#main-content');

        return self;
    }

    const bindFunctions = function () {
        controls.sidenavToggle.on('click', changeSidenavState);
    }

    const changeSidenavState = function () {
        if (! changed) {
            changed = true;
            controls.sidenav.css({transform: 'translateX(-240px)'});
            controls.topnav.find('.left').css({ padding: '20px 5px' });
            controls.mainContent.css({width: '100%', 'margin-left': 0});
        } else {
            changed = false;
            controls.sidenav.css({transform: 'translateX(0)'});
            controls.topnav.find('.left').css({ padding: '20px' });
            controls.mainContent.css({width: 'calc(100% - 240px)', 'margin-left': '240px'});
        }
    }

    const showToastIf = function () {
        var successMessage = sessionStorage.getItem('success');

        if (successMessage != null) {
            showToast(successMessage, toastOptions.success);

            sessionStorage.removeItem('success');
        }
    }

    $(document).ready(function () {
        showToastIf();
    });

    function init() {
        controls = bindControls();

        bindFunctions();
    }

    return {
        init: init,
    }

})();

APP.init();