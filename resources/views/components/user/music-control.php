<div class="music-left vertical-center-items">
    <div class="song-info vertical-center-items">
        <div class="song-image">
            <img class="rounded-6" width="80px" height="80px" src="./music-1.png" alt="">
        </div>
        <div class="box-common ml-10">
            <div class="box-text song-name fw-500 text-color-white text-overflow-01"></div>
            <div class="box-text song-composer fs-12 fw-500 text-color-dark-05 text-overflow-01"></div>
        </div>
    </div>
    <div class="song-interact center-items">
        <div class="box-icon center-items rounded-circle text-color-white cursor-pointer"><i class="fa-regular fa-heart"></i></div>
        <div class="box-icon center-items rounded-circle text-color-white cursor-pointer ml-10"><i class="fa-regular fa-ellipsis"></i></div>
    </div>
</div>
<div class="music-center vertical-center-items">
    <div class="music-wrapper">
        <div class="music-control d-flex center-items">
            <div id="shuffle-music" class="box-icon center-items rounded-circle cursor-pointer text-color-dark-05 fs-20"><i class="fa-light fa-shuffle"></i></div>
            <div id="previous-music" class="box-icon center-items rounded-circle cursor-pointer text-color-white fs-20 ml-20"><i class="fa-solid fa-backward-step"></i></div>
            <div id="play-music" class="box-icon center-items rounded-circle cursor-pointer text-color-white fs-18 ml-20 bg-color-dark-03"><i class="fa-solid fa-play"></i></div>
            <div id="next-music" class="box-icon center-items rounded-circle cursor-pointer text-color-white fs-20 ml-20"><i class="fa-solid fa-forward-step"></i></div>
            <div id="loop-music" class="box-icon center-items rounded-circle cursor-pointer text-color-dark-05 fs-20 ml-20"><i class="fa-light fa-arrows-repeat"></i></div>
        </div>
        <div class="music-progress center-items">
            <div id="current-time-music" class="box-text fw-500 text-color-white">00:00</div>
            <div class="progress-wrapper cursor-pointer ml-20 mr-20">
                <div id="progress-music" class="progress-root d-flex">
                    <div id="progress-current-music" class="progress-custom"></div>
                    <div id="progress-thumb-music" class="progress-thumb rounded-circle"></div>
                </div>
            </div>
            <div id="duration-music" class="box-text fw-500 text-color-white">00:00</div>
        </div>
    </div>
</div>
<div class="music-right center-items">
    <div class="box-icon center-items rounded-circle text-color-white cursor-pointer"><i class="fa-regular fa-screencast"></i></div>
    <div class="box-icon center-items rounded-circle text-color-white cursor-pointer ml-20"><i class="fa-regular fa-microphone"></i></div>
    <div id="volume-icon" class="box-icon center-items rounded-circle text-color-white cursor-pointer ml-20"><i class="fa-regular fa-volume"></i></div>
    <div class="volume-control vertical-center-items ml-10">
        <div class="volume-wrapper cursor-pointer">
            <div id="volume-music" class="volume-root d-flex">
                <div id="volume-current-music" class="volume-custom"></div>
                <div id="volume-thumb-music" class="volume-thumb rounded-circle"></div>
            </div>
        </div>
    </div>
</div>