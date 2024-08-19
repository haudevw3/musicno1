<div id="playlist-detail" class="playlist-detail">
    <div class="card-content d-flex p-20 rounded-8">
        <div class="card-image">
            <img class="rounded-6" src="<?php $images = explode('|', $playlist['image']); echo (count($images) > 1) ? $images[1] : $playlist['image'];?>">
        </div>
        <div class="card-info ml-20 text-color-white">
            <div class="fs-18 fw-bold">Danh sách phát</div>
            <div class="fs-24 fw-bold mt-10"><?php echo $playlist['name'] ?></div>
            <div class="mt-10 d-flex">
                <div class="fw-bold">
                    <i class="fa-regular fa-compact-disc"></i>
                    <span class="ml-5">MusicNo1</span>
                </div>
                <div class="fw-600 ml-5">
                    <span>&bull; <?php echo $playlist['total'].' bài hát - ' ?></span>
                    <span class="text-color-dark-05"><?php echo $playlist['duration'] ?></span>
                </div>
            </div>
            <div class="card-text mt-10 text-overflow-03"><?php echo $playlist['description'] ?></div>
        </div>
    </div>

    <div class="card-interact d-flex pl-20 pr-20">
        <div class="btn-md-01 center-items text-color-white bg-color-dark-03 cursor-pointer"
             id="play-following-schedule-music"
             data-pos="0"
             data-id="<?php echo $playlist['playlist_id'] ?>"
             data-url="<?php echo route('get-list-song-for-playlist', $playlist['playlist_id']) ?>">
            <i class="fa-solid fa-play"></i>
            <span class="ml-10">Phát bài hát</span>
        </div>
        <div class="box-icon center-items text-color-white rounded-circle cursor-pointer bg-color-dark-03 fs-18 ml-20"><i class="fa-regular fa-heart"></i></div>
        <div class="box-icon center-items text-color-white rounded-circle cursor-pointer bg-color-dark-03 fs-18 ml-20"><i class="fa-regular fa-ellipsis"></i></div>
    </div>

    <div class="playlist-container p-20">
        <div class="playlist-head d-flex mt-20 text-color-dark-05 fw-600">
            <div class="column-1 text-center">#</div>
            <div class="column-2">Bài hát</div>
            <div class="column-3">Album</div>
            <div class="column-4 text-end pr-10">Thời gian</div>
        </div>
        <div class="divider-01"></div>
        <div class="playlist-content mt-20">
            <?php
                $i = 0;
                foreach ($playlist['songs'] as $key => $song) {
                    $i = $key;
                    $i++;
                    ?>
                         <div class="card-wrapper mt-10 rounded-6 d-flex card-<?php echo $key ?>">
                            <div class="card-column-1 center-items">
                                <div class="box-text fw-500 text-color-dark-04"><?php echo $i ?></div>
                                <div class="play-music box-icon center-items text-color-white cursor-pointer fs-16"
                                     data-pos="<?php echo $key ?>"
                                     data-id="<?php echo $playlist['playlist_id'] ?>"
                                     data-url="<?php echo route('get-list-song-for-playlist', $playlist['playlist_id']) ?>">
                                    <i class="fa-solid fa-play"></i>
                                </div>
                            </div>
                            <div class="card-column-2">
                                <div class="card-info d-flex">
                                    <div class="card-image">
                                        <img class="rounded-6" src="<?php echo $song['image'] ?>">
                                    </div>
                                    <div class="card-text ml-10">
                                        <div class="fw-500 text-color-white text-overflow-01"><?php echo $song['name'] ?></div>
                                        <div class="fs-12 fw-500 text-overflow-01 mt-5">
                                            <?php
                                                $artists = $song['artists'];
                                                for ($i = 0; $i < count($artists); $i++) {
                                                    ?>
                                                        <a class="text-color-dark-05 cursor-pointer" href="http://"><?php echo $artists[$i]['name'] ?></a>
                                                        <?php if ($i < (count($artists) - 1)) { ?><span class="text-color-dark-05">,</span><?php } ?>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-column-3">
                                <div class="card-text vertical-center-items">
                                    <div class="fw-500 text-overflow-01">
                                        <a class="album-name text-color-dark-05 cursor-pointer"
                                           data-pos="<?php echo $key ?>"
                                           data-id="<?php echo $playlist['playlist_id'] ?>"
                                           data-url="<?php echo route('get-list-song-for-playlist', $playlist['playlist_id']) ?>"
                                           album-url="<?php echo route('album-detail-page', $song['album']['album_id']) ?>">
                                            <?php echo $song['album']['name'].' ('.config('adm.album.types')[$song['album']['type']]['name'].')' ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-column-4">
                                <div class="card-interact center-items justify-content-end">
                                    <div class="box-icon center-items rounded-circle cursor-pointer text-color-white mr-20"><i class="fa-regular fa-heart"></i></div>
                                    <div class="box-icon box-info center-items rounded-circle cursor-pointer text-color-white mr-20"><i class="fa-regular fa-ellipsis"></i></div>
                                    <div class="box-time fw-500 text-color-dark-04 center-items mr-20"><?php echo $song['duration'] ?></div>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>