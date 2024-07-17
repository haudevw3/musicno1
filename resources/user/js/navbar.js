const NAVBAR = (function () {

    var ctrls = {};
    var url = null;
    var alias = null;
    var data = null;
    var html = null;

    const bindControl = function () {
        var self = {};
        self.navbar = $("#navbar");
        return self;
    }

    const bindFunction = function () {
        ctrls.navbar.find(".nav-link").on("click", eventOnclickNavlink);
    }

    const eventOnclickNavlink = async function (e) {
        e.preventDefault();
        url = BASE_URL + $(this).attr("href").replace("/", "");
        alias = $(this).attr("data-alias");
        focusNavlink(this, alias);
        STATE.push({}, (alias == PAGE_HOME) ? "/" : alias);
        if (SESSION.get(alias) == null) {
            await renderData(url, alias);
        }
        renderView(alias);
    }

    const renderData = async function (url, alias) {
        await _apiGet(url).then(function (response) {
            var data = response.data;
            SESSION.set(alias, JSON.stringify(data));
        }).catch(function (error) {
            console.log(error);
        });
    }

    const renderView = function (alias) {
        if (alias == PAGE_HOME) {
            data = JSON.parse(SESSION.get(PAGE_HOME));
            html = MAIN.style01Html(data.style_01) + MAIN.style02Html(data.style_02) + MAIN.style03Html(data.style_03);
            MAIN.setContent(html);
            $("#music-style-02 .card-wrapper .song-info").on("click", function () {
                var songs = JSON.parse(SESSION.get(PAGE_HOME)).style_02.songs;
                MUSIC_CONTROL.eventOnclickCardMusic(this, songs);
            });
        }
        if (alias == PAGE_TOP100) {
            data = JSON.parse(SESSION.get(PAGE_TOP100));
            html = MAIN.style03Html(data.style_03);
            MAIN.setContent(html);
        }
    }

    const focusNavlink = function (subject, alias) {
        ctrls.navbar.find(".nav-link").removeClass("bg-color-dark-03");
        if (alias == PAGE_HOME || alias == PAGE_TOP100) {
            $(subject).addClass("bg-color-dark-03");
        }
    }

    $(document).ready(function () {
        if (alias == null) {
            ctrls.navbar.find(".nav-link").first().click();
        }
    });

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
    }

})();

NAVBAR.init();