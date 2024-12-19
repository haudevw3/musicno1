<nav id="sidenav" class="sidenav bg-dark-lead fixed-top">
    <div class="sidenav-menu nav">
        @foreach (config('menu.sidenav.frontend') as $item)
            <a class="nav-link {{ $item['class'] }} " href="{{ $item['url'] }}">
                <div class="btn-icon"><i class="{{ $item['icon'] }}"></i></div>
                <span class="ml-5">{{ $item['title'] }}</span>
            </a>
        @endforeach
    </div>
</nav>