@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center mt-4 space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                «
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="px-3 py-1 text-sm text-gray-700 bg-white border rounded-lg hover:bg-gray-200">
                «
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-1 text-sm text-gray-400">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 text-sm text-white bg-indigo-600 border border-indigo-600 rounded-lg">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-1 text-sm text-gray-700 bg-white border rounded-lg hover:bg-gray-200">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="px-3 py-1 text-sm text-gray-700 bg-white border rounded-lg hover:bg-gray-200">
                »
            </a>
        @else
            <span class="px-3 py-1 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                »
            </span>
        @endif
    </nav>
@endif
