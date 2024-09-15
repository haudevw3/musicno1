<nav id="topnav" class="topnav bg-white shadow d-flex fixed-top">
    <div class="left items-align-vertical-center">
        <button id="sidenav-toggle" class="btn btn-icon btn-transparent-dark rounded-circle">
            <i class="fa-sharp fa-regular fa-bars fs-12"></i>
        </button>
        <a class="brand text-black ml-5 fs-16 fw-bold">MusicNo1</a>
    </div>

    <div class="center items-align-vertical-center">
        <div class="input-group input-group-joined input-group-solid">
            <input type="text" class="form-control" placeholder="Search" aria-label="Search">
            <div class="input-group-text"><i class="fa-regular fa-magnifying-glass"></i></div>
        </div>
    </div>

    <div class="right position-relative items-align-vertical-center-end">
        <?php include_one('components.adm.menu-topnav', ['user' => auth()->user()]) ?>
    </div>
</nav>