<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_one('components.user.render-css') ?>
    <?php isset($_namespace) ? render_css($_namespace) : null ?>
</head>
<body class="body-style">
    <div class="full-screen d-flex">
        <?php include_one('components.user.navbar') ?>

        <div class="music-content position-relative">
            <?php include_one('components.user.header') ?>

            <div id="main-content" class="main-content">
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

    <div class="footer bg-color-dark-01 fixed-bottom">
        <div class="divider-01"></div>
        <div id="music-control" class="music-container d-flex d-none pl-20 pr-20">
            <?php include_one('components.user.music-control') ?>
        </div>
        <?php include_one('components.user.ads') ?>
    </div>
    
    <?php include_one('components.user.render-js') ?>
    <?php isset($_namespace) ? render_js($_namespace) : null ?>
</body>
</html>