<nav id="sidenav" class="sidenav bg-white shadow-right fixed-top">
    <div class="sidenav-menu nav">
        @foreach (config('menu.sidenav.backend') as $item)
            <a class="nav-link {{ $item['class'] }}" href="{{ route($item['route']['name'], $item['route']['parameters']) }}">
                <div class="btn-icon"><i class="{{ $item['icon'] }}"></i></div>
                <span class="ml-10">{{ $item['title'] }}</span>
            </a>
        @endforeach
    </div>
</nav>