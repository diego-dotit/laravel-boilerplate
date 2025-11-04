@props(['title' => 'unknown'])

<meta charset="UTF-8"/>
<meta
    name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
/>

<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
<title>{{ __($title) }}</title>

@vite('resources/js/app.js')

<link rel="stylesheet" href="{{ asset('font/font.css') }}" />

@vite('resources/css/app.css')
@livewireStyles
