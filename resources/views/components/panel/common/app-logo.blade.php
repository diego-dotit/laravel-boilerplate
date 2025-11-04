@props([
    'title' => config('app.name', 'Laravel'),
    'href' => null,
    'class' => 'h-12'
])

@if($href)
    <a href="{{ $href }}" title="{{ $title }}">
        <img src="{{ asset('images/logo/dotit-normal.webp') }}" alt="{{ $title }}" class="{{ $class }}" />
    </a>
@else
    <img src="{{ asset('images/logo/dotit-normal.webp') }}" alt="{{ $title }}" class="{{ $class }}" />
@endif
