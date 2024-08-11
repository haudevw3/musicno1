<div class="d-flex mt-20 pl-20 pr-20">
    <?php
        foreach (config('adm.categories.actions') as $key => $value) {
            _require('adm.components.actions-render', compact('value'));
        }
    ?>
</div>