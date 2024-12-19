@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            @php
                $lastPage = $paginator->lastPage();
                $currentPage = $paginator->currentPage();
            @endphp

            @if ($currentPage > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">{{ $paginator->previousPage() }}</a>
                </li>
            @endif

            <li class="page-item active">
                <a class="page-link" href="">{{ $currentPage }}</a>
            </li>

            @if ($currentPage < $lastPage)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">{{ $paginator->nextPage() }}</a>
                </li>
            @endif
            
            @if ($currentPage < $lastPage - 2)
                <li class="page-item">
                    <a class="page-link">...</a>
                </li>
            @endif

            @if ($currentPage < $lastPage - 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->path().$lastPage }}">{{ $lastPage }}</a>
                </li>
            @endif

            @if ($currentPage < $lastPage)
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif