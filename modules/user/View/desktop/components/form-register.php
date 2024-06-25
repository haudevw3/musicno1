<div class="form-register form-wrapper">
    <div class="form-top center-items text-color-white">
        <div class="box-icon center-items rounded-circle">
            <i class="fa-regular fa-compact-disc fs-18"></i>
        </div>
        <div class="box-text ml-10 vertical-center-items fs-18 fw-600">MusicNo1</div>
    </div>
    <div class="form-body">
        <form method="post" action="<?php echo route('register') ?>">
            <div class="mb-4">
                <div class="form-group input-md-02">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" class="form-control" placeholder="Tên đăng nhập" name="username" value="<?php echo old('username') ?>">
                </div>
                <div class="form-text text-color-red"><?php echo error('username') ?></div>
            </div>

            <div class="mb-4">
                <div class="form-group input-md-02">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="text" class="form-control" placeholder="Địa chỉ Email" name="email" value="<?php echo old('email') ?>">
                </div>
                <div class="form-text text-color-red"><?php echo error('email') ?></div>
            </div>

            <div class="mb-4">
                <div class="form-group input-md-02">
                    <i class="fa-regular fa-lock"></i>
                    <input type="password" class="form-control" placeholder="Mật khẩu" name="password" value="<?php echo old('password') ?>">
                </div>
                <div class="form-text text-color-red"><?php echo error('password') ?></div>
            </div>

            <div class="form-group mb-3 center-items">
                <button type="submit" class="btn btn-md-02 bg-color-white">Đăng ký</button>
            </div>
        </form>
    </div>
    <div class="form-bottom">
        <div class="form-group mb-3 center-items">Hoặc</div>

        <div class="form-group mb-4">
            <a href="#" class="btn-md-02 bg-color-dark-03 center-items">Đăng nhập bằng Google</a>
        </div>
        
        <div class="form-group center-items">
            <span>Đã có tài khoản?</span>
            <a class="ml-5 text-color-dark-04" href="<?php echo route('page-login') ?>">Đăng nhập</a>
        </div>
    </div>
</div>