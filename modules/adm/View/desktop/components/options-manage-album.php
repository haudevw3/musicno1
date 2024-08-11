<div class="wrapper"></div>
<div class="dropdown-menu position-absolute rounded-6 bg-color-white animated-fade-in box-shadow-03 dropdown-menu-<?php echo $key ?>">
    <?php
        foreach (config('adm.album.options') as $key => $value) {
            if ($key == 0 && ($album['type'] == 1) && (! is_null($album['song_ids']))) {
                continue;
            }
            ?>
                <a class="dropdown-item d-flex" href="<?php echo ($key != 1) ? route($value['route']['name'], $album['id'])
                                                                             : routeHasQueryString($value['route']['name'], $value['route']['params'], ['album_id' => $album['id']]) ?>">
                    <i class="<?php echo $value['icon'] ?>"></i>
                    <span class="ml-5"><?php echo $value['title'] ?></span>
                </a>
            <?php
        }
    ?>
</div>