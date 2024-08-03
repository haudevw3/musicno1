<div id="top-playlist" class="style-playlist-top">
    <div class="card-container d-flex justify-content-between">
        <?php
            foreach ($data['first'] as $key => $playlist) {
                ?>
                    <a class="card-link" href="#"><img class="rounded-8" src="<?php echo $playlist['image'] ?>"></a>
                <?php
            }
        ?>
    </div>
</div>