const LOGIN = (function() {

    var controls = {};

    const bindControls = function() {
        var self = {};

        self.formLogin = $('#form-login');
        self.btnLogin = $('#btn-login');
        
        return self;
    }

    const bindFunctions = function() {
        controls.btnLogin.on('click', login);
    }

    const login = function() {
        var data = {
            'username': getInputVal(controls.formLogin.find('[name=username]')),
            'password': getInputVal(controls.formLogin.find('[name=password]')),
            'remember': controls.formLogin.find('[name=remember]').is(':checked'),
        }
        
        const required = [data.username, data.password];

        if (required.includes('')) {
            showAlert('danger', 'Vui lòng nhập đầy đủ thông tin vào các ô bên dưới.');
        }
        
        else {
            apiCreate('/api/v1/login', data, {useAlert: true})
                .then(function(response) {
                    if (response.success) {
                        window.location = '/';
                    }
                });
        }
    }

    $(document).on('keydown', function(event) {
        if (event.originalEvent.keyCode === 13) {
            login();
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

LOGIN.init();