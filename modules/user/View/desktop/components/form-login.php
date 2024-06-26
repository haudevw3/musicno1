<div class="form-login form-wrapper">
    <div class="form-top center-items text-color-white">
        <div class="box-icon center-items rounded-circle">
            <i class="fa-regular fa-compact-disc fs-18"></i>
        </div>
        <div class="box-text ml-10 vertical-center-items fs-18 fw-600">MusicNo1</div>
    </div>
    <div class="form-body">
        <?php 
            if(session()->has('fail')) {
                ?><div class="alert alert-danger" role="alert"><?php echo session()->remove('fail') ?></div><?php
            }
        ?>
        <form method="post" action="<?php echo route('login') ?>">
            <div class="form-group input-md-02 mb-4">
                <i class="fa-regular fa-user"></i>
                <input type="text" class="form-control" placeholder="Tên đăng nhập" name="username" value="<?php echo old('username') ?>">
            </div>

            <div class="form-group input-md-02 mb-4">
                <i class="fa-regular fa-lock"></i>
                <input type="password" class="form-control" placeholder="Mật khẩu" name="password" value="<?php echo old('password') ?>">
            </div>

            <div class="form-group mb-4 d-flex justify-content-between">
                <div class="form-check form-check-01">
                    <input id="remember" class="form-check-input" type="checkbox" name="remember" value="true">
                    <label for="remember" class="form-check-label">Ghi nhớ đăng nhập</label>
                </div>
                <a class="text-color-dark-04" href="#">Quên mật khẩu?</a>
            </div>

            <div class="form-group mb-3 center-items">
                <button type="submit" class="btn btn-md-02 bg-color-white">Đăng nhập</button>
            </div>
        </form>
    </div>
    <div class="form-bottom">
        <div class="form-group mb-3 center-items">Hoặc</div>

        <div class="form-group mb-4">
            <a href="<?php echo $authUrl ?>" class="btn-md-02 bg-color-dark-03 center-items">Đăng nhập bằng Google</a>
        </div>
        
        <div class="form-group center-items">
            <span>Chưa có tài khoản?</span>
            <a class="ml-5 text-color-dark-04" href="<?php echo route('page-register') ?>">Đăng ký</a>
        </div>
    </div>
</div>