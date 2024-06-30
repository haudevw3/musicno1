<div class="music-style-02">
    <div class="box-common">
        <div class="box-text text-color-white fw-600 fs-20"><?php echo $musicStyle02['name'] ?></div>
    </div>
    <div class="card-container">
        <div class="card-wrapper vertical-center-items">
            <?php
                foreach ($musicStyle02['tags'] as $key => $song) {
                    ?>
                        <div class="song-detail cursor-pointer d-flex">
                            <div class="song-image">
                                <img src="<?php echo $song['image'] ?>">
                            </div>
                            <div class="song-info ml-10 vertical-center-items">
                                <div class="box-common">
                                    <div class="box-text fw-500 text-color-white text-overflow-01"><?php echo $song['name'] ?></div>
                                    <div class="box-text fs-12 fw-500 text-color-dark-05 text-overflow-01 mt-5"><?php echo $song['artist_name'] ?></div>
                                </div>
                            </div>
                            <div class="song-interact ml-10 center-items">
                                <div class="box-icon center-items rounded-circle text-color-white"><i class="fa-regular fa-heart"></i></div>
                                <div class="box-icon center-items rounded-circle text-color-white ml-20"><i class="fa-regular fa-ellipsis"></i></div>
                            </div>
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>