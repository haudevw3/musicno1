<div class="nav-bar fixed-top bg-color-white box-shadow-02">
    <div class="nav-bar-wrapper pl-20 pr-20 scroll-bar">
        <?php
            foreach (config('menu_adm.navbar') as $key => $value) {
                ?>
                    <a class="nav-link fw-600 vertical-center-items rounded-6 <?php echo $value['class'] ?>" href="<?php echo route($value['route']['name'], $value['route']['params']) ?>">
                        <i class="<?php echo $value['icon'] ?>"></i>
                        <span class="ml-5"><?php echo $value['title'] ?></span>
                    </a>
                <?php
            }
        ?>
    </div>
</div>