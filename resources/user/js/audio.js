const AUDIO = (function () {

    var ctrls = {};
    var instance = null;
    var duration = 0;

    var bindControl = function () {

    }

    var bindFunction = function () {

    }

    const prepareAudio = function (url) {
        if (instance == null) {
            instance = new Audio(url);
        }
        instance.src = url;
        instance.load();
    }

    const playAudio = function () {
        instance.play();
    }

    const pauseAudio = function () {
        instance.pause();
    }

    const setTime = function (time) {
        instance.currentTime = time;
    }

    const setVolume = function (value) {
        instance.volume = value;
    }

    const formatTime = function (secs) {
        var minutes = Math.floor(secs / 60);
        var seconds = Math.floor(secs % 60);
        return `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
    }

    const formatDuration = function (duration) {
        var parts = duration.split(":");
        var minutes = parseInt(parts[0], 10);
        var seconds = parseInt(parts[1], 10);
        return minutes * 60 + seconds;
    }

    const updateTime = function (subject = {}) {
        duration = formatDuration(subject.durationMusic.text());
        $(instance).on("timeupdate", function () {
            var currentTime = instance.currentTime;
            if (! MUSIC_CONTROL.isDragMusic()) {
                MUSIC_CONTROL.updateProgressCurrentMusic({
                    time: currentTime,
                    currentTimeMusic: subject.currentTimeMusic,
                    progressCurrentMusic: subject.progressCurrentMusic,
                });
            }
        });
        endedAudio();
    }

    const endedAudio = function () {
        $(instance).off("ended");
        $(instance).on("ended", function () {
            MUSIC_CONTROL.setIsPlay(false);
            // $(MUSIC_CONTROL.getPlayMusic()).find("i").attr("class", "fa-solid fa-play");
            if (MUSIC_CONTROL.isLoopMusic()) {
                MUSIC_CONTROL.getPlayMusic().click();
            } else {
                MUSIC_CONTROL.getNextMusic().click();
            }
        })
    }

    const getDuration = function () {
        return duration;
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        prepareAudio: prepareAudio,
        playAudio: playAudio,
        pauseAudio: pauseAudio,
        endedAudio: endedAudio,
        updateTime: updateTime,
        setTime: setTime,
        setVolume: setVolume,
        formatTime: formatTime,
        formatDuration: formatDuration,
        getDuration: getDuration,
    }
    
})();

AUDIO.init();