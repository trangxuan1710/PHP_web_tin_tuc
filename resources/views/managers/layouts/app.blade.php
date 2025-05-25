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
<div id="sidebar-overlay" class="sidebar-overlay md:hidden" onclick="toggleSidebar()"></div>

<aside id="sidebar" class="w-64 bg-white shadow-lg p-6 flex flex-col justify-between rounded-r-lg
                                transform -translate-x-full md:translate-x-0
                                fixed md:relative h-full z-50 sidebar-transition">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 mb-8">Trang quản trị</h2>
        <div class="space-y-4">
            <a href="#" class="flex items-center p-3 rounded-lg bg-blue-100 text-blue-700 font-medium hover:bg-blue-200 transition-colors duration-200">
                <i class="fas fa-file-alt mr-3 text-lg"></i>
                Quản lý bài viết
            </a>
            <a href="#" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                <i class="fas fa-comments mr-3 text-lg"></i>
                Quản lý bình luận
            </a>
            <a href="#" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                <i class="fas fa-exclamation-triangle mr-3 text-lg"></i>
                Xử lý báo cáo
            </a>
            <a href="#" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                <i class="fas fa-users mr-3 text-lg"></i>
                Quản lý người dùng
            </a>
        </div>
    </div>
    <div class="mt-8">
        <a href="#" class="flex items-center p-3 rounded-lg text-red-600 hover:bg-red-100 transition-colors duration-200">
            <i class="fas fa-sign-out-alt mr-3 text-lg"></i>
            Đăng xuất
        </a>
    </div>
</aside>

<div id="main-content-area" class="flex-1 flex flex-col overflow-hidden transition-all duration-300">
    <header class="bg-white shadow-lg p-6 flex items-center justify-between">
        <button id="sidebar-toggle" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <h1 class="text-2xl font-bold text-gray-800 flex-grow text-center md:text-left ml-0">Xin chào, Trang Xuân</h1>
    </header>

    <main class="flex-1 p-6 overflow-auto">
        @yield('content')
    </main>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mainContentArea = document.getElementById('main-content-area');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        // Toggle sidebar visibility
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('translate-x-0');

        // Toggle main content margin on desktop (md breakpoint and above)
        // This ensures content shifts when sidebar is manually toggled on larger screens
        // mainContentArea.classList.toggle('md:ml-0');
        // mainContentArea.classList.toggle('md:ml-64');

        // Toggle overlay for mobile
        sidebarOverlay.classList.toggle('active');
    }

    // Event listener for the toggle button
    sidebarToggle.addEventListener('click', toggleSidebar);

    // Close sidebar if window is resized to desktop size while sidebar is open on mobile
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 780) { // Tailwind's 'md' breakpoint
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            // mainContentArea.classList.remove('md:ml-0');
            // mainContentArea.classList.add('md:ml-64');
            sidebarOverlay.classList.remove('active');
        } else {
            // Ensure sidebar is hidden by default on mobile if resized from desktop
            if (sidebar.classList.contains('translate-x-0') && !sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                sidebarOverlay.classList.remove('active'); // Hide overlay if sidebar is hidden
            }
        }
    });

    // Initial check on load to ensure correct state based on screen size
    window.onload = () => {
        if (window.innerWidth < 800) {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');

        } else {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
        }
    };
</script>
</body>
</html>
