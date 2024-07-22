<div class="form-container bg-color-white rounded-6 box-shadow-01">
    <div class="form-top">
        <div class="box-text bg-color-gray-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
        <div class="divider-01"></div>
    </div>
    <div class="form-body p-20">
        <form method="post" action="<?php echo isset($user) ? route('adm-update-user') : route('adm-create-user') ?>">
            <input name="<?php echo isset($user) ? 'id' : null ?>" type="text" class="d-none"
                   value="<?php echo isset($user) ? $user['id'] : null ?>" />

            <input name="<?php echo isset($user) ? 'image_url' : null ?>" type="text" class="d-none"
                   value="<?php echo isset($user) ? $user['image'] : null ?>" />

            <div class="mb-3">
                <label for="fullname" class="form-label fw-600">Họ và tên:</label>
                <div class="form-group input-md-01">
                    <i class="fa-regular fa-user"></i>
                    <input name="fullname" type="text" id="fullname" class="form-control" placeholder="Nhập họ và tên"
                           value="<?php echo isset($user) ? $user['fullname'] : old('fullname') ?>">
                </div>
                <div class="form-text text-color-red"><?php echo error('fullname') ?></div>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label fw-600">Tên đăng nhập:</label>
                <div class="form-group input-md-01">
                    <i class="fa-regular fa-user"></i>
                    <input name="username" type="text" id="username" class="form-control" placeholder="Nhập tên đăng nhập"
                           value="<?php echo isset($user) ? $user['username'] : old('username') ?>">
                </div>
                <div class="form-text text-color-red"><?php echo error('username') ?></div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-600">Email:</label>
                <div class="form-group input-md-01">
                    <i class="fa-regular fa-envelope"></i>
                    <input name="email" type="email" id="email" class="form-control" placeholder="Nhập email"
                           value="<?php echo isset($user) ? $user['email'] : old('email') ?>">
                </div>
                <div class="form-text text-color-red"><?php echo error('email') ?></div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-600">Mật khẩu:</label>
                <div class="form-group input-md-01">
                    <i class="fa-regular fa-lock"></i>
                    <input name="password" type="password" id="password" class="form-control" placeholder="Nhập mật khẩu"
                           value="<?php echo isset($user) ? 'musicno1' : old('password') ?>">
                </div>
                <div class="form-text text-color-red"><?php echo error('password') ?></div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-600">Vai trò:</label>
                <select class="form-select" name="role">
                    <option value="0" selected disabled hidden>Chọn vai trò</option>
                    <?php
                        foreach (config('user.roles') as $key => $value) {
                            ?>
                                <option value="<?php echo $key ?>"
                                <?php echo isset($user) ? (($user['role'] == $key) ? 'selected' : null) 
                                : ((old('role') == $key) ? 'selected' : null) ?>><?php echo $value ?></option>
                            <?php
                        }
                    ?>
                </select>
                <div class="form-text text-color-red"><?php echo error('role') ?></div>
            </div>

            <div class="mb-3">
                <label for="tel" class="form-label fw-600">Số điện thoại: ( được bỏ trống )</label>
                <div class="form-group input-md-01">
                    <i class="fa-regular fa-phone"></i>
                    <input name="tel" type="text" id="tel" class="form-control" placeholder="Nhập số điện thoại"
                           value="<?php echo isset($user) ? $user['tel'] : old('tel') ?>">
                </div>
                <div class="form-text text-color-red"><?php echo error('tel') ?></div>
            </div>

            <div class="mb-3">
                <label for="file-upload" class="form-label fw-600">Ảnh đại diện: ( được bỏ trống )</label>
                <div class="form-group input-md-01">
                    <i class="fa-regular fa-camera"></i>
                    <input class="col-12 file-upload" id="file-upload" type="file" name="image">
                </div>
                <div class="form-text text-color-red"></div>
            </div>

            <div class="form-bottom mt-20 col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-md-01 bg-color-blue-01"><?php echo isset($user) ? 'Cập nhật tài khoản' : 'Tạo tài khoản' ?></button>
            </div>
        </form>
    </div>
</div>