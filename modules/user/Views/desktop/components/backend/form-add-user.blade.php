<div id="form-add-user" class="card shadow mt-20 col-8" data-id="{{ isset($user) ? $user->_id : '' }}">
    <div class="card-header fw-semibold">Thêm thành viên</div>

    <div class="card-body">
        <div class="form-content p-20">
            @include('components.alert')

            <div class="mb-3">
                <x-core::input-group-feedback id="name" label="Họ và tên" icon="user" type="text"
                name="name" placeholder="Nhập họ và tên" value="{{ isset($user) ? $user->name : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <x-core::input-group-feedback id="username" label="Tên đăng nhập" icon="user" type="text"
                name="username" placeholder="Nhập tên đăng nhập" value="{{ isset($user) ? $user->username : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <x-core::input-group-feedback id="password" label="Mật khẩu" icon="lock" type="password"
                name="password" placeholder="Nhập mật khẩu" value="{{ isset($user) ? config('label.DEFAULT_PASSWORD') : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <x-core::input-group-feedback id="email" label="Địa chỉ email" icon="envelope" type="email"
                name="email" placeholder="Nhập địa chỉ email" value="{{ isset($user) ? $user->email : '' }}"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <x-core::input-group-feedback id="image" class="ofm" label="Ảnh đại diện: (được bỏ trống)" icon="camera" type="text"
                name="image" placeholder="Nhấn vào đây để chọn ảnh"></x-core::input-group-feedback>
            </div>

            <div class="mb-3">
                <label>Chọn vai trò</label>
                <select class="form-control" name="roles">
                    <option value="1" {{ (isset($user) && in_array(1, $user->roles)) ? 'selected' : '' }}>Quản trị viên</option>
                    <option value="2" {{ (isset($user) && in_array(2, $user->roles)) || ! isset($user) ? 'selected' : '' }}>Thành viên</option>
                </select>
            </div>

            <div class="mb-0 items-align-vertical-center-end">
                <x-core::button id="submit-form-add-user" class="btn-primary" name="{{ isset($user) ? 'Cập nhật người dùng' : 'Tạo người dùng' }}"></x-core::button>
            </div>
        </div>
    </div>
</div>