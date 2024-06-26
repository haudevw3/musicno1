<div class="box-image box-user bg-color-dark-03 rounded-circle cursor-pointer center-items">
    <img class="rounded-circle" src="<?php echo $user->image ?? random_avatar() ?>" alt="">
</div>

<div class="wrapper"></div>
<div class="dropdown-menu position-absolute rounded-6 bg-color-dark-02 animated-fade-in-up">
    <div class="dropdown-top p-10 text-center">
        <div class="box-text text-color-white"><?php echo $user->fullname ?? $user->username ?></div>
        <div class="box-text text-color-dark-04 fs-12"><?php echo $user->email ?></div>
    </div>
    <div class="divider-01 mt-10 mb-10"></div>
    <div class="dropdown-body">
        <?php
            $array = config('menu_user.dropdown-menu');
            if ($user->role == 2) {
                unset($array['trang-quan-tri']);
            }
            foreach ($array as $key => $value) {
                ?>
                    <a class="dropdown-item text-color-white d-flex" href="<?php echo route($value['route']['name'], $value['route']['params']) ?>">
                        <i class="<?php echo $value['icon'] ?>"></i>
                        <span><?php echo $value['title'] ?></span>
                    </a>
                <?php
            }
        ?>
    </div>
</div>