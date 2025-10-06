@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex items-center justify-between w-full gap-2 flex-wrap">
            <div>
                <p class="text-sm text-base-content/70">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-semibold">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-semibold">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-semibold">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <div class="join">
                    @if ($paginator->onFirstPage())
                        <span class="join-item btn btn-disabled">
                            <span class="icon icon-sm icon-chevron-down rotate-90"></span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="join-item btn">
                            <span class="icon icon-sm icon-chevron-down rotate-90"></span>
                        </a>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="join-item btn btn-disabled">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="join-item btn btn-active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="join-item btn">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn">
                            <span class="icon icon-sm icon-chevron-down -rotate-90"></span>
                        </a>
                    @else
                        <span class="join-item btn btn-disabled">
                            <span class="icon icon-sm icon-chevron-down -rotate-90"></span>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </nav>
@endif