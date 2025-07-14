@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-8">
        <ul class="inline-flex items-center space-x-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="px-3 py-2 text-gray-400 border border-gray-300 bg-white rounded-md">&laquo;</li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-3 py-2 text-[#104334] border border-[#104334] bg-white rounded-md hover:bg-[#e6f2ee] transition">
                        &laquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="px-3 py-2 text-gray-400">{{ $element }}</li>
                @endif

                {{-- Page Numbers --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="px-3 py-2 bg-[#104334] text-white border border-[#104334] rounded-md">
                                {{ $page }}
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="px-3 py-2 text-[#104334] border border-[#104334] bg-white rounded-md hover:bg-[#e6f2ee] transition">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="px-3 py-2 text-[#104334] border border-[#104334] bg-white rounded-md hover:bg-[#e6f2ee] transition">
                        &raquo;
                    </a>
                </li>
            @else
                <li class="px-3 py-2 text-gray-400 border border-gray-300 bg-white rounded-md">&raquo;</li>
            @endif
        </ul>
    </nav>
@endif
