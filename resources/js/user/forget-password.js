const FORGET_PASSWORD = (function() {

    var controls = {};

    const bindControls = function() {
        var self = {};

        self.formForgetPassword = $('#form-forget-password');
        self.btnForgetPassword = $('#btn-forget-password');

        return self;
    }

    const bindFunctions = function() {
        controls.btnForgetPassword.on('click', forgetPassword);
    }

    const forgetPassword = function() {
        var data = {
            email: getInputVal(controls.formForgetPassword.find('[name=email]'))
        }
        
        const required = [data.email];

        if (required.includes('')) {
            showAlert('danger', 'Vui lòng nhập đầy đủ thông tin vào các ô bên dưới.');
        }
        
        else {
            apiCreate('/api/v1/forget-password', data, {useAlert: true})
                .then(function(response) {
                    if (response.success) {
                        showAlert('success', response.success);

                        setTimeout(function () {
                            window.location = '/dang-nhap';
                        }, 10000);
                    }
                });
        }
    }

    $(document).on('keydown', function(event) {
        if (event.originalEvent.keyCode === 13) {
            forgetPassword();
        }
    });

    function init() {
        controls = bindControls();

        bindFunctions();
    }

    return {
        init: init,
    }

})();

FORGET_PASSWORD.init();