<div class="header fixed-top bg-color-white box-shadow-01 d-flex pl-20 pr-20">
    <div class="header-left vertical-center-items">
        <div class="box-bar box-icon center-items rounded-circle cursor-pointer">
            <i class="fa-sharp fa-regular fa-bars fs-12"></i>
        </div>
        <div class="box-text text-color-black ml-5 vertical-center-items fs-16 fw-bold">MusicNo1</div>
    </div>

    <div class="header-center vertical-center-items">
        <div class="box-search">
            <form action="">
                <div class="form-group input-search">
                    <input type="text" class="form-control" placeholder="Search" required>
                    <div class="box-icon"><i class="fa-regular fa-magnifying-glass"></i></div>
                </div>
            </form>
        </div>
    </div>

    <div class="header-right vertical-center-items justify-content-end position-relative">
        <div class="box-icon center-items rounded-circle cursor-pointer mr-20">
            <i class="fa-regular fa-envelope"></i>
        </div>
        <div class="box-icon center-items rounded-circle cursor-pointer mr-20">
            <i class="fa-regular fa-bell"></i>
        </div>
        <div class="box-image box-user rounded-circle cursor-pointer center-items">
            <img class="rounded-circle" src="<?php echo random_avatar() ?>" alt="">
        </div>

        <?php include_one('components.adm.dropdown-menu', ['user' => auth()->user()]) ?>
    </div>
</div>