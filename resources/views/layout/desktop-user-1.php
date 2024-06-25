<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_one('components.user.render-css') ?>
    <?php if (isset($_namespace)) { render_css($_namespace); } ?>
</head>
<body class="body-style">
    <div class="form-container form-login center-items">
        <?php if (isset($component)) { require $component; } ?>
    </div>

    <?php include_one('components.user.render-js') ?>
    <?php if (isset($_namespace)) { render_js($_namespace); } ?>
</body>
</html>