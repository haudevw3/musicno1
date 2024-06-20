<div class="wrapper"></div>
<div class="dropdown-menu dropdown-menu-<?php echo $key ?> position-absolute rounded-6 bg-color-white animated-fade-in box-shadow-03">
    <?php
        foreach (config('adm.user.option') as $key => $value) {
            ?>
                <a class="dropdown-item d-flex" href="">
                    <i class="<?php echo $value['icon'] ?>"></i>
                    <span class="ml-10"><?php echo $value['title'] ?></span>
                </a>
            <?php
        }
    ?>
</div>