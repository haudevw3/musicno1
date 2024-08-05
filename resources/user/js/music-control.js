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
    var repo = null;
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
            toogleStateForButtonPlayMusic(true);
        } else {
            AUDIO.pauseAudio();
            isPlay = false;
            ctrls.playMusic.find("i").attr("class", "fa-solid fa-play");
            toogleStateForButtonPlayMusic(false);
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
            prepareDataAndBootMusic(isShuffle ? shuffleItems[shufflePosition] : position);
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
            prepareDataAndBootMusic(isShuffle ? shuffleItems[shufflePosition] : position);
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

    const setData = function (data = {}) {
        repo = data.repo;
        styles = data.styles;
        position = data.pos;
        length = repo.length - 1;
    }

    const prepareDataAndBootMusic = function (pos) {
        var song = repo.data[pos];
        UI_CONTROL.setPosForRepo(pos);
        if (isPlay) {
            isPlay = false;
            AUDIO.pauseAudio();
        }
        setTimeout(function () {
            prepareMusic(song);
            prepareFocus(repo.currentStyle, repo.currentPos, repo.isFocus);
            eventOnclickButtonPlayMusic();
            AUDIO.endedAudio();
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

    const prepareFocus = function (currentStyle, pos, isFocus) {
        pos = ! repo.isFocus ? repo.playlistPos : pos;
        
        if (isFocus) {
            $(currentStyle).find(styles.card.wrap).removeClass(styles.class[0]);
            $(currentStyle).find(styles.card.prefix + pos).addClass(styles.class[0]);
        }
        $(currentStyle).find(styles.card.wrap + " " + styles.tags[0]).attr("class", styles.icons.play + " " + styles.class[1]);
        $(currentStyle).find(styles.card.prefix + pos + " " + styles.tags[0]).attr("class", styles.icons.pause + " " + styles.class[1]);
    }

    const toogleStateForButtonPlayMusic = function (status) {
        var icon = null;
        var text = null;
        if (status) {
            icon = styles.icons.pause;
            text = "Tạm dừng";
        } else {
            icon = styles.icons.play;
            text = "Tiếp tục phát";
        }
        var pos = ! repo.isFocus ? repo.playlistPos : position;
        $(repo.currentStyle).find(styles.card.prefix + pos + " " + styles.tags[0]).attr("class", icon + " " + styles.class[1]);
        if (repo.currentStyle == styles.id[3]) {
            $(repo.currentStyle).find(styles.button.playRandom + " i").attr("class", icon).end().find(styles.button.playRandom + " span").text(text);
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

    const setRepo = function (_repo) {
        repo = _repo;
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        isPlayMusic: isPlayMusic,
        isLoopMusic: isLoopMusic,
        isDragMusic: isDragMusic,
        isShuffleMusic: isShuffleMusic,
        getPlayMusic: getPlayMusic,
        getNextMusic: getNextMusic,
        getPreviousMusic: getPreviousMusic,
        getShuffleItems: getShuffleItems,
        setData:setData,
        setIsPlay: setIsPlay,
        setRepo: setRepo,
        prepareDataAndBootMusic: prepareDataAndBootMusic,
        updateProgressCurrentMusic: updateProgressCurrentMusic,
    }

})();

MUSIC_CONTROL.init();