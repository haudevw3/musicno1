<div class="d-flex mt-20 pl-20 pr-20">
    <?php
        foreach (config('adm.user.action') as $key => $value) {
            if ($value['tag'] == 'a') {
                ?>
                    <a class="btn-md center-items <?php echo $value['class'] ?>" href="<?php echo route($value['route']['name']) ?>">
                        <i class="<?php echo $value['icon'] ?>"></i>
                        <span class="ml-5"><?php echo $value['title'] ?></span>
                    </a>
                <?php
            } else {
                ?>
                    <div class="btn-md center-items ml-10 cursor-pointer <?php echo $value['class'] ?>" data-url="<?php echo route($value['route']['name']) ?>">
                        <i class="<?php echo $value['icon'] ?>"></i>
                        <span class="ml-5"><?php echo $value['title'] ?></span>
                    </div>
                <?php
            }
        }
    ?>
</div>