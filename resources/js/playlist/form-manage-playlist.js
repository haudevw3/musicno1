const FORM_MANAGE_PLAYLIST = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.formManagePlaylist = $("#form-manage-playlist");
        self.submitFormPlaylist = $("#submit-form-playlist");
        return self;
    }

    const bindFunction = function () {
        ctrls.submitFormPlaylist.on("click", postFormPlaylist);
        ctrls.formManagePlaylist.find("[name=name]").on("change", convertNameToSlug);
    }

    const postFormPlaylist = function () {
        var id = ctrls.formManagePlaylist.attr("data-id");
        var url = ctrls.formManagePlaylist.attr("data-url");

        var albumIds = [];
        var nodeList = $("#text-box")[0].childNodes;
        nodeList.forEach(function (node) {
            if (node.nodeType == Node.ELEMENT_NODE) {
                albumIds.push(node.dataset.id);
            }
        });

        if (albumIds.length == 0) {
            albumIds = '';
            _isInvalid(ctrls.formManagePlaylist.find("[name=textbox]"));
        } else {
            albumIds = albumIds.join(',');
            _isInvalid(ctrls.formManagePlaylist.find("[name=textbox]"), false);
        }

        var data = {
            album_ids: albumIds,
            name: _getValInput(ctrls.formManagePlaylist.find("[name=name]")),
            slug: _getValInput(ctrls.formManagePlaylist.find("[name=slug]")),
            image: _getValInput(ctrls.formManagePlaylist.find("[name=image]")),
            priority: _getValInput(ctrls.formManagePlaylist.find("[name=priority]")),
            description: _getValInput(ctrls.formManagePlaylist.find("[name=description]")),
        }

        const required = [data.name, data.slug, data.image, data.description, data.album_ids];
        if (! required.includes('')) {
            if (id > 0) {
                data = {...data, ...{id: id}};
                _apiUpdate(url, data).then(function (res) {
                    if (res.data == true) {
                        window.location = "/playlists/list/page-1";
                        SESSION.set("message", "Cập nhật dữ liệu danh sách phát thành công.");
                    }
                });
            } else {
                _apiCreate(url, data).then(function (res) {
                    if (res.message == "Created") {
                        window.location = "/playlists/list/page-1";
                        SESSION.set("message", "Tạo danh sách phát thành công.");
                    }
                });
            }
        } else {
            _showAlert("danger", "Vui lòng nhập đầy đủ thông tin của danh sách phát.");
        }
    }

    const convertNameToSlug = function () {
        var name = $(this).val();
        ctrls.formManagePlaylist.find("[name=slug]").val(_renderSlug(name));
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
        TEXT_BOX.init({url: "/api/albums/q/"});
    }

    return {
        init: init,
    }

})();

FORM_MANAGE_PLAYLIST.init();