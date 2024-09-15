<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_one('components.adm.render-css') ?>
    <?php if (isset($namespace)) { render_css($namespace); } ?>
</head>
<body>
    <div id="overlay" class="overlay"></div>
    <div id="alert" class="alert col-2" role="alert"></div>

    <?php include_one('components.adm.topnav') ?>

    <div id="layout-content" class="layout-content d-flex">
        <?php include_one('components.adm.sidenav') ?>

        <div id="main-content" class="main-content">
            <?php if (isset($mainContent)) { require $mainContent; }  ?>
        </div>
    </div>
    
    <?php include_one('components.adm.render-js') ?>
    <?php if (isset($namespace)) { render_js($namespace); } ?>
</body>
</html>