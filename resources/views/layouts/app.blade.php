<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin Tức 24/7 @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
    <!-- Fonts (nếu muốn giữ) -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gray-100 text-gray-800">

    @if(Auth::check())
    @include('layouts.header_loged')
    @else
    @include('layouts.header_notloged')
    @endif

    <main class="py-8">
        <div class="max-w-6xl mx-auto px-4">
            @yield('content')
        </div>
    </main>

    {{-- @include('layouts.footer') --}}

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
</body>

</html>