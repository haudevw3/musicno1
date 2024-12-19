const VERIFY_ACCOUNT = (function() {

    var controls = {};

    const bindControls = function() {
        var self = {};

        self.formVerifyAccount = $('#form-verify-account');
        self.btnVerifyAccount = $('#btn-verify-account');
        self.textRefreshToken = $('#text-refresh-token');

        return self;
    }

    const bindFunctions = function() {
        controls.btnVerifyAccount.on('click', verifyAccount);
        controls.textRefreshToken.on('click', refreshToken);
    }

    const verifyAccount = function() {
        var data = {
            id: getInputVal(controls.formVerifyAccount.find('[name=id]')),
            token: getInputVal(controls.formVerifyAccount.find('[name=token]')),
        }

        const required = [data.id, data.token];

        if (required.includes('')) {
            showAlert('danger', 'Vui lòng nhập mã xác nhận.');
        }
        
        else {
            apiCreate('/api/v1/verify-account', data, {useAlert: true})
                .then(function(response) {
                    if (response.success) {
                        window.location = '/';
                    }
                });
        }
    }

    const refreshToken = function() {
        var data = {
            id: getInputVal(controls.formVerifyAccount.find('[name=id]'), false),
        }

        apiCreate('/api/v1/refresh-token-to-send-mail', data, {useAlert: true})
            .then(function (response) {
                if (response.success) {
                    showAlert('success', response.success);
                }
            });
    }

    $(document).on('keydown', function(event) {
        if (event.originalEvent.keyCode === 13) {
            verifyAccount();
        }
    });

    function init() {
        controls = bindControls();

        bindFunctions();
    }

    return {
        init: init
    }

})();

VERIFY_ACCOUNT.init();