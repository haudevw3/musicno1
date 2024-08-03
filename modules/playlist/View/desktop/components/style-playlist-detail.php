<div id="detail-playlist" class="style-playlist-detail mt-20">
    <div class="card-container d-flex p-20 rounded-8">
        <div class="card-image">
            <img class="rounded-6" src="<?php echo $playlist['image'] ?>">
        </div>
        <div class="card-info ml-20 text-color-white">
            <div class="fs-18 fw-600">Danh sách phát</div>
            <div class="fs-24 mt-10 fw-bold"><?php echo $playlist['name'] ?></div>
            <div class="mt-10 d-flex">
                <div class="fs-16 fw-bold">
                    <i class="fa-regular fa-compact-disc"></i>
                    <span class="ml-5">MusicNo1</span>
                </div>
                <div class="ml-10">&bull;</div>
                <div class="vertical-center-items">
                    <div class="ml-10 fw-600"><span><?php echo count($playlist['songs']) ?> bài hát</span> - <span class="text-color-dark-05"><?php echo $playlist['duration'] ?></span></div>
                </div>
            </div>
            <div class="mt-10 text-overflow-03"><?php echo $playlist['description'] ?></div>
        </div>
    </div>

    <div class="card-interact d-flex pl-20 pr-20">
        <div id="play-random-music" class="btn-md-01 center-items text-color-white bg-color-dark-03 cursor-pointer"><i class="fa-solid fa-play"></i><span class="ml-10">Phát ngẫu nhiên</span></div>
        <div class="box-icon center-items text-color-white rounded-circle cursor-pointer bg-color-dark-03 fs-18 ml-20"><i class="fa-regular fa-heart"></i></div>
        <div class="box-icon center-items text-color-white rounded-circle cursor-pointer bg-color-dark-03 fs-18 ml-20"><i class="fa-regular fa-ellipsis"></i></div>
    </div>

    <div class="playlist-container p-20">
        <div class="playlist-header d-flex mt-20 text-color-dark-05 fw-600">
            <div class="column-1 text-center">#</div>
            <div class="column-2">Bài hát</div>
            <div class="column-3">Album</div>
            <div class="column-4 text-end pr-10">Thời gian</div>
        </div>
        <div class="divider-01"></div>
        <div class="playlist-content">
            <?php
                $i = 0;
                foreach ($playlist['songs'] as $key => $song) {
                    $i = $key;
                    $i++;
                    ?>
                        <div class="card-wrapper rounded-6 d-flex mt-10 card-<?php echo $key ?>">
                            <div class="card-column-1 center-items">
                                <div class="box-text fw-500 text-color-dark-04"><?php echo $i ?></div>
                                <div class="play-music box-icon center-items text-color-white cursor-pointer fs-16"
                                     data-position="<?php echo $key ?>" data-id="<?php echo $playlist['playlist_id'] ?>"><i class="fa-solid fa-play"></i></div>
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
                                                $count = count($song['artists']);
                                                if ($count > 1) {
                                                    for ($i = 0; $i < $count; $i++) {
                                                        ?>
                                                            <a class="text-color-dark-05" href="http://"><?php echo $song['artists'][$i]['name'] ?></a>
                                                            <?php
                                                                if ($i < ($count - 1)) {
                                                                    ?><span class="text-color-dark-05">,</span><?php
                                                                }
                                                            ?>
                                                        <?php
                                                    }
                                                } else {
                                                    ?><a class="text-color-dark-05" href="http://"><?php echo $song['artists'][0]['name'] ?></a><?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-column-3">
                                <div class="card-text vertical-center-items">
                                    <div class="fw-500 text-overflow-01">
                                        <a class="text-color-dark-05" href="http://"><?php echo $song['album_name'] ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-column-4 d-flex">
                                <div class="card-interact center-items justify-content-end">
                                    <div class="box-icon center-items rounded-circle text-color-white mr-20"><i class="fa-regular fa-heart"></i></div>
                                    <div class="box-icon box-info center-items rounded-circle text-color-white mr-20"><i class="fa-regular fa-ellipsis"></i></div>
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