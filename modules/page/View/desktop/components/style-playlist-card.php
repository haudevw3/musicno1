<div id="playlist-card-container" class="playlist-card-container <?php echo isset($data['remove_margin']) ? 'mt-0' : null ?>">
    <?php
        foreach ($data[2] as $key => $category) {
            ?>
                <div class="card-title d-flex justify-content-between <?php echo ($key > 0) ? 'mt-20' : null ?>">
                    <div class="text-color-white fw-600 fs-20"><?php echo $category['name'] ?></div>
                    <?php 
                        if (! array_key_exists('show_all', $data)) {
                            ?><a data-url="<?php echo '/'.$category['slug'] ?>" class="mt-5 fw-600 text-color-dark-04">Hiển thị tất cả</a><?php
                        }
                    ?>
                </div>

                <div class="card-content">
                    <?php
                        if (! empty($category['playlists'])) {
                            foreach ($category['playlists'] as $key => $playlist) {
                                ?>
                                    <div class="card-wrapper p-10 rounded-6 position-relative"
                                         id="<?php echo $playlist['playlist_id'] ?>">
                                        <div class="card-image"><img class="rounded-6" src="<?php echo $playlist['image'] ?>"></div>
                                            <div class="card-interact position-absolute">
                                                <div class="play-music box-icon cursor-pointer center-items rounded-circle text-color-white position-absolute animated-fade-in-up-btn"
                                                     data-pos="0"
                                                     data-id="<?php echo $playlist['playlist_id'] ?>"
                                                     data-url="<?php echo route('get-list-song-for-playlist', $playlist['playlist_id']) ?>">
                                                    <i class="fa-solid fa-play fs-18"></i>
                                                </div>
                                            </div>
                                        <div class="card-text cursor-pointer fw-600 text-color-dark-04 text-overflow-02 mt-5"
                                             data-id="<?php echo $playlist['playlist_id'] ?>"
                                             data-url="<?php echo route('playlist-detail-page', $playlist['playlist_id']) ?>"><?php echo $playlist['name'] ?></div>
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