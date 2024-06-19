<div class="wrapper"></div>
<div class="dropdown-menu position-absolute rounded-6 bg-color-white box-shadow-03 animated-fade-in-up">
    <div class="dropdown-top text-center border-bottom-01">
        <div class="box-text fw-600 text-color-02 fs-14">Nguyễn Văn Hậu</div>
        <div class="box-text fs-12">18nguyenhaukx@gmail.com</div>
    </div>
    <div class="divider-01 mt-10 mb-10"></div>
    <div class="dropdown-body">
        <?php
            foreach (config('menu_adm.dropdown-menu') as $key => $value) {
                ?>
                    <a class="dropdown-item d-flex" href="">
                        <i class="<?php echo $value['icon'] ?>"></i>
                        <span class="ml-10"><?php echo $value['title'] ?></span>
                    </a>
                <?php
            }
        ?>
    </div>
</div>