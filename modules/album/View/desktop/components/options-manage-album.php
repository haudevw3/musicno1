<div class="dropdown-menu animated-fade-in-up shadow dropdown-menu-<?php echo $key ?>">
    <a class="dropdown-item" href="<?php echo routeHasQueryString('adm-manage-song', ['page' => 1] , ['album_id' => $album['id']]) ?>">
        <i class="fa-regular fa-compact-disc fs-14"></i>
        <span>Quản lý các bài hát</span>
    </a>
    <?php
        if ($album['type'] > 1) {
            ?>
                <a class="dropdown-item" href="<?php echo route('adm-add-song', $album['id']) ?>">
                    <i class="fa-regular fa-circle-plus fs-14"></i>
                    <span>Thêm một bài hát</span>
                </a>
            <?php
        }
    ?>
</div>