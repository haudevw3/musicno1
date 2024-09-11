<div class="dropdown-menu position-absolute shadow dropdown-menu-<?php echo $key ?>">
    <a class="dropdown-item" href="<?php echo route('adm-add-album', $artist['id']) ?>">
        <i class="fa-regular fa-album"></i>
        <span>Thêm một album</span>
    </a>
    <a class="dropdown-item" href="<?php echo routeHasQueryString('adm-manage-album', ['page' => 1] , ['artist_id' => $artist['id']]) ?>">
        <i class="fa-regular fa-album-collection"></i>
        <span>Quản lý các album</span>
    </a>
</div>