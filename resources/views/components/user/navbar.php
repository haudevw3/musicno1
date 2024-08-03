<div id="navbar" class="nav-bar bg-color-dark-01 fixed-top">
    <div class="nav-bar-top vertical-center-items pl-20 pr-20">
        <a class="d-flex text-color-white vertical-center-items" href="">
            <i class="fa-regular fa-compact-disc fs-18"></i>
            <span class="fs-16 fw-600 ml-10">MusicNo1</span>
        </a>
    </div>
    <div class="nav-bar-body pl-20 pr-20">
        <?php
            foreach (config('menu_user.navbar') as $key => $value) {
                if (! empty($value['class'])) {
                    ?><div class="divider-01 mt-20 mb-20"></div><?php
                }
                ?>
                    <a class="nav-link cursor-pointer vertical-center-items rounded-6 fw-500 mt-10
                        <?php
                            echo (! auth()->user() && in_array($key, ['thu-vien', 'nghe-gan-day', 'bai-hat-yeu-thich', 'danh-sach-phat', 'thiet-lap'])) ? 'text-color-dark-05' : 'text-color-white';
                        ?>" data-url="<?php echo ($key === 'trang-chu') ? '/' : "/$key" ?>">
                        <i class="<?php echo $value['icon'] ?>"></i>
                        <span class="ml-10"><?php echo $value['title'] ?></span>
                    </a>
                <?php
            }
        ?>
    </div>
</div>