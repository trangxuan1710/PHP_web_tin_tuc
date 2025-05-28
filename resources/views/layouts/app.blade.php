<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin Tức 24/7 @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 text-gray-800">

@include('layouts.header_loged')
@include('partials.header')

<main class="py-8">
    <div class="max-w-6xl mx-auto px-4">
        @yield('content')
    </div>
</main>

{{-- @include('partials.footer') --}}

{{-- <script src="{{ asset('js/app.js') }}"></script> --}}
</body>
</html>
