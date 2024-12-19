<div class="dropdown">
    <button id="navbar-dropdown-user-image" class="btn btn-icon btn-transparent-dark rounded-circle" data-bs-toggle="dropdown" aria-expanded="false">
        <img width="44" height="44" src="{{ $user->image ?? random_avatar(1) }}">
    </button>
    
    <div class="dropdown-menu shadow animated-fade-in-up mt-20" aria-labelledby="navbar-dropdown-user-image">
        <header class="p-10 text-center">
            <div class="fw-bold">{{ $user->name }}</div>
            <div class="fs-12 text-smoke-gray">{{ $user->email }}</div>
        </header>

        <div class="dropdown-divider"></div>

        @php
            $items = config('menu.topnav.dropdown');

            if (! $user->isAdmin()) {
                unset($items[0], $items[1]);
            } elseif ($user->isAdmin() && isset($isBackend)) {
                unset($items[0]);
            } elseif ($user->isAdmin() && isset($isFrontend)) {
                unset($items[1]);
            }
        @endphp

        @foreach ($items as $item)
            <a class="dropdown-item" href="{{ route($item['route']['name']) }}">
                <i class="{{ $item['icon'] }}"></i>
                <span>{{ $item['title'] }}</span>
            </a>
        @endforeach
    </div>
</div>