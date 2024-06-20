<div class="d-flex">
    <div class="form-container box-shadow-01 rounded-6 bg-color-white">
        <div class="form-top">
            <div class="box-text bg-color-white-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo isset($title) ? $title : null ?></div>
            <div class="divider-01"></div>
        </div>
        <div class="form-body p-20">
            <form method="post" action="<?php echo isset($user) ? route('adm-update-user') : route('adm-create-user') ?>">
                <input class="d-none" name="<?php echo isset($user) ? 'id' : null ?>" value="<?php echo isset($user) ? $user['id'] : null ?>" />
                <div class="form-group mb-3 d-flex">
                    <div class="col-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Họ và tên:</span></div>
                    <div class="col-9 position-relative">
                        <i class="icon-md-02 fa-regular fa-user"></i>
                        <input type="text" name="fullname" class="form-control input-md-02" placeholder="Nhập họ và tên" value="<?php echo isset($user) ? $user['fullname'] : old('fullname') ?>" required>
                        <div class="invalid-feedback d-block"><?php echo error('fullname') ?></div>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <div class="col-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Tên đăng nhập:</span></div>
                    <div class="col-9 position-relative">
                        <i class="icon-md-02 fa-regular fa-user"></i>
                        <input type="text" name="username" class="form-control input-md-02" placeholder="Nhập tên đăng nhập" value="<?php echo isset($user) ? $user['username'] : old('username') ?>" required>
                        <div class="invalid-feedback d-block"><?php echo error('username') ?></div>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <div class="col-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Số điện thoại:</span></div>
                    <div class="col-9 position-relative">
                        <i class="icon-md-02 fa-regular fa-phone"></i>
                        <input type="text" name="tel" class="form-control input-md-02" placeholder="Nhập số điện thoại" value="<?php echo isset($user) ? $user['tel'] : old('tel') ?>">
                        <div class="invalid-feedback d-block"><?php echo error('tel') ?></div>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <div class="col-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Email:</span></div>
                    <div class="col-9 position-relative">
                        <i class="icon-md-02 fa-regular fa-envelope"></i>
                        <input type="email" name="email" class="form-control input-md-02" placeholder="Nhập email" value="<?php echo isset($user) ? $user['email'] : old('email') ?>">
                        <div class="invalid-feedback d-block"><?php echo error('email') ?></div>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <div class="col-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Mật khẩu:</span></div>
                    <div class="col-9 position-relative">
                        <i class="icon-md-02 fa-regular fa-lock"></i>
                        <input type="password" name="password" class="form-control input-md-02" placeholder="Nhập mật khẩu" value="<?php echo isset($user) ? 'musicno1' : old('password') ?>" required>
                        <div class="invalid-feedback d-block"><?php echo error('password') ?></div>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <div class="col-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Vai trò:</span></div>
                    <div class="col-9 position-relative">
                        <i class="icon-md-02 fa-regular fa-user"></i>
                        <select class="form-select input-md-02" name="roles">
                            <option value="" selected disabled hidden>Chọn vai trò</option>
                            <option value="1" <?php echo isset($user) ? (($user['roles'] == 1) ? 'selected' : null) : ((old('roles') == 1) ? 'selected' : null) ?>>Quản trị viên</option>
                            <option value="2" <?php echo isset($user) ? (($user['roles'] == 2) ? 'selected' : null) : ((old('roles') == 2) ? 'selected' : null) ?>>Thành viên</option>
                        </select>
                        <div class="invalid-feedback d-block"><?php echo error('roles') ?></div>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex">
                    <div class="col-3 vertical-center-items"><span class="fw-600 text-color-blue-01">Ảnh đại diện:</span></div>
                    <div class="col-9 position-relative">
                        <i class="icon-md-02 fa-regular fa-camera"></i>
                        <input type="text" name="image" class="form-control input-md-02" placeholder="Chọn ảnh đại diện">
                    </div>
                </div>
                <div class="form-bottom col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-md-02 bg-color-blue-01"><?php echo isset($user) ? 'Cập nhật tài khoản' : 'Tạo tài khoản' ?></button>
                </div>
            </form>
        </div>
    </div>
    <?php include_one('adm.components.navbar-user') ?>
</div>