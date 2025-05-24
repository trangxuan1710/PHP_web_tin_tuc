<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Trang web của bạn')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 font-sans leading-relaxed">

<!-- 🔽 Header (tuỳ login) -->
@auth
    @include('layouts.header_loged')
@else
    @include('layouts.header_notloged')
@endauth

<!-- 🔽 Navbar (nếu có) -->
@include('layouts.navbar')

<!-- 🔽 Nội dung chính -->
<main class="container mx-auto p-4">
    @yield('content')
</main>

<!-- 🔽 Footer -->
@include('layouts.footer')

@stack('scripts')
</body>
</html>
