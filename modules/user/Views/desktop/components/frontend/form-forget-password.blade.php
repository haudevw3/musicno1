<div id="form-forget-password" class="form-container card mx-auto">

    <div class="form-top card-header items-align-center">
        <i class="fa-regular fa-compact-disc"></i>
        <span class="ml-10">MusicNo1</span>
    </div>

    <div class="card-body">
        @include('components.alert')
        
        <div class="form-content">
            <div class="mb-3">
                <x-core::input-group icon="envelope" type="email" name="email" placeholder="Email"></x-core::input-group>
            </div>

            <div class="mb-3">
                <button type="button" id="btn-forget-password" class="btn bg-white text-black fw-semibold">Gửi yêu cầu</button>
            </div>
        </div>
    </div>
</div>