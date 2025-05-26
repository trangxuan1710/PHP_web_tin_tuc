<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Header Báo Tin Tức</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">

    @if(Auth::check())
        @include('layouts.header_loged')
    @else
        @include('layouts.header_notloged')
    @endif

    @include('layouts.navbar')

    <main>
    </main>
</body>
</html>
