<div class="wrapper"></div>
<div class="dropdown-menu position-absolute rounded-6 bg-color-white animated-fade-in box-shadow-03 dropdown-menu-<?php echo $key ?>">
    <?php
        foreach (config('adm.categories.options') as $key => $value) {
            if ($key == 0 && $category['parent_id'] == 0) {
                continue;
            }
            ?>
                <a class="dropdown-item d-flex" href="<?php echo route($value['route']['name'], $category['id']) ?>">
                    <i class="<?php echo $value['icon'] ?>"></i>
                    <span class="ml-5"><?php echo $value['title'] ?></span>
                </a>
            <?php
        }
    ?>
</div>