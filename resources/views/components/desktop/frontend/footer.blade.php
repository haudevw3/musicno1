<footer id="footer" class="footer fixed-bottom">
    <div class="divider-dark-gray"></div>
    @if (auth()->user())
        @include('components.desktop.frontend.music-controls')
    @else
        @include('components.desktop.frontend.ads')
    @endif
</footer>