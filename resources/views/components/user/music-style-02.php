<div class="music-style-02">
    <div class="box-common">
        <div class="box-text text-color-white fw-600 fs-20"><?php echo $musicStyle02['name'] ?></div>
    </div>
    <div class="card-container">
        <?php
            foreach ($musicStyle02['tags'] as $key => $song) {
                $key += 1;
                ?>
                    <div class="card-wrapper">
                        <div class="song-detail d-flex" id="card-<?php echo $key ?>">
                            <div class="song-info d-flex cursor-pointer" data-id="<?php echo $key ?>">
                                <div class="song-duration d-none"><?php echo $song['duration'] ?></div>
                                <div class="song-audio d-none"><?php echo $song['audio'] ?></div>
                                <div class="song-image">
                                    <img src="<?php echo $song['image'] ?>">
                                </div>
                                <div class="ml-10 vertical-center-items">
                                    <div class="box-common">
                                        <div class="box-text song-name fw-500 text-color-white text-overflow-01"><?php echo $song['name'] ?></div>
                                        <div class="box-text song-composer fs-12 fw-500 text-color-dark-05 text-overflow-01 mt-5"><?php echo $song['artist_name'] ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="song-interact ml-10 center-items">
                                <div class="box-icon center-items rounded-circle text-color-white"><i class="fa-regular fa-heart"></i></div>
                                <div class="box-icon center-items rounded-circle text-color-white ml-20"><i class="fa-regular fa-ellipsis"></i></div>
                            </div>
                        </div>
                    </div>
                <?php
            }
        ?>
    </div>
</div>