<div class="dialog-wrapper wrapper bg-color-transparent dialog-hide"></div>
<div class="dialog-container bg-color-white rounded-8 box-shadow-01 animated-slide-down">
    <div class="dialog-top p-20 d-flex justify-content-between">
        <div class="fs-18 fw-bold vertical-center-items">Thông báo</div>
        <div class="box-icon dialog-hide center-items cursor-pointer rounded-circle"><i class="fa-regular fa-xmark fs-20"></i></div>
    </div>
    <div class="divider-01"></div>
    <div class="dialog-body text-break p-20 fw-600 fs-16"><?php echo isset($dialog) ? $dialog : null ?></div>
    <div class="divider-01"></div>
    <div class="dialog-bottom p-20 d-flex justify-content-end">
        <div class="btn-md-01 bg-color-purple center-items dialog-hide cursor-pointer">Hủy bỏ</div>
        <div class="btn-md-01 bg-color-blue center-items ml-10 agree cursor-pointer">
            <a class="text-color-white">Đồng ý</a>
        </div>
    </div>
</div>