<nav id="topnav" class="topnav bg-white shadow d-flex fixed-top">
    <div class="left items-align-vertical-center">
        <button id="sidenav-toggle" class="btn btn-icon btn-transparent-dark rounded-circle">
            <i class="fa-sharp fa-regular fa-bars fs-12"></i>
        </button>
        <a class="brand text-black ml-10 fw-bold">MusicNo1</a>
    </div>

    <div class="center items-align-vertical-center">
        <div id="docsearch" class="docsearch input-group input-group-joined input-group-solid">
            <input type="text" class="form-control" placeholder="Search" aria-label="Search">
            <div class="input-group-text"><i class="fa-regular fa-magnifying-glass"></i></div>
        </div>
    </div>

    <div class="right items-align-vertical-center-end">
        <button class="btn btn-icon btn-transparent-dark rounded-circle mr-20">
            <i class="fa-regular fa-envelope"></i>
        </button>

        <button class="btn btn-icon btn-transparent-dark rounded-circle mr-20">
            <i class="fa-regular fa-bell"></i>
        </button>

        <div class="dropdown">
            @include('components.topnav-menu', $user = auth()->user())
        </div>
    </div>
</nav>