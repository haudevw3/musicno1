<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_one('components.adm.render-css') ?>
    <?php if (isset($_namespace)) { render_css($_namespace); } ?>
</head>
<body>
    <div id="overlay" class="overlay"></div>
    <div id="alert" class="alert col-2" role="alert"></div>
    <?php include_one('components.adm.topnav') ?>
    <div id="layout-content" class="layout-content d-flex">
        <?php include_one('components.adm.sidenav') ?>

        <div id="main-content" class="main-content">
            <?php if (isset($label)) { include_one('components.adm.page-header', compact('label')); } ?>

            <div id="page-main-content" class="page-main-content d-flex justify-content-between">
                <?php 
                    if (isset($components)) { 
                        foreach ($components as $component) {
                            require $component;
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <?php include_one('components.adm.render-js') ?>
    <?php if (isset($_namespace)) { render_js($_namespace); } ?>
</body>
</html>