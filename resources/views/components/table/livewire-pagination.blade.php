@props([
    'paginator' => null,
    'class' => 'pt-4',
    'showText' => true,
    'showNumbers' => true,
    'maxLinks' => 7,
])

<div>
    @if($paginator && $paginator->hasPages())
        <div class="{{ $class }}">
            <div class="flex items-center justify-between">
                {{-- Results info --}}
                @if($showText)
                    <div class="flex items-center text-sm text-gray-700">
                        <span>
                            {{ __('pagination.showing') }}
                            <span class="font-medium">{{ $paginator->firstItem() }}</span>
                            {{ __('pagination.to') }}
                            <span class="font-medium">{{ $paginator->lastItem() }}</span>
                            {{ __('pagination.of') }}
                            <span class="font-medium">{{ $paginator->total() }}</span>
                            {{ __('pagination.results') }}
                        </span>
                    </div>
                @endif

                {{-- Pagination Links --}}
                @if($showNumbers)
                    <div class="flex items-center space-x-1">
                        {{-- Previous Page Link --}}
                        @if ($paginator->onFirstPage())
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 cursor-default rounded-l-md">
                                <x-heroicon-o-chevron-left class="w-5 h-5" />
                            </span>
                        @else
                            <button wire:click="previousPage"
                                    class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                <x-heroicon-o-chevron-left class="w-5 h-5" />
                            </button>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $start = max($paginator->currentPage() - floor($maxLinks / 2), 1);
                            $end = min($start + $maxLinks - 1, $paginator->lastPage());
                            $start = max($end - $maxLinks + 1, 1);
                        @endphp

                        {{-- First Page --}}
                        @if($start > 1)
                            <button wire:click="gotoPage(1)"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                1
                            </button>
                            @if($start > 2)
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">
                                    ...
                                </span>
                            @endif
                        @endif

                        {{-- Page Numbers --}}
                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $paginator->currentPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white border cursor-default bg-primary border-primary">
                                    {{ $page }}
                                </span>
                            @else
                                <button wire:click="gotoPage({{ $page }})"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                    {{ $page }}
                                </button>
                            @endif
                        @endfor

                        {{-- Last Page --}}
                        @if($end < $paginator->lastPage())
                            @if($end < $paginator->lastPage() - 1)
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300">
                                    ...
                                </span>
                            @endif
                            <button wire:click="gotoPage({{ $paginator->lastPage() }})"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                {{ $paginator->lastPage() }}
                            </button>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <button wire:click="nextPage"
                                    class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                <x-heroicon-o-chevron-right class="w-5 h-5" />
                            </button>
                        @else
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-300 cursor-default rounded-r-md">
                                <x-heroicon-o-chevron-right class="w-5 h-5" />
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
