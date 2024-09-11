<div class="btn-icon center-align-items rounded-circle cursor-pointer mr-20">
    <i class="fa-regular fa-envelope"></i>
</div>
<div class="btn-icon center-align-items rounded-circle cursor-pointer mr-20">
    <i class="fa-regular fa-bell"></i>
</div>
<div id="navbar-dropdown-user-image" class="btn-icon rounded-circle cursor-pointer center-align-items">
    <img class="rounded-circle" width="40" height="40" src="<?php echo random_avatar() ?>" alt="">

    <div class="dropdown-menu position-absolute shadow animated-fade-in-up">
        <header class="p-10 text-center">
            <div class="text-black fw-bold"><?php echo $user->fullname ?></div>
            <div class="fs-12"><?php echo $user->email ?></div>
        </header>
        <div class="dropdown-divider"></div>
        <?php
            foreach (config('menu_adm.topnav.dropdown-menu') as $key => $value) {
                ?>
                    <a class="dropdown-item" href="<?php echo route($value['route']['name'], $value['route']['params']) ?>">
                        <i class="<?php echo $value['icon'] ?>"></i>
                        <span><?php echo $value['title'] ?></span>
                    </a>
                <?php
            }
        ?>
    </div>
</div>