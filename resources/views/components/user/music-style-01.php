<div class="music-style-01">
    <div class="card-container d-flex justify-content-between">
        <?php
            foreach ($musicStyle01['tags'] as $key => $category) {
                ?>
                    <div class="card-wrapper">
                        <a href="#"><img src="<?php echo $category['image'] ?>"></a>
                    </div>
                <?php
            }
        ?>
    </div>
</div>