<div id="form-login" class="form-container card mx-auto">

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
                    <input class="form-control ps-0" type="text" name="username" autocomplete="off" autocapitalize="off" placeholder="Tên đăng nhập hoặc email">
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

            <div class="mb-4 d-flex justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" id="remember" type="checkbox" name="remember" value="false">
                    <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                </div>
                <a href="{{ route('forget-password') }}">Quên mật khẩu</a>
            </div>

            <div class="mb-3">
                <button type="button" id="submit-form-login" class="btn bg-white text-black fw-semibold">Đăng nhập</button>
            </div>

            <div class="mb-3 text-center text-smoke-gray">Hoặc</div>

            <div class="mb-3">
                <a href="{{ route('google-redirect') }}" class="btn bg-dark-gray text-white items-align-center">Đăng nhập bằng Google</a>
            </div>

            <div class="mb-0 text-center">
                <span class="text-dark-gray">Chưa có tài khoản?</span>
                <a href="{{ route('register-page') }}">Đăng ký</a>
            </div>
        </div>
    </div>
</div>