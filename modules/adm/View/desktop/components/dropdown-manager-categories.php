<div class="wrapper"></div>
<div class="dropdown-menu position-absolute rounded-6 bg-color-white animated-fade-in box-shadow-03 dropdown-menu-<?php echo $key ?>">
    <?php
        foreach (config('adm.categories.option') as $key => $value) {
            if ($parent_id > 0) {
                _require('adm.components.dropdown-render', compact('value', 'id'));
            }
        }
    ?>
</div>