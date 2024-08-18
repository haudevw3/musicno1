<div id="album-detail" class="album-detail d-flex">
    <div class="card-container">
        <div class="card-info rounded-8 p-20">
            <div class="card-image center-items">
                <img class="rounded-6" src="<?php echo $album['image'] ?>">
            </div>

            <div class="mt-10 fs-18 fw-bold text-center text-color-white">
                <?php echo $album['name'].' ('.config('adm.album.types')[$album['type']]['name'].')' ?>
            </div>

            <div class="fs-12 fw-600 text-center text-color-dark-05">
                <?php
                    $artists = [];
                    if ($album['type'] == 1) {
                        $artists = $album['songs'][0]['artists'];
                    }
                    for ($i = 0; $i < count($artists); $i++) {
                        ?>
                            <a class="text-color-dark-05 cursor-pointer" data-url="">
                                <?php echo $artists[$i]['name'] ?>
                            </a>
                            <?php if ($i < (count($artists) - 1)) { ?><span class="text-color-dark-05">,</span><?php } ?>
                        <?php
                    }
                ?>
                <span>&bull; <?php echo $album['release_year'] ?></span>
            </div>

            <div class="mt-10 fs-13 center-items text-color-white">
                <div class="fw-bold">
                    <i class="fa-regular fa-compact-disc"></i>
                    <span class="ml-5">MusicNo1</span>
                </div>
                <div class="fw-600 ml-5">
                    <span>&bull; <?php echo $album['total'].' bài hát - ' ?></span>
                    <span class="text-color-dark-05"><?php echo $album['duration'] ?></span>
                </div>
            </div>
        </div>
        <div class="card-interact center-items">
            <div class="btn-md-01 center-items text-color-white bg-color-dark-03 cursor-pointer"
                 id="play-following-schedule-music">
                <i class="fa-solid fa-play"></i>
                <span class="ml-10">Phát bài hát</span>
            </div>
            <div class="box-icon center-items text-color-white rounded-circle cursor-pointer bg-color-dark-03 fs-18 ml-20"><i class="fa-regular fa-heart"></i></div>
            <div class="box-icon center-items text-color-white rounded-circle cursor-pointer bg-color-dark-03 fs-18 ml-20"><i class="fa-regular fa-ellipsis"></i></div>
        </div>
    </div>

    <div class="album-container p-20">
        <div class="album-head d-flex mt-20 text-color-dark-05 fw-600">
            <div class="column-1 text-center">#</div>
            <div class="column-2">Bài hát</div>
            <div class="column-3 text-end pr-10">Thời gian</div>
        </div>
        <div class="divider-01"></div>
        <div class="album-content mt-20">
            <?php
                $i = 0;
                foreach ($album['songs'] as $key => $song) {
                    $i = $key;
                    $i++;
                    ?>
                        <div class="card-wrapper rounded-6 d-flex" <?php echo ($key == 0) ? "id='card-first'" : null ?>>
                            <div class="card-column-1 center-items">
                                <div class="box-text fw-500 text-color-dark-04"><?php echo $i ?></div>
                                <div class="play-music box-icon center-items text-color-white cursor-pointer fs-16">
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
                                <div class="card-interact center-items justify-content-end">
                                    <div class="box-icon center-items cursor-pointer rounded-circle text-color-white mr-20"><i class="fa-regular fa-heart"></i></div>
                                    <div class="box-icon box-info center-items cursor-pointer rounded-circle text-color-white mr-20"><i class="fa-regular fa-ellipsis"></i></div>
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