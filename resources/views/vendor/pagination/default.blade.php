
@if ($paginator->hasPages())
<div class="content__pagination">
    <ul class="pagination content__pagination-list">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="content__pagination-item content__pagination-item_prev disabled"><span class="content__pagination-link">&laquo;</span></li>
        @else
            <li class="content__pagination-item content__pagination-item_prev"><a class="content__pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="content__pagination-item disabled"><span class="content__pagination-item">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="content__pagination-item"><span class="content__pagination-link">{{ $page }}</span></li>
                    @else
                        <li class="content__pagination-item"><a class="content__pagination-link" href="{{ $url }}">{{ $page }}</a></li>

                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="content__pagination-item content__pagination-item_prev"><a class="content__pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="content__pagination-item content__pagination-item_prev disabled"><span class="content__pagination-link">&raquo;</span></li>
        @endif
    </ul>
    </div>
@endif
