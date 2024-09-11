const FORM_MANAGE_USER = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.formManageUser = $("#form-manage-user");
        self.submitFormUser = $("#submit-form-user");
        return self;
    }

    const bindFunction = function () {
        ctrls.submitFormUser.on("click", postFormUser);
    }

    const postFormUser = function () {
        var id = ctrls.formManageUser.attr("data-id");
        var url = ctrls.formManageUser.attr("data-url");
        var data = {
            fullname: _getValInput(ctrls.formManageUser.find("[name=fullname]")),
            username: _getValInput(ctrls.formManageUser.find("[name=username]")),
            email: _getValInput(ctrls.formManageUser.find("[name=email]")),
            password: _getValInput(ctrls.formManageUser.find("[name=password]")),
            image: _getValInput(ctrls.formManageUser.find("[name=image]"), false),
            tel: _getValInput(ctrls.formManageUser.find("[name=tel]"), false),
            role: _getValInput(ctrls.formManageUser.find("[name=role]")),
        }
        const required = [data.fullname, data.username, data.email, data.password];
        if (! required.includes('')) {
            if (checkUsername(data.username) != -1) {
                if (id > 0) {
                    data = {...data, ...{id: id}};
                    _apiUpdate(url, data).then(function (res) {
                        if (res.data == true) {
                            window.location = "/users/list/page-1";
                            SESSION.set("message", "Cập nhật dữ liệu tài khoản thành công.");
                        }
                    });
                } else {
                    _apiCreate(url, data).then(function (res) {
                        if (res.data == true) {
                            window.location = "/users/list/page-1";
                            SESSION.set("message", "Tạo tài khoản thành công.");
                        }
                    });
                }
            } else {
                _showAlert("danger", "Tên đăng nhập không hợp lệ. Vui lòng nhập lại.");
                _isInvalid(ctrls.formManageUser.find("[name=username]"));
            }
        } else {
            _showAlert("danger", "Vui lòng nhập đầy đủ thông tin người dùng.");
        }
    }

    const checkUsername = function (str) {
        return str.search(/^(?=[a-zA-Z0-9._]{6,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/);
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
    }

})();

FORM_MANAGE_USER.init();