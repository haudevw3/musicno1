<div id="form-manage-user" class="card shadow col-9"
    data-id="<?php echo isset($user) ? $user['id'] : 0 ?>"
    data-url="<?php echo isset($user) ? route('adm-update-user', $user['id']) : route('adm-create-user') ?>">

    <div class="card-header fs-16 fw-semibold text-blue"><?php echo 'Biểu mẫu '. mb_strtolower($title) ?></div>
    <div class="card-body">
        <div class="form-content p-20">
            <div id="fullname" class="mb-3">
                <label>Họ và tên:</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" name="fullname" class="form-control" placeholder="Nhập họ và tên..."
                        value="<?php echo isset($user) ? $user['fullname'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="username" class="mb-3">
                <label>Tên đăng nhập:</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng nhập..."
                        value="<?php echo isset($user) ? $user['username'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="email" class="mb-3">
                <label>Email:</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="text" name="email" class="form-control" placeholder="Nhập email..."
                        value="<?php echo isset($user) ? $user['email'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="password" class="mb-3">
                <label>Mật khẩu:</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu..."
                        value="<?php echo isset($user) ? 'musicno1' : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="tel" class="mb-3">
                <label>Số điện thoại: ( được bỏ trống )</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-phone"></i>
                    <input type="text" name="tel" class="form-control" placeholder="Nhập số điện thoại..."
                        value="<?php echo isset($user) ? $user['tel'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div id="role" class="mb-3">
                <label>Chọn vai trò:</label>
                <select name="role" class="form-control">
                    <?php $role = isset($user) ? $user['role'] : 2 ?>
                    <option value="1" <?php echo ($role == 1) ? 'selected' : null ?>>Quản trị viên</option>
                    <option value="2" <?php echo ($role == 2) ? 'selected' : null ?>>Thành viên</option>
                </select>
            </div>

            <div id="image" class="mb-3">
                <label>Hình ảnh: ( chỉ chấp nhận các tập tin có đuôi jpg, jpeg, png - được bỏ trống )</label>
                <div class="input-group-validation">
                    <i class="fa-regular fa-camera"></i>
                    <input type="text" name="image" class="form-control ofm" placeholder="Nhấn vào đây để chọn hình ảnh..."
                        value="<?php echo isset($user) ? $user['image'] : null ?>">
                    <span class="invalid-feedback"></span>
                </div>
            </div>

            <div class="mt-20 items-align-vertical-center-end">
                <button id="submit-form-user" class="btn btn-primary">
                    <?php echo isset($user) ? 'Cập nhật tài khoản' : 'Tạo tài khoản' ?>
                </button>
            </div>
        </div>
    </div>
</div>