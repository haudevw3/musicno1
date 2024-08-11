<div class="wrapper"></div>
<div class="dropdown-menu position-absolute rounded-6 bg-color-white animated-fade-in box-shadow-03 dropdown-menu-<?php echo $key ?>">
    <?php
        foreach (config('adm.artist.options') as $key => $value) {
            ?>
                <a class="dropdown-item d-flex" href="<?php echo ($key != 1) ? route($value['route']['name'], $artist['id'])
                                                                             : routeHasQueryString($value['route']['name'], $value['route']['params'], ['artist_id' => $artist['id']]) ?>">
                    <i class="<?php echo $value['icon'] ?>"></i>
                    <span class="ml-5"><?php echo $value['title'] ?></span>
                </a>
            <?php
        }
    ?>
</div>