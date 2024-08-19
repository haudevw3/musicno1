<div id="song-card-container" class="song-card-container">
    <div class="card-title">
        <div class="text-color-white fw-bold fs-20"><?php echo $data[1]['name'] ?></div>
    </div>
    <div class="card-content">
        <?php
            foreach ($data[1]['songs'] as $key => $song) {
                ?>
                    <div class="card-wrapper rounded-6 d-flex p-10 card-<?php echo $key ?>">
                        <div class="card-info d-flex">
                            <div class="card-image position-relative">
                                <img class="rounded-6" src="<?php echo $song['image'] ?>">
                                <div class="play-music box-icon position-absolute center-items cursor-pointer rounded-6 bg-color-transparent"
                                     data-pos="<?php echo $key ?>"
                                     data-id="<?php echo $data['id'] ?>"
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