const MANAGE_USER = (function() {

    var controls = {};

    const bindControls = function() {
        var self = {};

        self.formSaveUser = $('#form-save-user');
        self.btnSaveUser = $('#btn-save-user');
        self.btnDeleteUser = $('.btn-delete-user');
        self.btnDeleteManyUser = $('#btn-delete-many-user');

        return self;
    }

    const bindFunctions = function() {
        controls.btnSaveUser.on('click', saveUser);
        controls.btnDeleteUser.on('click', deleteUser);
        controls.btnDeleteManyUser.on('click', deleteManyUser);
    }

    const saveUser = function() {
        var id = controls.formSaveUser.attr('data-user-id');

        var data = {
            name: getInputVal(controls.formSaveUser.find('[name=name]')),
            username: getInputVal(controls.formSaveUser.find('[name=username]')),
            email: getInputVal(controls.formSaveUser.find('[name=email]')),
            password: getInputVal(controls.formSaveUser.find('[name=password]')),
            image: getInputVal(controls.formSaveUser.find('[name=image]'), false),
            roles: getInputVal(controls.formSaveUser.find('[name=roles]')),
        }

        const required = [data.fullname, data.username, data.email, data.password];

        if (required.includes('')) {
            showAlert('danger', 'Vui lòng nhập đầy đủ thông tin vào các ô bên dưới.');
        }

        else if(checkUsername(data.username) == -1) {
            isInvalid(controls.formSaveUser.find('[name=username]'));

            showAlert('danger', 'Tên đăng nhập không hợp lệ. Vui lòng chọn một tên khác.');
        }

        else if (id == '') {
            apiCreate('/api/v1/users/create', data, {useInvalidFeedback: true})
                .then(function(response) {
                    if (response.success) {
                        showToast(response.success, toastOptions.success);

                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                });
        }

        else {
            data.id = id;

            apiUpdate('/api/v1/users/update', data, {useInvalidFeedback: true})
                .then(function(response) {
                    if (response.success) {
                        window.location = '/adm/manage-user/page-1';

                        sessionStorage.setItem('success', response.success);
                    }
                });
        }
    }

    const deleteUser = function() {
        var id = $(this).attr('data-user-id');
        
        showDialog('Xóa tài khoản người dùng',
        'Bạn có muốn xóa tài khoản này không. Khi xóa mọi dữ liệu liên quan đến tài khoản này sẽ bị xóa vĩnh viễn.')
            .then(function() {
                apiDelete('/api/v1/users/delete', {id: id}).then(function(response) {
                    if (response.success) {
                        window.location = '/adm/manage-user/page-1';

                        sessionStorage.setItem('success', response.success);
                    }
                });
            });
    }

    const deleteManyUser = function() {
        if (! TABLE.hasMoreCheckboxes()) {
            showToast('Vui lòng chọn vào các ô để thực hiện chức năng này.', toastOptions.warning);
        }

        else {
            showDialog('Xóa tài khoản người dùng',
            'Bạn có muốn xóa những tài khoản này không. Khi xóa mọi dữ liệu liên quan đến những tài khoản này sẽ bị xóa vĩnh viễn.')
                .then(function() {
                    apiUpload('/api/v1/users/delete-many', TABLE.createFormData('user_ids')).then(function(response) {
                        if (response.success) {
                            window.location = '/adm/manage-user/page-1';
        
                            sessionStorage.setItem('success', response.success);
                        }
                    });
                }).catch(function(rejected) {
                    TABLE.setCheckboxesState(rejected);
                });
        }
    }

    const checkUsername = function(val) {
        return val.search(/^(?=[a-zA-Z0-9._]{6,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/);
    }

    $(document).on('keydown', function(event) {
        if (event.originalEvent.keyCode === 13) {
            saveUser();
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

MANAGE_USER.init();