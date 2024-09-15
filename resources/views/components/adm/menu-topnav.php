<button class="btn btn-icon btn-transparent-dark rounded-circle mr-20">
    <i class="fa-regular fa-envelope"></i>
</button>

<button class="btn btn-icon btn-transparent-dark rounded-circle mr-20">
    <i class="fa-regular fa-bell"></i>
</button>

<div class="dropdown">
    <button id="navbar-dropdown-user-image" class="btn btn-icon btn-transparent-dark rounded-circle" data-bs-toggle="dropdown" aria-expanded="false">
        <img width="40" height="40" src="<?php echo random_avatar() ?>" alt="">
    </button>

    <div class="dropdown-menu shadow animated-fade-in-up mt-20" aria-labelledby="navbar-dropdown-user-image">
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