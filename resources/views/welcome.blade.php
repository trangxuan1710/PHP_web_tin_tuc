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
            background-color: #f0f2f5;
            /* Màu nền nhẹ để dễ nhìn */
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


    @if(Auth::check())
    @include('layouts.header_loged')
    @else
    @include('layouts.header_notloged')
    @endif
    @include('layouts.navbar')

    <main class="container mx-auto px-4 py-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <section class="news-section">
                @if(isset($featuredNews) && $featuredNews) {{-- Added isset check --}}
                <div class="main-article">
                    <img src="https://hhtqtv.vip/assets/upload/store/icon-user/zCwHOmKwdPOIxii1709557530.webp" alt="{{ $featuredNews->title }}" class="rounded-lg">
                    {{-- //{{ asset('storage/' . $featuredNews->thumbnailUrl) }} đoạn này là lấy ảnh từ database--}}
                    <div class="main-article-content">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">{{ $featuredNews->title }}</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">{{ Str::limit($featuredNews->content, 300) }}</p>
                        <a href="{{ route('news.show', $featuredNews->id) }}" class="text-blue-600 hover:underline font-semibold">Đọc thêm &rarr;</a>
                    </div>
                </div>
                @else
                <p class="text-center text-gray-500">Không có tin tức nổi bật nào để hiển thị.</p>
                @endif
            </section>

            <section class="news-section">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Tin tức nổi bật khác</h2>
                <div class="small-news-grid">
                    @forelse($recentNews as $article)
                    <div class="news-card">
                        @if($article->thumbnailUrl)
                        <img src="{{ asset('storage/' . $article->thumbnailUrl) }}" alt="{{ $article->title }}">
                        @else
                        <img src="https://placehold.co/300x180?text=No+Image" alt="No Image">
                        @endif
                        <div class="news-card-content">
                            <a href="{{ route('news.show', $article->id) }}" class="block"> {{-- Added dynamic link --}}
                                <h3>{{ $article->title }}</h3>
                            </a>
                            <p>{{ Str::limit($article->content, 100) }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 col-span-full">Không có tin tức gần đây nào để hiển thị.</p>
                    @endforelse
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
                    @forelse($businessNews as $article)
                    <div class="news-card">
                        @if($article->thumbnailUrl)
                        <img src="{{ asset('storage/' . $article->thumbnailUrl) }}" alt="{{ $article->title }}">
                        @else
                        <img src="https://placehold.co/300x180?text=No+Image" alt="No Image">
                        @endif
                        <div class="news-card-content">
                            <a href="{{ route('news.show', $article->id) }}" class="block"> {{-- Added dynamic link --}}
                                <h3>{{ $article->title }}</h3>
                            </a>
                            <p>{{ Str::limit($article->content, 100) }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 col-span-full">Không có tin tức kinh doanh nào để hiển thị.</p>
                    @endforelse
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