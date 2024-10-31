<div id="form-register" class="form-container card mx-auto">

    <div class="form-top card-header items-align-center">
        <i class="fa-regular fa-compact-disc"></i>
        <span class="ml-10">MusicNo1</span>
    </div>

    <div class="card-body">
        <div id="alert" class="d-none" role="alert"></div>

        <div class="form-content">
            <div class="mb-4">
                <div class="input-group input-group-joined input-group-solid">
                    <span class="input-group-text">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input class="form-control ps-0" type="text" name="name" autocomplete="off" autocapitalize="off" placeholder="Họ và tên">
                </div>
            </div>

            <div class="mb-4">
                <div class="input-group input-group-joined input-group-solid">
                    <span class="input-group-text">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input class="form-control ps-0" type="text" name="username" autocomplete="off" autocapitalize="off" placeholder="Tên đăng nhập">
                </div>
            </div>

            <div class="mb-4">
                <div class="input-group input-group-joined input-group-solid">
                    <span class="input-group-text">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input class="form-control ps-0" type="email" name="email" autocomplete="off" autocapitalize="off" placeholder="Email">
                </div>
            </div>

            <div class="mb-4">
                <div class="input-group input-group-joined input-group-solid">
                    <span class="input-group-text">
                        <i class="fa-regular fa-lock"></i>
                    </span>
                    <input class="form-control ps-0" type="password" name="password" placeholder="Mật khẩu">
                </div>
            </div>

            <div class="mb-3">
                <button type="button" id="submit-form-register" class="btn bg-white text-black fw-semibold">Đăng ký</button>
            </div>

            <div class="mb-3 text-center text-smoke-gray">Hoặc</div>

            <div class="mb-3">
                <a class="btn bg-dark-gray text-white items-align-center">Đăng nhập bằng Google</a>
            </div>

            <div class="mb-0 text-center">
                <span class="text-dark-gray">Đã có tài khoản?</span>
                <a href="{{ route('login-page') }}">Đăng nhập</a>
            </div>
        </div>
    </div>
</div>