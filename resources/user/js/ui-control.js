const UI_CONTROL = (function () {

    var ctrls = {};

    const styles = {
        "id": ["#top-playlist", "#song-playlist", "#default-playlist", "#detail-playlist"],
        "tags": [".play-music i"],
        "class": ["bg-color-dark-03", "text-color-white fs-18"],
        "card": {"wrap": ".card-wrapper", "prefix": ".card-"},
        "button": {"play": ".play-music", "playRandom": "#play-random-music"},
        "icons": {"play": "fa-solid fa-play", "pause": "fa-solid fa-pause"},
    }

    const repo = {
        "id": null,
        "isFocus": true,
        "currentStyle": null,
        "playlistPos": null,
        "previousPos": null,
        "currentPos": 0,
        "nextPos": null,
        "data": null,
        "length": 0,
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
        trackingHistoryState();
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
            SESSION.set("data", JSON.stringify(response.data));
        }).catch(function (error) {
            console.log(error);
        });
    }

    const setStateAndData = async function (subject, options = {}) {
        var id = $(subject).attr("data-id");
        var pos = parseInt($(subject).attr("data-pos"));
        var url = BASE_URL + ((options.path != undefined) ? options.path : "render-list-song/") + id;
        var status = true;
        repo.isFocus = (options.isFocus != undefined) ? options.isFocus : true;
        
        if (options.needRenderContent) {
            STATE.push({}, url);
            await renderContent(url);
        } else {
            if (repo.id != id) {
                status = false;
                repo.id = id;
                await renderData(url);
                repo.data = JSON.parse(SESSION.get("data"));
                repo.length = repo.data.length;
                repo.currentPos = 0;
                if (options.currentStyle == styles.id[1]) {
                    repo.playlistPos = null;
                }
                if (options.currentStyle == styles.id[2]) {
                    repo.playlistPos = pos;
                }
                if (options.currentStyle == styles.id[3]) {
                    repo.playlistPos = options.pos;
                }
            }
    
            if (repo.currentStyle != options.currentStyle) {
                $(repo.currentStyle).find(styles.card.wrap).removeClass(styles.class[0]);
                $(repo.currentStyle).find(styles.card.wrap + " " + styles.tags[0]).attr("class", styles.icons.play + " " + styles.class[1]);
                repo.currentStyle = options.currentStyle;
            }
    
            if (status && ((options.currentStyle == styles.id[1] && repo.currentPos == pos) ||
                (options.currentStyle == styles.id[2] && repo.playlistPos == pos) ||
                (options.currentStyle == styles.id[3] && repo.currentPos == pos))) {
                MUSIC_CONTROL.getPlayMusic().click();
            } else {
                MUSIC_CONTROL.setData({pos: pos, repo: repo, styles: styles});
                MUSIC_CONTROL.prepareDataAndBootMusic(pos);
            }
        }
    }

    const setPosForRepo = function (pos) {
        repo.currentPos = pos;

        if (pos > 0) {
            repo.previousPos = pos - 1;
        } else {
            repo.previousPos = null;
        }

        if (pos >= 0 && pos < repo.length - 1) {
            repo.nextPos = pos + 1;
        } else {
            repo.nextPos = null;
        }
    }

    const eventOnclickButtonPlayMusic = function () {
        $(styles.id[1]).find(styles.button.play).on("click", function () {
            setStateAndData(this, {currentStyle: styles.id[1]});
        });

        $(styles.id[2]).find(styles.button.play).on("click", function () {
            setStateAndData(this, {currentStyle: styles.id[2], isFocus: false});
        });
    }

    const eventOnclickLinkPlaylistMusic = function () {
        $(styles.id[2]).find(".card-link").on("click", async function (e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
            var pos = parseInt($(this).attr("data-pos"));
            console.log(pos);
            await setStateAndData(this, {needRenderContent: true, path: "playlist/", currentStyle: styles.id[2], isFocus: true});
            repo.currentStyle = styles.id[3];
            MUSIC_CONTROL.setRepo(repo);

            if (repo.id == id) {
                $(styles.id[3]).find(styles.card.prefix + repo.currentPos).addClass(styles.class[0]);
                if (MUSIC_CONTROL.isPlayMusic()) {
                    $(styles.id[3]).find(styles.card.prefix + repo.currentPos + " " + styles.tags[0]).attr("class",  styles.icons.pause + " " + styles.class[1]);
                    $(styles.id[3]).find(styles.button.playRandom + " i").attr("class", styles.icons.pause).end().find(styles.button.playRandom + " span").text("Tạm dừng");
                } else {
                    $(styles.id[3]).find(styles.button.playRandom + " i").attr("class", styles.icons.play).end().find(styles.button.playRandom + " span").text("Tiếp tục phát");
                }
            }

            $(styles.id[3]).find(styles.button.playRandom).on("click", function () {
                if (repo.id == null || repo.id != id) {
                    setStateAndData(this, {currentStyle: styles.id[3], isFocus: true, pos: pos});
                } else {
                    MUSIC_CONTROL.getPlayMusic().click();
                }
            });

            $(styles.id[3]).find(styles.button.play).on("click", function () {
                setStateAndData(this, {currentStyle: styles.id[3], isFocus: true, pos: pos});
            });
        });
    }

    const trackingHistoryState = function () {
        var pos = 0;
        var currentStyle = repo.currentStyle;
        
        if (currentStyle == styles.id[1]) {
            pos = repo.currentPos;
            $(styles.id[1]).find(styles.card.prefix + pos).addClass(styles.class[0]);
        }
        if (currentStyle == styles.id[2] || currentStyle == styles.id[3]) {
            pos = repo.playlistPos;
            currentStyle = styles.id[2];
            repo.isFocus = false;
            repo.currentStyle = currentStyle;
            MUSIC_CONTROL.setRepo(repo);
            console.log(repo);
        }
        if (MUSIC_CONTROL.isPlayMusic()) {
            $(currentStyle).find(styles.card.prefix + pos + " " + styles.tags[0]).attr("class", styles.icons.pause + " " + styles.class[1]);
        }
    }

    $(document).ready(function () {
        eventOnclickButtonPlayMusic();
        eventOnclickLinkPlaylistMusic();
    });

    $(window).on("beforeunload", function() {
        
    });

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        repo: repo,
        styles: styles,
        setPosForRepo: setPosForRepo,
    }

})();

UI_CONTROL.init();