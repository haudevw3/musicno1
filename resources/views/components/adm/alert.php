<?php
    $key = null;
    $message = null;

    if (session()->has('success')) {
        $key = 'success';
    } else if (session()->has('fail')) {
        $key = 'fail';
    }

    if (! is_null($key)) {
        $message = session()->remove($key);
    }

    ?> <div class="alert col-2 p-3 animated-fade-in-up"
            data-key="<?php echo strtoupper($key) ?>"
            data-message="<?php echo $message ?>"></div>
    <?php
?>