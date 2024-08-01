<div id="style-playlist-song" class="style-playlist-song">
    <div class="card-header d-flex justify-content-between">
        <div class="text-color-white fw-600 fs-20"><?php echo $data['second']['name'] ?></div>
    </div>
    <div class="card-container">
        <?php
            foreach ($data['second']['songs'] as $key => $song) {
                ?>
                    <div class="card-wrapper rounded-6 d-flex p-10 card-<?php echo $key ?>">
                        <div class="card-info d-flex">
                            <div class="card-image position-relative">
                                <img class="rounded-6" src="<?php echo $song['image'] ?>">
                                <div class="play-music box-icon position-absolute center-items rounded-6 bg-color-transparent"
                                     data-position="<?php echo $key ?>" data-id="<?php echo $data['second']['playlist_id'] ?>">
                                    <i class="fa-solid fa-play text-color-white fs-18"></i>
                                </div>
                            </div>
                            <div class="card-text ml-10">
                                <div class="fw-500 text-color-white text-overflow-01 mt-10"><?php echo $song['name'] ?></div>
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
                        <div class="card-interact vertical-center-items ml-10">
                            <div class="box-icon center-items rounded-circle text-color-white"><i class="fa-regular fa-heart"></i></div>
                            <div class="box-icon center-items rounded-circle text-color-white ml-10"><i class="fa-regular fa-ellipsis"></i></div>
                        </div>
                    </div>
                <?php
            }
        ?>
    </div>
</div>