<div id="top-card-container" class="top-card-container">
    <div class="card-content d-flex justify-content-between">
        <?php
            foreach ($data[0] as $key => $playlist) {
                ?>
                    <a class="card-link" data-url="<?php echo 'playlist/'.$playlist['playlist_id'] ?>">
                        <img class="rounded-8" src="<?php echo explode('|', $playlist['image'])[0] ?>">
                    </a>
                <?php
            }
        ?>
    </div>
</div>