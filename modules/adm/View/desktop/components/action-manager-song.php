<div class="d-flex mt-20 pl-20 pr-20">
    <?php
        foreach (config('adm.song.action') as $key => $value) {
            _require('adm.components.action-render', compact('value'));
        }
    ?>
</div>