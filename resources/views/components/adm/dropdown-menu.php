<div class="wrapper"></div>
<div class="dropdown-menu position-absolute rounded-6 bg-color-white box-shadow-03 animated-fade-in-up">
    <div class="dropdown-top p-10 text-center">
        <div class="box-text fw-bold text-color-black"><?php echo $user->fullname ?></div>
        <div class="box-text fs-12"><?php echo $user->email ?></div>
    </div>
    <div class="divider-01 mt-10 mb-10"></div>
    <div class="dropdown-body">
        <?php
            foreach (config('menu_adm.dropdown-menu') as $key => $value) {
                ?>
                    <a class="dropdown-item fw-600 d-flex" href="<?php echo route($value['route']['name'], $value['route']['params']) ?>">
                        <i class="<?php echo $value['icon'] ?>"></i>
                        <span><?php echo $value['title'] ?></span>
                    </a>
                <?php
            }
        ?>
    </div>
</div>