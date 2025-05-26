<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Header Báo Tin Tức</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Đặt font Inter cho toàn bộ trang */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background-color: #f0f2f5; /* Màu nền nhẹ để dễ nhìn header */
        }
        /* CSS cho dropdown menu (mặc định ẩn) */
        .dropdown-menu {
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.2s ease-out, transform 0.2s ease-out;
        }
        /* Hiển thị dropdown khi có class 'active' */
        .dropdown-menu.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- @include('layouts.header_notloged') -->
    @include('layouts.header_loged')

    @include('layouts.navbar')

    <main>
    </main>

    <script>
        // Mô phỏng trạng thái đăng nhập
        // Thay đổi giá trị này thành 'true' để xem giao diện khi đã đăng nhập
        let isLoggedIn = true; // Đã thay đổi thành TRUE để hiển thị giao diện đã đăng nhập

        const authButtons = document.getElementById('auth-buttons');
        const userProfile = document.getElementById('user-profile');
        const userDropdownMenu = document.getElementById('user-dropdown-menu');
        const notificationBell = document.getElementById('notification-bell');
        const notificationDropdownMenu = document.getElementById('notification-dropdown-menu');

        // Hàm cập nhật header dựa trên trạng thái đăng nhập
        function updateHeader() {
            if (isLoggedIn) {
                authButtons.classList.add('hidden');
                userProfile.classList.remove('hidden');
                userProfile.setAttribute('aria-expanded', 'false'); // Đảm bảo trạng thái ban đầu là đóng
            } else {
                authButtons.classList.remove('hidden');
                userProfile.classList.add('hidden');
            }
        }

        // Hàm bật/tắt dropdown menu người dùng
        userProfile.onclick = function() {
            const isExpanded = userDropdownMenu.classList.contains('active');
            // Đóng dropdown thông báo nếu đang mở
            notificationDropdownMenu.classList.remove('active');

            if (isExpanded) {
                userDropdownMenu.classList.remove('active');
                userProfile.setAttribute('aria-expanded', 'false');
            } else {
                userDropdownMenu.classList.add('active');
                userProfile.setAttribute('aria-expanded', 'true');
            }
        };

        // Hàm bật/tắt dropdown menu thông báo
        notificationBell.onclick = function() {
            const isExpanded = notificationDropdownMenu.classList.contains('active');
            // Đóng dropdown người dùng nếu đang mở
            userDropdownMenu.classList.remove('active');

            if (isExpanded) {
                notificationDropdownMenu.classList.remove('active');
                notificationBell.setAttribute('aria-expanded', 'false');
            } else {
                notificationDropdownMenu.classList.add('active');
                notificationBell.setAttribute('aria-expanded', 'true');
            }
        };

        // Đóng cả hai dropdown khi nhấp chuột ra ngoài
        window.onclick = function(event) {
            // Kiểm tra xem click có phải vào avatar hoặc các phần tử con của nó không
            if (!event.target.closest('#user-profile') && !event.target.closest('#notification-bell')) {
                userDropdownMenu.classList.remove('active');
                userProfile.setAttribute('aria-expanded', 'false');
                notificationDropdownMenu.classList.remove('active');
                notificationBell.setAttribute('aria-expanded', 'false');
            }
        }
        // Cập nhật header khi trang được tải
        window.onload = updateHeader;
    </script>

</body>
</html>
