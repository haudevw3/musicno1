<nav id="topnav" class="topnav bg-dark-lead d-flex fixed-top">
    <div id="brand" class="left items-align-vertical-center text-white fs-16 fw-bold">
        <div class="btn-icon items-align-center">
            <i class="fa-regular fa-compact-disc"></i>
        </div>
        <span class="ml-5">MusicNo1</span>
    </div>

    <div class="center items-align-vertical-center">
        <button id="previous-page" class="previous-page btn btn-icon-sm bg-dark-gray">
            <i class="fa-regular fa-chevron-left fs-18"></i>
        </button>

        <button id="next-page" class="next-page btn btn-icon-sm bg-dark-gray ml-20">
            <i class="fa-regular fa-chevron-right fs-18"></i>
        </button>

        <div id="docsearch" class="docsearch input-group input-group-joined input-group-solid rounded-pill">
            <span class="input-group-text">
                <i class="fa-regular fa-magnifying-glass"></i>
            </span>
            <input class="form-control ps-0" type="text" placeholder="Tìm kiếm nghệ sĩ, bài hát..." aria-label="Search">
        </div>
    </div>

    <div class="right items-align-vertical-center-end">
        @if ($user = auth()->user())
            @include('components.topnav-menu', $user)
        @else
            <a class="btn bg-dark-gray rounded-pill mr-20" href="">Đăng ký</a>
            <a class="btn bg-white rounded-pill text-black mr-20" href="">Đăng nhập</a>
        @endif
    </div>
</nav>