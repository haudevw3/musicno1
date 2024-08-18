<div class="header bg-color-dark-01 d-flex fixed-top">
    <div class="header-left vertical-center-items d-flex">
        <div class="box-icon center-items rounded-circle cursor-pointer bg-color-dark-03"><i class="fa-regular fa-chevron-left fs-18 text-color-white"></i></div>
        <div class="box-icon center-items rounded-circle cursor-pointer bg-color-dark-03 ml-20"><i class="fa-regular fa-chevron-right fs-18 text-color-white"></i></div>
    </div>

    <div class="header-center vertical-center-items">
        <div class="box-search ml-20">
            <form action="">
                <div class="form-group input-md-01 position-relative">
                    <input type="text" class="form-control" placeholder="Tìm kiếm nghệ sĩ, bài hát..." required>
                    <i class="fa-regular fa-magnifying-glass"></i>
                </div>
            </form>
        </div>
    </div>

    <div class="header-right vertical-center-items justify-content-end position-relative">
        <?php
            if (! is_null(auth()->user())) {
                $user = auth()->user();
                include_one('components.user.dropdown-menu', compact('user'));
            } else {
                ?>
                    <a class="btn-md-01 center-items text-color-white bg-color-dark-03 mr-20" href="<?php echo route('page-register') ?>">Đăng ký</a>
                    <a class="btn-md-01 center-items text-color-dark bg-color-white" href="<?php echo route('page-login') ?>">Đăng nhập</a>
                <?php
            }
        ?>
    </div>
</div>