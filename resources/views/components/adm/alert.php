<?php
    $key = null;

    if (session()->has('success')) {
        $key = 'success';
    } else if (session()->has('fail')) {
        $key = 'fail';
    }

    if (! is_null($key)) {
        $message = session()->remove($key);
        ?> <div class="alert-data d-none" data-key="<?php echo strtoupper($key) ?>" data-message="<?php echo $message ?>"></div> <?php
    }
?>

<div class="alert-container alert col-2 p-3 animated-fade-in-up"></div>