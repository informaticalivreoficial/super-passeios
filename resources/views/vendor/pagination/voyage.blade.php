@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegação de páginas" class="voyage-pagination flex items-center justify-center gap-2">

        {{-- Anterior --}}
        @if ($paginator->onFirstPage())
            <span class="voyage-page-btn voyage-page-nav is-disabled" aria-hidden="true">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 4l-6 6 6 6"/>
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="voyage-page-btn voyage-page-nav" aria-label="Página anterior">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 4l-6 6 6 6"/>
                </svg>
            </a>
        @endif

        {{-- Números --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="voyage-page-btn is-dots">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="voyage-page-btn is-current">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="voyage-page-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Próxima --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="voyage-page-btn voyage-page-nav" aria-label="Próxima página">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 4l6 6-6 6"/>
                </svg>
            </a>
        @else
            <span class="voyage-page-btn voyage-page-nav is-disabled" aria-hidden="true">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 4l6 6-6 6"/>
                </svg>
            </span>
        @endif

    </nav>
@endif