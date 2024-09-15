const FORM_MANAGE_ARTIST = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.formManageArtist = $("#form-manage-artist");
        self.submitFormArtist = $("#submit-form-artist");
        return self;
    }

    const bindFunction = function () {
        ctrls.submitFormArtist.on("click", postFormArtist);
        ctrls.formManageArtist.find("[name=name]").on("change", convertNameToSlug);
    }

    const postFormArtist = function () {
        var id = ctrls.formManageArtist.attr("data-id");
        var url = ctrls.formManageArtist.attr("data-url");

        var data = {
            name: _getValInput(ctrls.formManageArtist.find("[name=name]")),
            slug: _getValInput(ctrls.formManageArtist.find("[name=slug]")),
            image: _getValInput(ctrls.formManageArtist.find("[name=image]")),
            description: _getValInput(ctrls.formManageArtist.find("[name=description]")),
        }

        const required = [data.name, data.slug, data.image, data.description];
        if (! required.includes('')) {
            if (id > 0) {
                data = {...data, ...{id: id}};
                _apiUpdate(url, data).then(function (res) {
                    if (res.data == true) {
                        window.location = "/artists/list/page-1";
                        SESSION.set("message", "Cập nhật dữ liệu nghệ sĩ thành công.");
                    }
                });
            } else {
                _apiCreate(url, data).then(function (res) {
                    if (res.data == true) {
                        window.location = "/artists/list/page-1";
                        SESSION.set("message", "Tạo nghệ sĩ thành công.");
                    }
                });
            }
        } else {
            _showAlert("danger", "Vui lòng nhập đầy đủ thông tin của nghệ sĩ.");
        }
    }

    const convertNameToSlug = function () {
        var name = $(this).val();
        ctrls.formManageArtist.find("[name=slug]").val(_renderSlug(name));
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
    }

})();

FORM_MANAGE_ARTIST.init();