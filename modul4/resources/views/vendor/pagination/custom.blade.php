@if ($paginator->hasPages())
    <nav aria-label="Navigasi halaman">
        <ul style="list-style:none; display:flex; gap:0.375rem; margin:0; padding:0; flex-wrap:wrap">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li><span class="pagination disabled" aria-hidden="true">&laquo; Sebelumnya</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" class="pagination" rel="prev">&laquo; Sebelumnya</a></li>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" separator --}}
                @if (is_string($element))
                    <li><span class="pagination disabled">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="pagination current" aria-current="page">{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}" class="pagination">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" class="pagination" rel="next">Berikutnya &raquo;</a></li>
            @else
                <li><span class="pagination disabled" aria-hidden="true">Berikutnya &raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
