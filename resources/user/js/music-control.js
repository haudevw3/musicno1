const MUSIC_CONTROL = (function () {

    var ctrls = {};
    var position = 0;
    var currentTime = 0;
    var length = 0;
    var isPlay = false;
    var isLoop = false;
    var isDrag = false;
    var isShuffle = false;
    var isDragVolume = false;
    var showControl = false;
    var shuffleItems = null;
    var shufflePosition = null;
    var songs = null;
    var styles = null;

    var bindControl = function () {
        var self = {};
        self.ads = $("#ads");
        self.musicControl = $("#music-control");
        self.playMusic = $("#play-music");
        self.nextMusic = $("#next-music");
        self.previousMusic = $("#previous-music");
        self.loopMusic = $("#loop-music");
        self.shuffleMusic = $("#shuffle-music");
        self.durationMusic = $("#duration-music");
        self.currentTimeMusic = $("#current-time-music");
        self.progressMusic = $("#progress-music");
        self.progressCurrentMusic = $("#progress-current-music");
        self.volumeMusic = $("#volume-music");
        self.volumeIcon = $("#volume-icon");
        self.volumeCurrentMusic = $("#volume-current-music");
        return self;
    }

    var bindFunction = function () {
        ctrls.playMusic.on("click", eventOnclickButtonPlayMusic);
        ctrls.nextMusic.on("click", eventOnclickButtonNextMusic);
        ctrls.previousMusic.on("click", eventOnclickButtonPreviousMusic);
        ctrls.loopMusic.on("click", eventOnclickButtonLoopMusic);
        ctrls.shuffleMusic.on("click", eventOnclickButtonShuffleMusic);
        ctrls.progressMusic.on("click", eventOnclickProgressMusic);
        ctrls.progressMusic.on("mousedown", eventOnMouseDownProgressMusic);
        ctrls.volumeMusic.on("click", eventOnclickVolumeMusic);
        ctrls.volumeMusic.on("mousedown", eventOnMouseDownVolumeMusic);
    }

    const eventOnclickButtonPlayMusic = function () {
        if (! isPlay) {
            AUDIO.playAudio();
            AUDIO.updateTime({
                currentTimeMusic: ctrls.currentTimeMusic,
                progressCurrentMusic: ctrls.progressCurrentMusic,
                durationMusic: ctrls.durationMusic,
            });
            isPlay = true;
            showControl = true;
            ctrls.playMusic.find("i").attr("class", "fa-solid fa-pause");
            toogleButtonPlayMusicForCurrentStyles(true);
        } else {
            AUDIO.pauseAudio();
            isPlay = false;
            ctrls.playMusic.find("i").attr("class", "fa-solid fa-play");
            toogleButtonPlayMusicForCurrentStyles(false);
        }
        if (showControl) {
            ctrls.ads.addClass("d-none");
            ctrls.musicControl.removeClass("d-none").addClass("d-block");
        }
    }

    const eventOnclickButtonNextMusic = function () {
        if (isShuffle) {
            shufflePosition++;
            if (shufflePosition > length) {
                shufflePosition = 0;
            }
        } else {
            position++;
            if (position > length) {
                position = 0;
            }
        }
        setTimeout(function () {
            bootMusic(isShuffle ? shuffleItems[shufflePosition] : position);
        }, 100);
    }

    const eventOnclickButtonPreviousMusic = function () {
        if (isShuffle) {
            shufflePosition--;
            if (shufflePosition < 0) {
                shufflePosition = length;
            }
        } else {
            position--;
            if (position < 0) {
                position = length;
            }
        }
        setTimeout(function () {
            bootMusic(isShuffle ? shuffleItems[shufflePosition] : position);
        }, 100);
    }

    const eventOnclickButtonLoopMusic = function () {
        if (! isLoop) {
            isLoop = true;
            ctrls.loopMusic.removeClass("text-color-dark-05").addClass("text-color-white");
        } else {
            isLoop = false;
            ctrls.loopMusic.removeClass("text-color-white").addClass("text-color-dark-05");
        }
    }

    const eventOnclickButtonShuffleMusic = function () {
        if (! isShuffle) {
            shufflePosition = -1;
            isShuffle = true;
            shuffleItems = shuffleArray();
            ctrls.shuffleMusic.removeClass("text-color-dark-05").addClass("text-color-white");
        } else {
            shufflePosition = null;
            shuffleItems = null;
            isShuffle = false;
            ctrls.shuffleMusic.removeClass("text-color-white").addClass("text-color-dark-05");
        }
    }

    const shuffleArray = function () {
        var array = [];
        for (let i = 0; i <= length; i++) {
            array.push(i)
        }
        for (let i = length - 1; i > 0; i--) {
            let j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array; 
    }

    const eventOnclickProgressMusic = function (e) {
        updateProgressMusic(e);
        setCurrentTime();
    }

    const eventOnMouseDownProgressMusic = function () {
        isDrag = true;
        $(document).on("mouseup", eventOnMouseUpProgressMusic);
        $(document).on("mousemove", eventOnMouseMoveProgressMusic);
    }

    const eventOnMouseUpProgressMusic = function () {
        isDrag = false;
        setCurrentTime();
        $(document).off("mouseup");
        $(document).off("mousemove");
    }

    const eventOnMouseMoveProgressMusic = function (e) {
        if (isDrag) {
            updateProgressMusic(e);
        }
    }

    const updateProgressMusic = function (e) {
        var width = ctrls.progressMusic.width();
        var offsetX = e.pageX - ctrls.progressMusic.offset().left;
        var position = Math.max(0, Math.min(offsetX, width));
        var time = (position / width) * AUDIO.getDuration();
        if (position >= 0 && position <= width) {
            currentTime = time;
            updateProgressCurrentMusic({
                time: time,
                currentTimeMusic: ctrls.currentTimeMusic,
                progressCurrentMusic: ctrls.progressCurrentMusic,
            });
        }
    }

    const updateProgressCurrentMusic = function (subject = {}) {
        $(subject.currentTimeMusic).text(AUDIO.formatTime(subject.time));
        $(subject.progressCurrentMusic).stop(true, true).css({ width: (subject.time / AUDIO.getDuration()) * 100 + "%" });
    }

    const setCurrentTime = function () {
        if (currentTime > 0) {
            AUDIO.setTime(currentTime);
            currentTime = 0;
        }
    }

    const eventOnclickVolumeMusic = function (e) {
        updateVolumeMusic(e);
    }

    const eventOnMouseDownVolumeMusic = function () {
        isDragVolume = true;
        $(document).on("mouseup", eventOnMouseUpVolumeMusic);
        $(document).on("mousemove", eventOnMouseMoveVolumeMusic);
    }

    const eventOnMouseUpVolumeMusic = function () {
        isDragVolume = false;
        $(document).off("mouseup");
        $(document).off("mousemove");
    }

    const eventOnMouseMoveVolumeMusic = function (e) {
        if (isDragVolume) {
            updateVolumeMusic(e);
        }
    }

    const updateVolumeMusic = function (e) {
        var width = ctrls.volumeMusic.width();
        var offsetX = e.pageX - ctrls.volumeMusic.offset().left;
        var position = Math.max(0, Math.min(offsetX, width));
        var value = position / width;
        if (position >= 0 && position <= width) {
            AUDIO.setVolume(value);
            ctrls.volumeCurrentMusic.stop(true, true).css({ width: value * 100 + "%" });
        }
        if (position > 0) {
            ctrls.volumeIcon.find("i").removeClass("fa-regular fa-volume-xmark").addClass("fa-regular fa-volume");
        } else {
            ctrls.volumeIcon.find("i").removeClass("fa-regular fa-volume").addClass("fa-regular fa-volume-xmark");
        }
    }

    const prepare = function (pos, data = {}, _styles = {}) {
        songs = data.songs;
        length = songs.length - 1;
        styles = _styles;
        position = pos;
        bootMusic(position);
    }

    const bootMusic = function (pos) {
        var song = songs[pos];
        if (isPlay) {
            isPlay = false;
            AUDIO.pauseAudio();
        }
        setTimeout(function () {
            prepareMusic(song);
            eventOnclickButtonPlayMusic();
            AUDIO.endedAudio();
            SESSION.set("song_pos", pos);
            focusCurrentCard(pos);
        }, 100);
    }

    const prepareMusic = function (song = {}) {
        var html = "";
        var artists = song.artists;
        for (let i = 0; i < artists.length; i++) {
            html += `<a class="text-color-dark-05" href="http://">${artists[i].name}</a>`;
            if (i < artists.length - 1) {
                html += `<span class="text-color-dark-05">, </span>`;
            }
        }
        ctrls.musicControl.find("#song-image img").attr("src", song.image);
        ctrls.musicControl.find("#song-name").text(song.name);
        ctrls.durationMusic.text(song.duration);
        ctrls.musicControl.find("#artist-name").html(html);
        AUDIO.prepareAudio(song.audio);
    }

    const focusCurrentCard = function (pos) {
        if (styles != null) {
            pos = ! styles.isFocus ? SESSION.get("playlist_pos") : pos;
            if (styles.isFocus) {
                $(styles.current).find(styles.card).removeClass(styles.class[0]);
                $(styles.current).find(styles.prefix + pos).addClass(styles.class[0]);
            }
            $(styles.current).find(styles.card + " " + styles.tags[0]).attr("class", styles.icons[0] + " " + styles.class[1])
            $(styles.current).find(styles.prefix + pos + " " + styles.tags[0]).attr("class", styles.icons[1] + " " + styles.class[1]);
        }
    }

    const toogleButtonPlayMusicForCurrentStyles = function (status) {
        var icon = null;
        var text = null;
        if (status) {
            icon = styles.icons[1];
            text = "Tạm dừng";
        } else {
            icon = styles.icons[0];
            text = "Tiếp tục phát";
        }
        
        if (styles != null) {
            var pos = ! styles.isFocus ? SESSION.get("playlist_pos") : position;
            $(styles.current).find(styles.prefix + pos + " " + styles.tags[0]).attr("class", styles.class[1] + " " + icon);
            if (styles.current == UI_CONTROL.styles.id[3]) {
                $(styles.current).find(styles.button[1] + " i").attr("class", icon).end().find(styles.button[1] + " span").text(text);
            }
        }
    }

    const isPlayMusic = function () {
        return isPlay;
    }

    const isLoopMusic = function () {
        return isLoop;
    }

    const isDragMusic = function () {
        return isDrag;
    }

    const isShuffleMusic = function () {
        return isShuffle;
    }

    const getPlayMusic = function () {
        return ctrls.playMusic;
    }

    const getNextMusic = function () {
        return ctrls.nextMusic;
    }

    const getPreviousMusic = function () {
        return ctrls.previousMusic;
    }

    const getShuffleItems = function () {
        return shuffleItems;
    }

    const setIsPlay = function (status) {
        isPlay = status;
    }

    const setStyles = function (_styles) {
        styles = _styles;
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        prepare: prepare,
        isPlayMusic: isPlayMusic,
        isLoopMusic: isLoopMusic,
        isDragMusic: isDragMusic,
        isShuffleMusic: isShuffleMusic,
        getPlayMusic: getPlayMusic,
        getNextMusic: getNextMusic,
        getPreviousMusic: getPreviousMusic,
        getShuffleItems: getShuffleItems,
        setIsPlay: setIsPlay,
        setStyles: setStyles,
        updateProgressCurrentMusic: updateProgressCurrentMusic,
    }

})();

MUSIC_CONTROL.init();