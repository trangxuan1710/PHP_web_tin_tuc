<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang chủ (Chưa đăng nhập)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background-color: #f0f2f5; /* Màu nền nhẹ để dễ nhìn */
        }
        /* Đảm bảo các dropdown menu hoạt động đúng */
        .dropdown-menu {
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.2s ease-out, transform 0.2s ease-out;
        }
        .dropdown-menu.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Custom styles for news layout */
        .news-section {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .main-article {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        @media (min-width: 768px) {
            .main-article {
                flex-direction: row;
            }
        }
        .main-article img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
        }
        @media (min-width: 768px) {
            .main-article img {
                width: 60%;
            }
        }
        .main-article-content {
            width: 100%;
            padding: 10px;
        }
        @media (min-width: 768px) {
            .main-article-content {
                width: 40%;
            }
        }
        .small-news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        .news-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .news-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .news-card-content {
            padding: 15px;
            flex-grow: 1;
        }
        .news-card h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        .news-card p {
            font-size: 0.85rem;
            color: #666;
            line-height: 1.4;
        }
        .category-section {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .category-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .category-tabs button {
            padding: 8px 15px;
            border-radius: 5px 5px 0 0;
            background-color: #f8f8f8;
            border: 1px solid #e2e8f0;
            border-bottom: none;
            cursor: pointer;
            font-weight: 600;
            color: #555;
            transition: all 0.2s ease;
        }
        .category-tabs button.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
            border-bottom: 1px solid white;
        }
        .category-tabs button:hover:not(.active) {
            background-color: #e2e8f0;
        }
        .sidebar {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .sidebar-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #e2e8f0;
        }
        .sidebar-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .sidebar-item h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        .sidebar-item p {
            font-size: 0.8rem;
            color: #888;
        }
        .sidebar-item a {
            color: #007bff;
            text-decoration: none;
        }
        .sidebar-item a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-gray-100">

@include('layouts.header_notloged')
@include('layouts.navbar')

<main class="container mx-auto px-4 py-6 grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2">
        <section class="news-section">
            <div class="main-article">
                <img src="https://placehold.co/600x400/E0E0E0/333333?text=Tin+Chinh" alt="Featured News Image" class="rounded-lg">
                <div class="main-article-content">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Nga không chấp nhận 'ngừng bắn vô điều kiện' với Ukraine</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">Ngoại trưởng Nga Lavrov nói Moscow không thể chấp nhận một lệnh ngừng bắn vô điều kiện ở Ukraine vì điều đó sẽ giúp quân đội Ukraine tập hợp lại. Ông cũng nhấn mạnh rằng các cuộc đàm phán hòa bình phải tính đến "thực tế trên mặt đất".</p>
                    <a href="#" class="text-blue-600 hover:underline font-semibold">Đọc thêm &rarr;</a>
                </div>
            </div>
        </section>

        <section class="news-section">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Tin tức nổi bật khác</h2>
            <div class="small-news-grid">
                <div class="news-card">
                    <img src="https://placehold.co/300x180/D0D0D0/444444?text=Tin+Nho+1" alt="Small News 1">
                    <div class="news-card-content">
                        <h3>Thanh tra đầu tiên trong giới giải trí Hàn Quốc bị bắt</h3>
                        <p>Một vụ bê bối mới đang gây chấn động ngành giải trí Hàn Quốc khi một thanh tra cấp cao bị bắt giữ vì cáo buộc tham nhũng...</p>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://placehold.co/300x180/C0C0C0/555555?text=Tin+Nho+2" alt="Small News 2">
                    <div class="news-card-content">
                        <h3>Bộ Công Thương: Đảm phán Việt - Mỹ về hợp tác kinh tế</h3>
                        <p>Đoàn đàm phán cấp cao của Bộ Công Thương Việt Nam đã có buổi làm việc với các đối tác Mỹ để thúc đẩy hợp tác kinh tế song phương...</p>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://placehold.co/300x180/B0B0B0/666666?text=Tin+Nho+3" alt="Small News 3">
                    <div class="news-card-content">
                        <h3>Bóc phốt: Nói về vụ tiền vàng</h3>
                        <p>Một vụ việc liên quan đến "tiền vàng" đang gây xôn xao dư luận, với nhiều lời tố cáo và bằng chứng được đưa ra...</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="category-section">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Kinh doanh</h2>
            <div class="category-tabs">
                <button class="active">Kinh doanh</button>
                <button>Công nghệ</button>
                <button>Giải trí</button>
                <button>Thể thao</button>
            </div>
            <div class="small-news-grid">
                <div class="news-card">
                    <img src="https://placehold.co/300x180/A0A0A0/777777?text=Kinh+Doanh+1" alt="Business News 1">
                    <div class="news-card-content">
                        <h3>Doanh nghiệp Việt Nam tăng tốc chuyển đổi số</h3>
                        <p>Nhiều doanh nghiệp lớn tại Việt Nam đang đẩy mạnh ứng dụng công nghệ số vào hoạt động sản xuất và kinh doanh...</p>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://placehold.co/300x180/909090/888888?text=Kinh+Doanh+2" alt="Business News 2">
                    <div class="news-card-content">
                        <h3>Mỹ-Trung: Cuộc chiến chip chưa có hồi kết</h3>
                        <p>Cuộc cạnh tranh công nghệ giữa Mỹ và Trung Quốc, đặc biệt là trong lĩnh vực chip bán dẫn, vẫn đang diễn ra gay gắt...</p>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://placehold.co/300x180/808080/999999?text=Kinh+Doanh+3" alt="Business News 3">
                    <div class="news-card-content">
                        <h3>Chính sách thuế mới ảnh hưởng đến thị trường</h3>
                        <p>Những thay đổi trong chính sách thuế mới của chính phủ dự kiến sẽ có tác động đáng kể đến thị trường tài chính và bất động sản...</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <aside class="md:col-span-1">
        <section class="sidebar">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Bài viết đọc nhiều nhất</h2>
            <div class="sidebar-item">
                <h4><a href="#">Những nghiên cứu về AI mới nhất</a></h4>
                <p>Cập nhật về các đột phá trong trí tuệ nhân tạo và ứng dụng của chúng.</p>
            </div>
            <div class="sidebar-item">
                <h4><a href="#">Thị trường chứng khoán biến động mạnh</a></h4>
                <p>Phân tích về những yếu tố ảnh hưởng đến thị trường chứng khoán toàn cầu.</p>
            </div>
            <div class="sidebar-item">
                <h4><a href="#">Du lịch phục hồi sau đại dịch</a></h4>
                <p>Ngành du lịch đang có những dấu hiệu phục hồi tích cực trên toàn cầu.</p>
            </div>
            <div class="sidebar-item">
                <h4><a href="#">Công nghệ xanh và tương lai</a></h4>
                <p>Vai trò của công nghệ trong việc bảo vệ môi trường và phát triển bền vững.</p>
            </div>
        </section>

        <section class="sidebar mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Liên hệ</h2>
            <div class="sidebar-item">
                <h4>Giới thiệu</h4>
                <p>Về chúng tôi và tầm nhìn của trang tin tức.</p>
            </div>
            <div class="sidebar-item">
                <h4>Điều khoản sử dụng</h4>
                <p>Các quy định và điều khoản khi sử dụng dịch vụ của chúng tôi.</p>
            </div>
            <div class="sidebar-item">
                <h4>Chính sách bảo mật</h4>
                <p>Cách chúng tôi thu thập và sử dụng dữ liệu của bạn.</p>
            </div>
            <div class="sidebar-item">
                <h4>Quảng cáo</h4>
                <p>Thông tin về các cơ hội quảng cáo trên trang của chúng tôi.</p>
            </div>
        </section>
    </aside>
</main>

@include('layouts.footer')

<script>
    // JavaScript cho dropdown menu (giữ nguyên từ file home.blade.php của bạn)
    // Đảm bảo các ID này tồn tại trong header_notloged.blade.php
    const userProfile = document.getElementById('user-profile');
    const userDropdownMenu = document.getElementById('user-dropdown-menu');
    const notificationBell = document.getElementById('notification-bell');
    const notificationDropdownMenu = document.getElementById('notification-dropdown-menu');

    // Hàm bật/tắt dropdown menu người dùng
    if (userProfile) { // Kiểm tra sự tồn tại của phần tử
        userProfile.onclick = function() {
            const isExpanded = userDropdownMenu.classList.contains('active');
            // Đóng dropdown thông báo nếu đang mở
            if (notificationDropdownMenu) {
                notificationDropdownMenu.classList.remove('active');
            }

            if (isExpanded) {
                userDropdownMenu.classList.remove('active');
                userProfile.setAttribute('aria-expanded', 'false');
            } else {
                userDropdownMenu.classList.add('active');
                userProfile.setAttribute('aria-expanded', 'true');
            }
        };
    }

    // Hàm bật/tắt dropdown menu thông báo
    if (notificationBell) { // Kiểm tra sự tồn tại của phần tử
        notificationBell.onclick = function() {
            const isExpanded = notificationDropdownMenu.classList.contains('active');
            // Đóng dropdown người dùng nếu đang mở
            if (userDropdownMenu) {
                userDropdownMenu.classList.remove('active');
            }

            if (isExpanded) {
                notificationDropdownMenu.classList.remove('active');
                notificationBell.setAttribute('aria-expanded', 'false');
            } else {
                notificationDropdownMenu.classList.add('active');
                notificationBell.setAttribute('aria-expanded', 'true');
            }
        };
    }

    // Đóng cả hai dropdown khi nhấp chuột ra ngoài
    window.onclick = function(event) {
        // Kiểm tra xem click có phải vào avatar hoặc các phần tử con của nó không
        if (userProfile && !event.target.closest('#user-profile') && !event.target.closest('#notification-bell')) {
            if (userDropdownMenu) {
                userDropdownMenu.classList.remove('active');
                userProfile.setAttribute('aria-expanded', 'false');
            }
            if (notificationDropdownMenu) {
                notificationDropdownMenu.classList.remove('active');
                notificationBell.setAttribute('aria-expanded', 'false');
            }
        }
    }

    // JavaScript cho tab danh mục (ví dụ)
    document.addEventListener('DOMContentLoaded', function() {
        const categoryButtons = document.querySelectorAll('.category-tabs button');
        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                // Ở đây bạn có thể thêm logic để tải nội dung tin tức theo danh mục
                // Ví dụ: fetch('/api/news?category=' + this.textContent)
            });
        });
    });
</script>

</body>
</html>
