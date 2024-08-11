<div id="default-playlist" class="style-playlist-card" <?php echo isset($data['remove_margin']) ? 'style="margin-top:0"' : null ?>>
    <?php
        foreach ($data['third'] as $key => $category) {
            ?>
                <div <?php echo ($key > 0) ? 'style="margin-top:40px"' : null ?> class="card-header d-flex justify-content-between">
                    <div class="text-color-white fw-600 fs-20"><?php echo $category['name'] ?></div>
                    <a href="#" class="mt-5 fw-600 text-color-dark-04">Hiển thị tất cả</a>
                </div>

                <div class="card-container">
                    <?php
                        if (! empty($category['playlists'])) {
                            foreach ($category['playlists'] as $key => $playlist) {
                                ?>
                                    <div class="card-wrapper card-<?php echo $key ?>">
                                        <div class="card-info position-relative">
                                            <div class="card-image"><img class="rounded-6" src="<?php echo $playlist['image'] ?>"></div>
                                            <div class="card-interact center-items position-absolute bg-color-transparent">
                                                <div class="box-icon center-items rounded-circle text-color-white"><i class="fa-regular fa-heart fs-20"></i></div>
                                                <div class="play-music box-icon center-items rounded-circle text-color-white ml-20"
                                                     data-pos="<?php echo $key ?>" data-id="<?php echo $playlist['playlist_id'] ?>"><i class="fa-solid fa-play fs-20"></i></div>
                                                <div class="box-icon center-items rounded-circle text-color-white ml-20"><i class="fa-regular fa-ellipsis fs-20"></i></div>
                                            </div>
                                        </div>
                                        <a class="card-link cursor-pointer fw-600 text-color-dark-04 text-overflow-02 mt-5"
                                           data-pos="<?php echo $key ?>"
                                           data-id="<?php echo $playlist['playlist_id'] ?>"
                                           data-url="<?php echo route('playlist-detail-page', $playlist['playlist_id']) ?>"><?php echo $playlist['name'] ?></a>
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