const FORM_MANAGE_ALBUM = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.formManageAlbum = $("#form-manage-album");
        self.submitFormAlbum = $("#submit-form-album");
        return self;
    }

    const bindFunction = function () {
        ctrls.submitFormAlbum.on("click", postFormAlbum);
        ctrls.formManageAlbum.find("[name=name]").on("change", convertNameToSlug);
    }

    const postFormAlbum = function () {
        var id = ctrls.formManageAlbum.attr("data-id");
        var url = ctrls.formManageAlbum.attr("data-url");
        var artistId = ctrls.formManageAlbum.attr("data-artist-id");

        var data = {
            name: _getValInput(ctrls.formManageAlbum.find("[name=name]")),
            slug: _getValInput(ctrls.formManageAlbum.find("[name=slug]")),
            image: _getValInput(ctrls.formManageAlbum.find("[name=image]"), false),
            type: _getValInput(ctrls.formManageAlbum.find("[name=type]")),
            release_year: _getValInput(ctrls.formManageAlbum.find("[name=release_year]")),
            description: _getValInput(ctrls.formManageAlbum.find("[name=description]")),
        }
        
        const required = [data.name, data.slug, data.description];
        if (! required.includes('')) {
            if (id > 0) {
                data = {...data, ...{id: id}};
                _apiUpdate(url, data).then(function (res) {
                    if (res.data == true) {
                        window.location = "/albums/list/page-1";
                        SESSION.set("message", "Cập nhật dữ liệu album thành công.");
                    }
                });
            } else {
                data = {...data, ...{artist_id: artistId}};
                _apiCreate(url, data).then(function (res) {
                    if (res.message == "Created") {
                        _showLoading(function () {
                            ctrls.formManageAlbum.remove();
                            $("#form-manage-song").css({ display: "block" }).attr({
                                "data-album-id": res.data.album_id,
                                "data-album-type": res.data.album_type,
                                "data-artist-id": res.data.artist_id,
                            });
                        }, 2000);
                    }
                });
            }
        } else {
            _showAlert("danger", "Vui lòng nhập đầy đủ thông tin của album.");
        }
    }

    const convertNameToSlug = function () {
        var name = $(this).val();
        ctrls.formManageAlbum.find("[name=slug]").val(_renderSlug(name));
    }

    $(document).ready(function () {
        $("#form-manage-song").css({ display: "none" });
    });

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
    }

})();

FORM_MANAGE_ALBUM.init();