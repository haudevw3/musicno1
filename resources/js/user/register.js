const REGISTER = (function() {

    var controls = {};

    const bindControls = function() {
        var self = {};

        self.formRegister = $('#form-register');
        self.btnRegister = $('#btn-register');

        return self;
    }

    const bindFunctions = function() {
        controls.btnRegister.on('click', register);
    }

    const register = function() {
        var data = {
            'name': getInputVal(controls.formRegister.find('[name=name]')),
            'username': getInputVal(controls.formRegister.find('[name=username]')),
            'password': getInputVal(controls.formRegister.find('[name=password]')),
            'email': getInputVal(controls.formRegister.find('[name=email]')),
        }
        
        const required = [data.name, data.username, data.password, data.email];
        
        if (required.includes('')) {
            showAlert('danger', 'Vui lòng nhập đầy đủ thông tin vào các ô bên dưới.');
        }
        
        else {
            apiCreate('/api/v1/register', data, {useAlert: true})
                .then(function(response) {
                    if (response.id) {
                        window.location = '/xac-thuc-tai-khoan/' + response.id;
                    }
                });
        }
        
    }

    $(document).on('keydown', function(event) {
        if (event.originalEvent.keyCode === 13) {
            register();
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

REGISTER.init();