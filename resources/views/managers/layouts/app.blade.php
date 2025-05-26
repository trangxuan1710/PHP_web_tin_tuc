<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5; /* Màu nền tổng thể */
        }
        /* Custom styles for sidebar transition */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        /* Overlay for mobile when sidebar is open */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40; /* Below sidebar, above content */
            display: none; /* Hidden by default */
        }
        .sidebar-overlay.active {
            display: block;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
<div id="sidebar-overlay" class="sidebar-overlay lg:hidden" onclick="toggleSidebar()"></div>

<aside id="sidebar" class="w-64 bg-white shadow-lg p-6 flex flex-col justify-between rounded-r-lg
                                transform -translate-x-full lg:translate-x-0
                                fixed lg:relative h-full z-50 sidebar-transition">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-8">Trang quản trị</h2>
        <div class="space-y-4">
            {{-- Quản lý bài viết --}}
            <a href="{{route("manageNews")}}"
               class="flex items-center p-3 rounded-lg font-medium transition-colors duration-200
               {{ request()->routeIs('manageNews') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-file-alt mr-3 text-lg"></i>
                Quản lý bài viết
            </a>

            {{-- Quản lý bình luận --}}
            <a href="{{route('manageCommentsIndex')}}"
               class="flex items-center p-3 rounded-lg font-medium transition-colors duration-200
               {{ request()->routeIs('manageCommentsIndex') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-comments mr-3 text-lg"></i>
                Quản lý bình luận
            </a>

            <a href=""
               class="flex items-center p-3 rounded-lg font-medium transition-colors duration-200
               {{ request()->routeIs('handleReports') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-exclamation-triangle mr-3 text-lg"></i>
                Xử lý báo cáo
            </a>

            {{-- Đổi mật khẩu (managerChangePassword) --}}
            <a href="{{route("managerChangePassword")}}"
               class="flex items-center p-3 rounded-lg font-medium transition-colors duration-200
               {{ request()->routeIs('managerChangePassword') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-key mr-3 text-lg"></i>
                Đổi mật khẩu
            </a>
        </div>
    </div>
    <div class="mt-8">
        <a href="{{route("managerLogout")}}" class="flex items-center p-3 rounded-lg text-red-600 hover:bg-red-100 transition-colors duration-200">
            <i class="fas fa-sign-out-alt mr-3 text-lg"></i>
            Đăng xuất
        </a>
    </div>
</aside>

<div id="main-content-area" class="flex-1 flex flex-col overflow-hidden transition-all duration-300">
    <header class="bg-white shadow-lg p-6 flex items-center justify-between">
        <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <h1 class="text-2xl font-bold text-gray-800 flex-grow text-center lg:text-left ml-0">Xin chào, Trang Xuân</h1>
    </header>

    <main class="flex-1 p-6 overflow-auto">
        @yield('content')
    </main>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    // Define the breakpoint for 'lg' in pixels (Tailwind's default lg is 1024px)
    const LG_BREAKPOINT = 1024;

    function toggleSidebar() {
        // Toggle sidebar visibility
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('translate-x-0');

        // Toggle overlay for screens smaller than lg
        if (window.innerWidth < LG_BREAKPOINT) {
            sidebarOverlay.classList.toggle('active');
        }
    }

    // Event listener for the toggle button
    sidebarToggle.addEventListener('click', toggleSidebar);

    // Handle sidebar state on window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= LG_BREAKPOINT) {
            // On large screens, ensure sidebar is visible and overlay is hidden
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            sidebarOverlay.classList.remove('active');
        } else {
            // On screens smaller than lg, ensure sidebar is hidden if it was open
            // and overlay is hidden unless explicitly opened by toggle button
            if (sidebar.classList.contains('translate-x-0') && !sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                sidebarOverlay.classList.remove('active'); // Hide overlay if sidebar is hidden
            }
        }
    });

    window.onload = () => {
        if (window.innerWidth < LG_BREAKPOINT) {
            // On small screens, sidebar should be hidden by default
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
        } else {
            // On large screens, sidebar should be visible by default
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
        }
    };
</script>
</body>
</html>
