<div id="form-forget-password" class="form-container card mx-auto">

    <div class="form-top card-header items-align-center">
        <i class="fa-regular fa-compact-disc"></i>
        <span class="ml-10">MusicNo1</span>
    </div>

    <div class="card-body">
        <div id="alert" class="d-none" role="alert"></div>
        
        <div class="form-content">
            <div class="mb-3">
                <x-core::base-input icon="envelope" type="email" name="email" placeholder="Email"></x-core::base-input>
            </div>

            <div class="mb-3">
                <button type="button" id="submit-form-forget-password" class="btn bg-white text-black fw-semibold">Gửi yêu cầu</button>
            </div>
        </div>
    </div>
</div>