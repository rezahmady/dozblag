@if ($paginator->hasPages())
    <div class="pagination-area text-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())

        @else
        <a href="{{ $paginator->previousPageUrl() }}" class="next page-numbers"><i class='bx bx-chevron-right'></i></a>

        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-numbers current" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-numbers">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="next page-numbers"><i class='bx bx-chevron-left'></i></a>
        @else
            
        @endif
    </div>
@endif