<div class="music-style-03">
    <?php
        foreach ($musicStyle03 as $key => $category) {
            ?>
                <div class="box-common d-flex justify-content-between">
                    <div class="box-text text-color-white fw-600 fs-20"><?php echo $category['name'] ?></div>
                    <a href="#" class="box-text mt-5 fw-600 text-color-dark-04">Hiển thị tất cả</a>
                </div>
            <?php
            ?> <div class="card-container"> <?php
            foreach ($category['tags'] as $tags) {
                ?>
                    <a href="" class="card-wrapper">
                        <div class="card-image">
                            <img src="<?php echo $tags['image'] ?>">
                        </div>
                        <div class="card-text fw-600 text-color-dark-04 text-overflow-02 mt-10"><?php echo $tags['name'] ?></div>
                    </a>
                <?php
            }
            ?> </div> <?php
        }
    ?>
</div>