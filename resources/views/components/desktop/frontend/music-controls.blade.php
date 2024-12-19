<div id="music-controls" class="music-controls d-flex justify-content-between">
    <div class="left d-flex">
        <img id="song-image" class="song-image" src="./images/music-1.png" alt="">
        <div id="song-information" class="song-information">
            <div id="song-name" class="song-name text-white text-overflow-1line">Xe anh đến đâu em theo đến đó</div>
            <div id="artist-name" class="artist-name fs-12">
                <a class="text-smoke-gray" href="http://">Dương Hoàng Yến,</a>
                <a class="text-smoke-gray" href="http://">Đạt G</a>
            </div>
        </div>
        <div id="song-interaction" class="song-interaction items-align-center">
            <button id="song-favorite" class="song-favorite btn btn-icon-sm">
                <i class="fa-regular fa-heart"></i>
            </button>

            <button id="song-detail" class="song-detail btn btn-icon-sm ml-5">
                <i class="fa-regular fa-ellipsis"></i>
            </button>
        </div>
    </div>

    <div class="center">
        <div class="actions items-align-center">
            <button class="btn btn-icon text-smoke-gray mr-20">
                <i class="fa-light fa-shuffle"></i>
            </button>

            <button class="btn btn-icon mr-20">
                <i class="fa-solid fa-backward-step"></i>
            </button>

            <button class="btn btn-icon bg-dark-gray">
                <i class="fa-solid fa-play"></i>
            </button>

            <button class="btn btn-icon ml-20">
                <i class="fa-solid fa-forward-step"></i>
            </button>

            <button class="btn btn-icon text-smoke-gray ml-20">
                <i class="fa-light fa-arrows-repeat"></i>
            </button>
        </div>

        <div id="progress" class="progress">
            <span id="timer" class="timer text-white fw-semibold">00:00</span>
            <div id="progress-bar" class="progress-bar">
                <div id="current-progress" class="current-progress"></div>
                <div id="thumb-progress" class="thumb-progress"></div>
            </div>
            <span id="duration" class="duration text-white fw-semibold">05:00</span>
        </div>
    </div>

    <div class="right items-align-vertical-center">
        <button class="btn btn-icon-sm">
            <i class="fa-regular fa-screencast"></i>
        </button>

        <button class="btn btn-icon-sm ml-20">
            <i class="fa-regular fa-microphone"></i>
        </button>

        <button class="btn btn-icon-sm ml-20">
            <i class="fa-regular fa-volume"></i>
        </button>

        <div id="volume-controls" class="volume-controls ml-10">
            <div id="volume-bar" class="volume-bar">
                <div id="current-volume" class="current-volume"></div>
                <div id="thumb-volume" class="thumb-volume"></div>
            </div>
        </div>
    </div>
</div>