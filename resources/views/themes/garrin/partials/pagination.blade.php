@if ($paginator->hasPages())
    <div class="blog-pagination">
        <nav>
            <ul class="pagination justify-content-center">
                @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" tabindex="-1"><i class="fas fa-angle-double-right"></i></a>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" wire:click="previousPage" wire:loading.attr="disabled" tabindex="-1"><i class="fas fa-angle-double-right"></i></a>
                </li>
                @endif
    
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item">
                            <a class="page-link" >{{ $element }}</a>
                        </li>
                    @endif
    
                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <a class="page-link">{{ $page }} <span class="sr-only">(current)</span></a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" wire:key="paginator-page{{ $page }}" wire:click="gotoPage('{{$page}}')" wire:loading.attr="disabled">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" wire:click="nextPage" wire:loading.attr="disabled"><i class="fas fa-angle-double-left"></i></a>
                    </li>
                @else
                <li class="page-item disabled">
                    <a class="page-link" ><i class="fas fa-angle-double-left"></i></a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
@endif

