const UI_CONTROL = (function () {

    var ctrls = {};
    var navlink = null;

    const styles = {
        "id": [
            "#top-card-container",
            "#song-card-container",
            "#playlist-card-container",
            "#playlist-detail",
            "#album-detail",
        ],
        "btn": {
            "play": ".play-music",
            "playFollowingSchedule": "#play-following-schedule-music",
        },
        "tags": {
            "iplay": ".play-music i",
            "iplayFollowingSchedule": "#play-following-schedule-music i",
            "spanplayFollowingSchedule": "#play-following-schedule-music span",
        },
        "card": {
            "wrap": ".card-wrapper",
            "text": ".card-text",
            "prefix": ".card-",
            "first": "#card-first",
        },
        "icons": {
            "play": "fa-solid fa-play text-color-white fs-18",
            "pause": "fa-solid fa-pause text-color-white fs-18",
        },
        "bgColor": {
            "dark": "bg-color-dark-01",
            "darkGray": "bg-color-dark-03",
        },
    }

    const trackState = {
        "id": null,
        "styleId": null,
        "currentId": null,
        "currentPos": null,
        "needFocusStateAtPos": true,
        "notFocusStateOfButton": false,
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

    const eventOnclickNavlink = async function () {
        var url = BASE_URL + $(this).attr("data-url").replace("/", "");
        if (navlink != url) {
            navlink = url;
            history.pushState({}, "", url);
            await renderContent(url);
        }
        setStateOfNavlink({subject: this});
        manageEvent();
        updateStateForCurrentPage();
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
        var status = true;
        var dataOfSubject = getDataOfSubject(subject);
        trackState.currentId = dataOfSubject.id;
        trackState.currentPos = dataOfSubject.pos;
        trackState.notFocusStateOfButton = false;
        trackState.needFocusStateAtPos = (options.needFocusStateAtPos != undefined) ? options.needFocusStateAtPos : true;

        if (trackState.styleId != options.styleId) {
            removeStateOfCard();
            trackState.currentId = null;
            trackState.styleId = options.styleId;
        }

        if (trackState.id != dataOfSubject.id) {
            status = false;
            trackState.id = dataOfSubject.id;
            await renderData(dataOfSubject.url);
            MUSIC_CONTROL.setDataForRepo({data: JSON.parse(SESSION.get("data"))});
        }

        if (status && ((options.styleId == styles.id[1] && MUSIC_CONTROL.repo.currentPos == dataOfSubject.pos) ||
                       (options.styleId == styles.id[2] && trackState.id == dataOfSubject.id) ||
                       (options.styleId == styles.id[3] && MUSIC_CONTROL.repo.currentPos == dataOfSubject.pos) ||
                       (options.styleId == styles.id[4] && MUSIC_CONTROL.repo.currentPos == dataOfSubject.pos))) {
            MUSIC_CONTROL.getPlayMusic().click();
        } else {
            MUSIC_CONTROL.prepareDataAtPosAndBootMusic(dataOfSubject.pos);
        }

    }

    const manageEvent = function () {
        $(styles.id[1]).find(styles.btn.play).on("click", function () {
            setStateAndData(this, {styleId: styles.id[1]});
        });

        $(styles.id[2]).find(styles.btn.play).on("click", function () {
            setStateAndData(this, {styleId: styles.id[2], needFocusStateAtPos: false});
        });

        $(styles.id[2]).find(".show-all").on("click", async function () {
            var dataOfSubject = getDataOfSubject(this);
            var url = dataOfSubject.url.replace(BASE_URL, "/");
            history.pushState({}, "", dataOfSubject.url);
            
            if (url == '/top-100') {
                ctrls.navbar.find(".nav-link[data-url='"+ url +"'").click();
            } else {
                setStateOfNavlink({url: dataOfSubject.url});
                await renderContent(dataOfSubject.url);
            }
        });

        $(styles.id[2]).find(styles.card.text).on("click", async function () {
            var dataOfSubject = getDataOfSubject(this);
            history.pushState({}, "", dataOfSubject.url);
            setStateOfNavlink({url: dataOfSubject.url});
            await renderContent(dataOfSubject.url);

            trackState.styleId = styles.id[3];
            trackState.needFocusStateAtPos = true;
            trackState.currentId = dataOfSubject.id;
            if (trackState.id == dataOfSubject.id) {
                setStateOfCard({status: MUSIC_CONTROL.isPlayMusic(), pos: MUSIC_CONTROL.repo.currentPos});
                setStateOfButton({status: MUSIC_CONTROL.isPlayMusic()});
            }

            $(styles.id[3]).find(styles.btn.playFollowingSchedule).on("click", function () {
                var dataOfSubject = getDataOfSubject(this);
                if (trackState.id == null || trackState.id != dataOfSubject.id) {
                    setStateAndData(this, {styleId: styles.id[3]});
                } else {
                    MUSIC_CONTROL.getPlayMusic().click();
                }
            });

            $(styles.id[3]).find(styles.btn.play).on("click", function () {
                setStateAndData(this, {styleId: styles.id[3]});
            });

            $(styles.id[3]).find(".album-name").on("click", async function () {
                var dataOfSubject = getDataOfSubject(this);
                var albumUrl = BASE_URL + $(this).attr("album-url").replace("/", "");
                history.pushState({}, "", albumUrl);
                await renderContent(albumUrl);

                trackState.styleId = styles.id[4];
                trackState.needFocusStateAtPos = true;
                trackState.currentId = dataOfSubject.id;
                trackState.currentPos = dataOfSubject.pos;
                var attr = {
                    "data-pos": dataOfSubject.pos,
                    "data-id": dataOfSubject.id,
                    "data-url": dataOfSubject.url.replace(BASE_URL, "/"),
                };

                $(styles.id[4]).find(styles.btn.playFollowingSchedule).attr(attr);
                $(styles.id[4]).find(styles.card.first + " " + styles.btn.play).attr(attr);
                $(styles.id[4]).find(styles.card.first).addClass("card-" + dataOfSubject.pos);

                if (trackState.id == dataOfSubject.id && dataOfSubject.pos == MUSIC_CONTROL.repo.currentPos) {
                    setStateOfCard({status: MUSIC_CONTROL.isPlayMusic(), pos: MUSIC_CONTROL.repo.currentPos});
                    setStateOfButton({status: MUSIC_CONTROL.isPlayMusic()});
                }

                $(styles.id[4]).find(styles.btn.playFollowingSchedule).on("click", function () {
                    var dataOfSubject = getDataOfSubject(this);
                    if (trackState.id == null || trackState.id != dataOfSubject.id ||
                       (trackState.id == dataOfSubject.id && dataOfSubject.pos != MUSIC_CONTROL.repo.currentPos)) {
                        setStateAndData(this, {styleId: styles.id[4]});
                    } else {
                        MUSIC_CONTROL.getPlayMusic().click();
                    }
                });
    
                $(styles.id[4]).find(styles.btn.play).on("click", function () {
                    setStateAndData(this, {styleId: styles.id[4]});
                });
            });
        });
    }

    const getDataOfSubject = function (subject) {
        var id = $(subject).attr("data-id");
        var pos = parseInt($(subject).attr("data-pos"));
        var url = BASE_URL + $(subject).attr("data-url").replace("/", "");
        return {id: id, pos: pos, url: url};
    }

    const setStateOfCard = function (options = {}) {
        if (trackState.id != trackState.currentId &&
           (trackState.styleId == styles.id[3] || trackState.styleId == styles.id[4])) {
            return;
        }
        
        var icon = options.status ? styles.icons.pause : styles.icons.play;
        var focusId = trackState.needFocusStateAtPos ? (styles.card.prefix + options.pos) : ("#" + trackState.id);
        var bgColor = (trackState.styleId == styles.id[1] || trackState.styleId == styles.id[2]) ? styles.bgColor.dark : styles.bgColor.darkGray;
        $(trackState.styleId).find(focusId).addClass(bgColor).end()
                             .find(focusId + " " + styles.tags.iplay).attr("class", icon);
    }

    const removeStateOfCard = function () {
        var bgColor = (trackState.styleId == styles.id[1] || trackState.styleId == styles.id[2]) ? styles.bgColor.dark : styles.bgColor.darkGray;
        $(trackState.styleId).find(styles.card.wrap).removeClass(bgColor).end()
                             .find(styles.card.wrap + " " + styles.tags.iplay).attr("class", styles.icons.play);
    }

    const setStateOfButton = function (options = {}) {
        if (trackState.id != trackState.currentId &&
           (trackState.styleId == styles.id[3] || trackState.styleId == styles.id[4])) {
             return;
        }

        if (trackState.styleId == styles.id[3] || trackState.styleId == styles.id[4]) {
            var icon = options.status ? styles.icons.pause : styles.icons.play;
            var text = options.status ? "Tạm dừng" : "Tiếp tục phát";
            $(trackState.styleId).find(styles.tags.iplayFollowingSchedule).attr("class", icon).end()
                                 .find(styles.tags.spanplayFollowingSchedule).text(text);
        }
    }

    const removeStateOfButton = function () {
        $(trackState.styleId).find(styles.tags.iplayFollowingSchedule).attr("class", styles.icons.play).end()
                             .find(styles.tags.spanplayFollowingSchedule).text("Phát bài hát");
    }

    const setNotStateFocusOfButtonIf = function () {
        if (trackState.styleId == styles.id[4]) {
            trackState.notFocusStateOfButton = (trackState.currentPos != MUSIC_CONTROL.repo.currentPos) ? true : false;
            removeStateOfButton();
            removeStateOfCard();
        }
    }

    const updateStateForCurrentPage = function () {
        if (trackState.styleId == styles.id[1]) {
            trackState.needFocusStateAtPos = true;
            setStateOfCard({
                status: MUSIC_CONTROL.isPlayMusic(),
                pos: MUSIC_CONTROL.repo.currentPos,
            });
        }

        if (trackState.styleId == styles.id[2] ||
            trackState.styleId == styles.id[3] ||
            trackState.styleId == styles.id[4]) {
            
            trackState.styleId = styles.id[2];
            trackState.needFocusStateAtPos = false;
            setStateOfCard({status: MUSIC_CONTROL.isPlayMusic()});
        }
    }

    const setStateOfNavlink = function (options = {}) {
        ctrls.navbar.find(".nav-link").removeClass(styles.bgColor.darkGray);
        if (options.url != undefined) {
            navlink = options.url;
        }

        if (options.subject != undefined) {
            $(options.subject).addClass(styles.bgColor.darkGray);
        }
    }

    $(document).ready(function () {
        if (navlink == null) {
            navlink = BASE_URL;
            ctrls.navbar.find(".nav-link").first().addClass(styles.bgColor.darkGray);
        }
        manageEvent();
    });

    $(window).on("beforeunload", function() {
        
    });

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        styles: styles,
        trackState: trackState,
        setStateOfCard: setStateOfCard,
        setStateOfButton: setStateOfButton,
        removeStateOfCard: removeStateOfCard,
        removeStateOfButton: removeStateOfButton,
        setNotStateFocusOfButtonIf: setNotStateFocusOfButtonIf,
    }

})();

UI_CONTROL.init();