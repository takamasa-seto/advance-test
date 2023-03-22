<link rel="stylesheet" href="{{ asset('css/pagenation.css') }}">

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="nav">

            <div>
                <p class="">
                    {!! __('全') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('件中') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('~') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('件') !!}
                    
                </p>
            </div>

            <div>
                <span class="page-link-outer">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="other-page" aria-hidden="true">
                                <
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="other-page" aria-label="{{ __('pagination.previous') }}">
                            <
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <!-- span aria-current="page" class="current-page-outer" -->
                                        <span class="current-page">{{ $page }}</span>
                                    <!-- /span -->
                                @else
                                    <a href="{{ $url }}" class="other-page">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="other-page" aria-label="{{ __('pagination.next') }}">
                            >
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="other-page" aria-hidden="true">
                            <span>
                                >
                            </span>
                        </span>
                    @endif
                </span>
            </div>
    </nav>
@endif
