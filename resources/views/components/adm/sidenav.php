<nav id="sidenav" class="sidenav fixed-top p-20 bg-white shadow-right">
    <div class="sidenav-menu">
        <?php
            foreach (config('menu_adm.sidenav') as $key => $value) {
                ?>
                    <a class="nav-link vertical-center-align-items rounded <?php echo $value['class'] ?>"
                        href="<?php echo route($value['route']['name'], $value['route']['params']) ?>">
                        <div class="btn-icon center-align-items">
                            <i class="<?php echo $value['icon'] ?>"></i>
                        </div>
                        <span class="ml-5"><?php echo $value['title'] ?></span>
                    </a>
                <?php
            }
        ?>
    </div>
</nav>