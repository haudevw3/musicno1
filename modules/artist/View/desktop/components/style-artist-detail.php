<div id="artist-detail" class="artist-detail">
    <div class="artist-info">
        <div class="card-content d-flex p-20 rounded-8">
            <div class="card-image">
                <img class="rounded-circle" src="<?php echo $artist['image'] ?>">
            </div>
            <div class="card-info ml-20 text-color-white">
                <div class="fs-18 fw-bold">Nghệ sĩ</div>
                <div class="fs-24 fw-bold mt-10"><?php echo $artist['name'] ?></div>
                <div class="mt-10 d-flex">
                    <div class="fw-bold">
                        <i class="fa-regular fa-compact-disc"></i>
                        <span class="ml-5">MusicNo1</span>
                    </div>
                    <div class="fw-600 ml-5">
                        <span>&bull; <?php echo $artist['total'].' bài hát - ' ?></span>
                        <span class="text-color-dark-05"><?php echo $artist['duration'] ?></span>
                    </div>
                </div>
                <div class="card-text mt-10 text-overflow-03"><?php echo $artist['description'] ?></div>
            </div>
        </div>

        <div class="card-interact d-flex pl-20 pr-20">
            <div class="btn-md-01 center-items text-color-white bg-color-dark-03 cursor-pointer"
                id="play-following-schedule-music"
                data-pos="0"
                data-id=""
                data-url="">
                <i class="fa-solid fa-play"></i>
                <span class="ml-10">Phát bài hát</span>
            </div>
            <div class="box-icon center-items text-color-white rounded-circle cursor-pointer bg-color-dark-03 fs-18 ml-20"><i class="fa-regular fa-heart"></i></div>
            <div class="box-icon center-items text-color-white rounded-circle cursor-pointer bg-color-dark-03 fs-18 ml-20"><i class="fa-regular fa-ellipsis"></i></div>
        </div>
    </div>
    
    <div class="artist-container">
        <div id="song-card-container" class="song-card-container">
            <div class="card-title d-flex justify-content-between">
                <div class="text-color-white fw-bold fs-20"><?php echo $artist[1]['name'] ?></div>
                <a href="#" class="mt-5 fw-600 text-color-dark-04">Hiển thị tất cả</a>
            </div>
            <div class="card-content">
                <?php
                    foreach ($artist[1]['songs'] as $key => $song) {
                        ?>
                            <div class="card-wrapper rounded-6 d-flex p-10 card-<?php echo $key ?>">
                                <div class="card-info d-flex">
                                    <div class="card-image position-relative">
                                        <img class="rounded-6" src="<?php echo $song['image'] ?>">
                                        <div class="play-music box-icon position-absolute center-items cursor-pointer rounded-6 bg-color-transparent"
                                            data-pos="<?php echo $key ?>"
                                            data-id="<?php echo $artist['id'] ?>"
                                            data-url="<?php echo route('get-list-song-by-tags', ['tags' => 2]) ?>">
                                            <i class="fa-solid fa-play text-color-white fs-18"></i>
                                        </div>
                                    </div>
                                    <div class="card-text ml-10">
                                        <div class="fw-500 text-color-white text-overflow-01 mt-10"><?php echo $song['name'] ?></div>
                                        <div class="fs-12 fw-500 text-overflow-01 mt-5">
                                            <?php
                                                $artists = $song['artists'];
                                                for ($i = 0; $i < count($artists); $i++) {
                                                    ?>
                                                        <a class="text-color-dark-05 cursor-pointer"
                                                        data-url="<?php echo route('artist-detail-page', $artists[$i]['artist_id']) ?>"><?php echo $artists[$i]['name'] ?></a>
                                                        <?php if ($i < (count($artists) - 1)) { ?><span class="text-color-dark-05">,</span><?php } ?>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-interact vertical-center-items ml-10">
                                    <div class="box-icon center-items rounded-circle cursor-pointer text-color-white"><i class="fa-regular fa-heart"></i></div>
                                    <div class="box-icon center-items rounded-circle cursor-pointer text-color-white ml-10"><i class="fa-regular fa-ellipsis"></i></div>
                                </div>
                            </div>
                        <?php
                    }
                ?>
            </div>
        </div>

        <div id="album-card-container" class="album-card-container">
            <?php
                foreach ($artist[2] as $key => $category) {
                    ?>
                        <div class="card-title d-flex justify-content-between <?php echo ($key > 0) ? 'mt-20' : null ?>">
                            <div class="text-color-white fw-bold fs-20"><?php echo $category['name'] ?></div>
                            <a class="show-all cursor-pointer mt-5 fw-600 text-color-dark-04" data-url="">Hiển thị tất cả</a>
                        </div>

                        <div class="card-content">
                            <?php
                                if (! empty($category['albums'])) {
                                    foreach ($category['albums'] as $key => $album) {
                                        ?>
                                            <div class="card-wrapper p-10 rounded-6 position-relative"
                                                id="">
                                                <div class="card-image"><img class="rounded-6" src="<?php echo $album['image'] ?>"></div>
                                                    <div class="card-interact position-absolute">
                                                        <div class="play-music box-icon cursor-pointer center-items rounded-circle text-color-white position-absolute animated-fade-in-up-btn"
                                                            data-pos="0"
                                                            data-id=""
                                                            data-url="">
                                                            <i class="fa-solid fa-play fs-18"></i>
                                                        </div>
                                                    </div>
                                                <div class="card-text cursor-pointer fw-600 text-color-dark-04 text-overflow-02 mt-5"
                                                    data-id=""
                                                    data-url=""><?php echo $album['release_year'].' &bull; '.$album['name'] ?></div>
                                            </div>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>