<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_one('components.user.render-css') ?>
    <?php if (isset($_namespace)) { render_css($_namespace); } ?>
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

            <div class="main-content">
                <?php include_one('components.user.music-style-01') ?>
                <?php include_one('components.user.music-style-02') ?>
                <?php include_one('components.user.music-style-03') ?>
            </div>
        </div>
    </div>

    <div class="footer bg-color-dark-01 fixed-bottom">
        <div class="divider-01"></div>

        <div class="music-container d-flex pl-20 pr-20">
            <?php include_one('components.user.music-left') ?>
            <?php include_one('components.user.music-center') ?>
            <?php include_one('components.user.music-right') ?>
            <?php include_one('components.user.ads') ?>
        </div>
    </div>

    <?php include_one('components.user.render-js') ?>
    <?php if (isset($_namespace)) { render_js($_namespace); } ?>
</body>
</html>