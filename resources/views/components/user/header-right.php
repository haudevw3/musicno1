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