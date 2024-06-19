<div class="nav-bar fixed-top bg-color-white box-shadow-02">
    <div class="nav-bar-wrap scroll-bar">
        <?php
            foreach (config('menu_adm.navbar') as $key => $value) {
                ?>
                    <a class="nav-link vertical-center-items rounded-6" href="<?php echo route($value['route']['name'], $value['route']['params']) ?>">
                        <div class="box-icon center-items"><i class="<?php echo $value['icon'] ?>"></i></div>
                        <div class="box-text ml-10"><?php echo $value['title'] ?></div>
                    </a>
                <?php
            }
        ?>
    </div>
</div>