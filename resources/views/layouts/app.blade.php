<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts (nếu muốn giữ) -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- CSS (Tailwind) -->
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')

    <!-- JS (AlpineJS) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Nếu bạn vẫn cần dùng Vite -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
</head>
<body class="bg-gray-50 font-sans leading-relaxed">

<!-- 🔽 Header -->
@auth
    @include('layouts.header_loged')
@else
    @include('layouts.header_notloged')
@endauth

<!-- 🔽 Navbar -->
@include('layouts.navbar')

<!-- 🔽 Nội dung -->
<main class="container mx-auto p-4">
    @yield('content')
</main>

<!-- 🔽 Footer -->
@include('layouts.footer')

@stack('scripts')
</body>
</html>
