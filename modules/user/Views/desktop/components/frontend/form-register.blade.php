<div id="form-register" class="form-container card mx-auto">

    <div class="form-top card-header items-align-center">
        <i class="fa-regular fa-compact-disc"></i>
        <span class="ml-10">MusicNo1</span>
    </div>

    <div class="card-body">
        @include('components.alert')

        <div class="form-content">
            <div class="mb-4">
                <x-core::input-group icon="user" type="text" name="name" placeholder="Họ và tên"></x-core::input-group>
            </div>

            <div class="mb-4">
                <x-core::input-group icon="user" type="text" name="username" placeholder="Tên đăng nhập"></x-core::input-group>
            </div>

            <div class="mb-4">
                <x-core::input-group icon="envelope" type="email" name="email" placeholder="Email"></x-core::input-group>
            </div>

            <div class="mb-4">
                <x-core::input-group icon="lock" type="password" name="password" placeholder="Mật khẩu"></x-core::input-group>
            </div>

            <div class="mb-3">
                <button type="button" id="btn-register" class="btn bg-white text-black fw-semibold">Đăng ký</button>
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