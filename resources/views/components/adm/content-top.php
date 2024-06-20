<div class="content-top bg-color-linear-gradient">
    <div class="box-common vertical-center-items justify-content-between">
        <div class="box-left">
            <div class="d-flex">
                <div class="box-icon center-items fs-20 fw-600 text-color-03">
                    <i class="<?php echo isset($label) ? ($label == 1 ? 'fa-regular fa-filter' : 'fa-regular fa-pen') : null ?>"></i>
                </div>
                <div class="box-text fs-24 text-color-white fw-600 ml-10">
                    <?php echo isset($label) ? ($label == 1 ? 'Tables' : 'Forms') : null ?>
                </div>
            </div>
            <div class="box-text fs-18 text-color-03 fw-600">Thứ 6, Ngày 22 tháng 12 năm 2023 - 12:00</div>
        </div>
        <div class="box-right bg-color-white d-flex rounded-6 pl-20 pr-20">
            <div class="form-group position-relative">
                <div class="box-icon icon-date-01"><i class="fa-regular fa-calendar"></i></div>
                <input type="text" class="form-control input-date-01" placeholder="May 31, 2024 - May 31, 2024">
            </div>
        </div>
    </div>
</div>