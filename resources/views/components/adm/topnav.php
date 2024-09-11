<nav id="topnav" class="topnav bg-white shadow d-flex fixed-top">
    <div class="left vertical-center-align-items pl-20">
        <div id="sidenav-toggle" class="btn-icon center-align-items rounded-circle cursor-pointer">
            <i class="fa-sharp fa-regular fa-bars fs-12"></i>
        </div>
        <a class="brand text-black ml-5 fs-16 fw-bold">MusicNo1</a>
    </div>
    <div class="center vertical-center-align-items">
        <form action="" method="get" class="ml-10">
            <div class="input-group input-group-joined input-group-solid">
                <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                <div class="input-group-text"><i class="fa-regular fa-magnifying-glass"></i></div>
            </div>
        </form>
    </div>
    <div class="right pr-20 vertical-center-align-items justify-content-end position-relative">
        <?php include_one('components.adm.menu-topnav', ['user' => auth()->user()]) ?>
    </div>
</nav>