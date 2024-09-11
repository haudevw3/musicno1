const FORM_MANAGE_SONG = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.formManageSong = $("#form-manage-song");
        self.submitFormSong = $("#submit-form-song");
        return self;
    }

    const bindFunction = function () {
        ctrls.submitFormSong.on("click", postFormSong);
        ctrls.formManageSong.find("[name=name]").on("change", convertNameToSlug);
    }

    const postFormSong = function () {
        var id = ctrls.formManageSong.attr("data-id");
        var url = ctrls.formManageSong.attr("data-url");
        var albumId = ctrls.formManageSong.attr("data-album-id");
        var albumType = ctrls.formManageSong.attr("data-album-type");
        var artistId = ctrls.formManageSong.attr("data-artist-id");

        var subArtistIds = [];
        var nodeList = $("#text-box")[0].childNodes;
        nodeList.forEach(function (node) {
            if (node.nodeType == Node.ELEMENT_NODE) {
                subArtistIds.push(node.dataset.id);
            }
        });
        subArtistIds = (subArtistIds.length == 0) ? null : subArtistIds.join(',');

        var tags = ctrls.formManageSong.find("[name='tags[]']:checkbox:checked").map(function () {
            return $(this).val();
        }).get();
        
        var data = {
            tags: tags.join(','),
            sub_artist_ids: subArtistIds,
            name: _getValInput(ctrls.formManageSong.find("[name=name]")),
            slug: _getValInput(ctrls.formManageSong.find("[name=slug]")),
            image: _getValInput(ctrls.formManageSong.find("[name=image]")),
            audio: _getValInput(ctrls.formManageSong.find("[name=audio]")),
        }
        
        const required = [data.name, data.slug, data.image, data.audio];
        if (! required.includes('')) {
            if (id > 0) {
                data = {...data, ...{id: id}};
                _apiUpdate(url, data).then(function (res) {
                    if (res.data == true) {
                        window.location = "/songs/list/page-1";
                        SESSION.set("message", "Cập nhật dữ liệu bài hát thành công.");
                    }
                });
            } else {
                data = {...data, ...{artist_id: artistId, album_id: albumId}};
                _apiCreate(url, data).then(function (res) {
                    if (res.message == "Created") {
                        if (albumType == 1) {
                            window.location = "/artists/list/page-1";
                            SESSION.set("message", "Tạo bài hát cho album thành công.");
                        }
                    }
                });
            }
        } else {
            _showAlert("danger", "Vui lòng nhập đầy đủ thông tin của bài hát.");
        }
    }

    const convertNameToSlug = function () {
        var name = _getValInput(ctrls.formManageSong.find("[name=name]"));
        ctrls.formManageSong.find("[name=slug]").val(_renderSlug(name));
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
        TEXT_BOX.init({url: "/api/artists/q/"});
    }

    return {
        init: init,
    }

})();

FORM_MANAGE_SONG.init();