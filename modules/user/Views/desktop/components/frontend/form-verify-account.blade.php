<div id="form-verify-account" class="form-container card mx-auto">

    <div class="form-top card-header items-align-center">
        <i class="fa-regular fa-compact-disc"></i>
        <span class="ml-10">MusicNo1</span>
    </div>

    <div class="card-body">
        <div id="alert" class="alert alert-info fw-semibold" role="alert">
            <li>Chúng tôi đã gửi một mã xác nhận đến email của bạn. Vui lòng vào hòm thư hoặc thư rác để lấy mã xác nhận và nhập vào ô bên dưới.</li>
            <li class="text-danger mt-5">Lưu ý: Chúng tôi chỉ gửi mã xác nhận tối đa là 3 lần trên 1 ngày.
            Nếu sau 3 lần mà bạn không xác thực tài khoản thì bắt buộc chúng tôi phải hủy quá trình và bạn phải xác thực lại vào ngày mai.</li>
        </div>

        <div class="form-content">
            <input type="hidden" name="id" value="{{ $id }}">

            <div class="mb-3">
                <x-core::input-group icon="lock" type="text" name="token_send_mail" placeholder="Mã xác nhận"></x-core::input-group>
            </div>

            <div class="mb-3 d-flex justify-content-end">
                <a id="refresh-token-to-send-mail" class="text-smoke-gray">Gửi lại mã xác nhận</a>
            </div>

            <div class="mb-3">
                <button type="button" id="submit-form-verify-account" class="btn bg-white text-black fw-semibold">Xác nhận tài khoản</button>
            </div>
        </div>
    </div>
</div>