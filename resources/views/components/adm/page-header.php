<?php
    $pageHeaders = [];

    if ($label == 1) {
        $pageHeaders = [
            'icon' => 'fa-regular fa-filter text-gray fs-24',
            'title' => 'Tables',
            'subtitle' => 'An extension of the Simple DataTables library, customized for SB Admin Pro',
        ];
    }

    if ($label == 2) {
        $pageHeaders = [
            'icon' => 'fa-regular fa-pen text-gray fs-24',
            'title' => 'Forms',
            'subtitle' => 'Dynamic form components to give your users informative and intuitive inputs',
        ];
    }
?>
<header id="page-header" class="page-header bg-gradient-primary-to-secondary">
    <div class="page-header-content mt-20">
        <div class="col-7">
            <div class="page-header-title d-flex">
                <div class="page-header-icon">
                    <i class="<?php echo $pageHeaders['icon'] ?>"></i>
                </div>
                <h2 class="text-white ml-10"><?php echo $pageHeaders['title'] ?></h2>
            </div>
            <div class="page-header-subtitle text-gray fs-18"><?php echo $pageHeaders['subtitle'] ?></div>
        </div>
    </div>
</header>