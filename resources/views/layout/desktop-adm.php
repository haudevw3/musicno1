<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_one('components.adm.render-css') ?>
    <?php if (isset($_namespace)) { render_css($_namespace); } ?>
</head>
<body class="body-style">
    <?php include_one('components.adm.alert') ?>
    <?php include_one('components.adm.dialog', isset($dialog) ? compact('dialog') : null) ?>
    <?php include_one('components.adm.header') ?>
    <div class="d-flex">
        <?php include_one('components.adm.navbar') ?>

        <div class="content">
            <?php include_one('components.adm.content-top', isset($label) ? compact('label') : null) ?>
            <div class="content-body">
                <?php if (isset($component)) { require $component; } ?>
            </div>
        </div>
    </div>
    <?php include_one('components.adm.render-js') ?>
    <?php if (isset($_namespace)) { render_js($_namespace); } ?>
</body>
</html>