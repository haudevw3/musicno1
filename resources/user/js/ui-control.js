const UI_CONTROL = (function () {

    var ctrls = {};

    const styles = {
        "current": null,
        "isFocus": true,
        "id": ["#top-playlist", "#song-playlist", "#default-playlist", "#detail-playlist"],
        "card": ".card-wrapper",
        "prefix": ".card-",
        "button": [".play-music", "#play-random-music"],
        "tags": [".play-music i"],
        "icons": ["fa-solid fa-play", "fa-solid fa-pause"],
        "class": ["bg-color-dark-03", "text-color-white fs-18"],
    }

    const bindControl = function () {
        var self = {};
        self.navbar = $("#navbar");
        self.mainContent = $("#main-content");
        return self;
    }

    const bindFunction = function () {
        ctrls.navbar.find(".nav-link").on("click", eventOnclickNavlink); 
    }

    const eventOnclickNavlink = async function (e) {
        e.preventDefault();
        ctrls.navbar.find(".nav-link").removeClass(styles.class[0]);
        $(this).addClass(styles.class[0]);
        var url = BASE_URL + $(this).attr("data-url").replace("/", "");
        STATE.push({}, url);
        await renderContent(url);
        eventOnclickButtonPlayMusic();
        eventOnclickLinkPlaylistMusic();
        focusCurrentCard();
        
    }

    const renderContent = async function (url) {
        await _apiGet(url, null, {dataType: "html"}).then(function (response) {
            var html = $($.parseHTML(response)).find("#main-content").html();
            ctrls.mainContent.html(html);
        }).catch(function (error) {
            console.log(error);
        });
    }

    const renderData = async function (url) {
        await _apiGet(url).then(function (response) {
            SESSION.set("df_songs", JSON.stringify(response.data));
        }).catch(function (error) {
            console.log(error);
        });
    }

    const setStateAndData = async function (subject, options = {}) {
        var id = $(subject).attr("data-id");
        var pos = $(subject).attr("data-position");
        var url = BASE_URL + "render-list-song/" + id;
        var status = false;
        styles.current = options.current;
        styles.isFocus = (options.isFocus != undefined) ? options.isFocus : true;

        if (SESSION.get("current_style") != options.current) {
            SESSION.set("current_style", options.current);
            SESSION.remove("song_pos");
            await renderData(url);
        }

        if (options.current == styles.id[1]) {
            SESSION.remove("playlist_id");
            SESSION.remove("playlist_pos");
            SESSION.remove("tracking_song_pos");
            if (SESSION.get("song_pos") == pos)  {
                status = true;
            } else {
                SESSION.set("song_pos", pos);
            }
            resetFoucusedState(status, pos, 2);

        } else if (options.current == styles.id[2]) {
            if (SESSION.get("playlist_id") != id) {
                SESSION.set("playlist_id", id);
                await renderData(url);
            }
            
            if (SESSION.get("playlist_pos") == pos) {
                status = true;
            } else {
                SESSION.set("playlist_pos", pos);
            }
            
            if (SESSION.get("tracking_playlist_pos") == SESSION.get("playlist_pos")) {
                pos = SESSION.get("_pos");
            }
            resetFoucusedState(status, pos, 1);

        } else if (options.current == styles.id[3]) {

            if (SESSION.get("playlist_id") != id) {
                SESSION.set("playlist_id", id);
                SESSION.remove("tracking_song_pos");
                await renderData(url);
            }

            if (SESSION.get("tracking_playlist_pos") != SESSION.get("playlist_pos")) {
                SESSION.set("playlist_pos", SESSION.get("tracking_playlist_pos"));
            }

            if (SESSION.get("tracking_song_pos") == pos) {
                status = true;
            } else {
                SESSION.set("tracking_song_pos", pos);
            }
            resetFoucusedState(status, pos);
        }
    }

    const resetFoucusedState = function (status, pos, key = null) {
        if (status) {
            MUSIC_CONTROL.getPlayMusic().click();
        } else {
            MUSIC_CONTROL.prepare(pos, {songs: JSON.parse(SESSION.get("df_songs"))}, styles);
            if (key != null) {
                $(styles.id[key]).find(styles.card).removeClass(styles.class[0]);
                $(styles.id[key]).find(styles.card + " " + styles.tags[0]).attr("class", styles.class[1] + " " + styles.icons[0]);
            }
        }
    }

    const eventOnclickButtonPlayMusic = function () {
        $(styles.id[1]).find(styles.button[0]).on("click", function () {
            setStateAndData(this, {current: styles.id[1]});
        });

        $(styles.id[2]).find(styles.button[0]).on("click", function () {
            setStateAndData(this, {current: styles.id[2], isFocus: false});
        });
    }

    const eventOnclickLinkPlaylistMusic = function () {
        $(styles.id[2]).find(".card-link").on("click", async function (e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
            var pos = $(this).attr("data-position");
            var url = BASE_URL + "playlist/" + id;
            STATE.push({}, url);
            await renderContent(url);
            styles.isFocus = true;
            styles.current = styles.id[3];
            MUSIC_CONTROL.setStyles(styles);

            if (SESSION.get("tracking_playlist_pos") != pos) {
                SESSION.set("tracking_playlist_pos", pos);
            }

            if (SESSION.get("playlist_id") == id) {
                var songPos = (SESSION.get("song_pos") != null) ? SESSION.get("song_pos") : pos;
                $(styles.id[3]).find(styles.prefix + songPos).addClass(styles.class[0]);
                if (MUSIC_CONTROL.isPlayMusic()) {
                    SESSION.set("tracking_song_pos", songPos);
                    $(styles.id[3]).find(styles.prefix + songPos + " " + styles.tags[0]).attr("class", styles.class[1] + " " + styles.icons[1]);
                    $(styles.id[3]).find(styles.button[1] + " i").attr("class", styles.icons[1]).end().find(styles.button[1] + " span").text("Tạm dừng");
                } else {
                    $(styles.id[3]).find(styles.button[1] + " i").attr("class", styles.icons[0]).end().find(styles.button[1] + " span").text("Tiếp tục phát");
                }
            }

            $(styles.id[3]).find(styles.button[1]).on("click", async function () {
                if (SESSION.get("playlist_id") == null || SESSION.get("playlist_id") != id) {
                    var _pos = SESSION.get("tracking_playlist_pos");
                    $(styles.id[3]).find(styles.prefix + _pos + " " + styles.button[0]).click();
                } else {
                    MUSIC_CONTROL.getPlayMusic().click();
                }
            });

            $(styles.id[3]).find(styles.button[0]).on("click", function () {
                setStateAndData(this, {current: styles.id[3], isFocus: true});
            });
        });
    }

    const focusCurrentCard = function () {
        if (SESSION.get("current_style") != null) {
            var position = 0;
            var currentStyle = SESSION.get("current_style");

            if (currentStyle == styles.id[1]) {
                position = SESSION.get("song_pos");
                $(styles.id[1]).find(styles.prefix + position).addClass(styles.class[0]);
            }

            if (currentStyle == styles.id[2] || currentStyle == styles.id[3]) {
                currentStyle = styles.id[2];
                position = SESSION.get("playlist_pos");
                styles.isFocus = false;
                styles.current = styles.id[2];
                MUSIC_CONTROL.setStyles(styles);
            }
            
            if (MUSIC_CONTROL.isPlayMusic()) {
                $(currentStyle).find(styles.prefix + position + " " + styles.tags[0]).attr("class", styles.icons[1] + " " + styles.class[1]);
            }
        }
    }

    $(document).ready(function () {
        eventOnclickButtonPlayMusic();
        eventOnclickLinkPlaylistMusic();
    });

    $(window).on("beforeunload", function() {
        SESSION.remove("playlist_id");
        SESSION.remove("playlist_pos");
        SESSION.remove("tracking_playlist_pos");
        SESSION.remove("tracking_song_pos");
        SESSION.remove("current_style");
        SESSION.remove("song_pos");
    });

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        styles: styles,
    }

})();

UI_CONTROL.init();