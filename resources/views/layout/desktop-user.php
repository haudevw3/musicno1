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
            <div class="header bg-color-dark-01 d-flex fixed-top">
                <?php include_one('components.user.header-left') ?>
                <?php include_one('components.user.header-center') ?>
                <?php include_one('components.user.header-right') ?>
            </div>

            <div id="main-content" class="main-content"></div>
        </div>
    </div>

    <div class="footer bg-color-dark-01 fixed-bottom">
        <div class="divider-01"></div>
        <div id="music-control" class="music-container d-flex d-none pl-20 pr-20">
            <?php include_one('components.user.music-left') ?>
            <?php include_one('components.user.music-center') ?>
            <?php include_one('components.user.music-right') ?>
        </div>
        <?php include_one('components.user.ads') ?>
    </div>

    <?php include_one('components.user.render-js') ?>
    <?php isset($_namespace) ? render_js($_namespace) : null ?>
</body>
</html>