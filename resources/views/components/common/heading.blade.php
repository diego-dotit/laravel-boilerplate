@props([
    'title' => null,
    'breadcrumbs' => [],
])

<div class="flex items-center justify-between mb-6 flex-nowrap">
    @if($title)
        <h1 class="text-2xl font-semibold">
            {{ $title }}
        </h1>
    @endif
    @if($breadcrumbs)
        <div>
            <x-breadcrumb>
                <x-breadcrumb.list>
                    @foreach ($breadcrumbs as $item)
                        <x-breadcrumb.item>
                            <x-breadcrumb.link href="{{ $item['href'] }}">{{ $item['label'] }}</x-breadcrumb.link>
                        </x-breadcrumb.item>
                        @if (!$loop->last)
                            <x-breadcrumb.separator />
                        @endif
                    @endforeach
                </x-breadcrumb.list>
            </x-breadcrumb>
        </div>
    @endif
</div>
