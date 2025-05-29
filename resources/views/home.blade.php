<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin tức 24/7 - Trang chủ</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<header class="main-header">
    <div class="container">
        <div class="header-top">
            <div class="logo">
                <a href="/">Tin tức 24/7</a>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Tìm kiếm...">
                <button><i class="fa fa-search"></i></button>
            </div>
            <div class="user-info">
                @if(Auth::check())
                    <span>Chào, {{ Auth::user()->fullName }}</span>
                    <a href="/logout">Đăng xuất</a>
                @else
                    <a href="/login">Đăng nhập</a> / <a href="/register">Đăng ký</a>
                @endif
            </div>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="/tin-nong">Tin nóng</a></li>
                <li><a href="/thoi-su">Thời sự</a></li>
                <li><a href="/khoa-hoc-cong-nghe">Khoa học - Công nghệ</a></li>
                <li><a href="/giai-tri">Giải trí</a></li>
                <li><a href="/kinh-doanh">Kinh doanh</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container main-content">
    <section class="featured-news">
        @if(isset($hotNews) && $hotNews->count() > 0)
            <div class="news-large-item">
                <img src="{{ $hotNews->first()->thumbNailUrl }}" alt="{{ $hotNews->first()->title }}">
                <div class="news-info">
                    <h2><a href="/news/{{ $hotNews->first()->id }}">{{ $hotNews->first()->title }}</a></h2>
                    <p>{{ Str::limit($hotNews->first()->content, 200) }}</p>
                    {{-- Thêm thông tin khác như tác giả, ngày đăng nếu cần --}}
                </div>
            </div>
        @endif
    </section>

    <div class="news-grid">
        <section class="latest-news-section">
            <h3>Tin mới nhất</h3>
            <div class="news-list-items">
                @if(isset($latestNews))
                    @foreach($latestNews as $news)
                        <div class="news-item">
                            @if($news->thumbNailUrl)
                                <img src="{{ $news->thumbNailUrl }}" alt="{{ $news->title }}">
                            @endif
                            <div class="news-details">
                                <h4><a href="/news/{{ $news->id }}">{{ $news->title }}</a></h4>
                                <p class="news-meta">
                                    <span>{{ optional($news->manager)->fullName }}</span> |
                                    <span>{{ $news->date->diffForHumans() }}</span> |
                                    <span>{{ $news->views ?? 0 }} lượt xem</span>
                                </p>
                                {{-- <p>{{ Str::limit($news->content, 100) }}</p> --}}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>

        <aside class="sidebar">
            <section class="opinion-section">
                <h3>Góc nhìn</h3>
                <div class="opinion-list">
                    @if(isset($opinionNews))
                        @foreach($opinionNews as $news)
                            <div class="opinion-item">
                                <h4><a href="/news/{{ $news->id }}">{{ $news->title }}</a></h4>
                                {{-- Có thể thêm ảnh đại diện của tác giả nếu có --}}
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>

            <section class="category-section">
                <h3>Kinh doanh</h3>
                <div class="news-list-items">
                    @if(isset($businessNews))
                        @foreach($businessNews as $news)
                            <div class="news-item small">
                                @if($news->thumbNailUrl)
                                    <img src="{{ $news->thumbNailUrl }}" alt="{{ $news->title }}">
                                @endif
                                <div class="news-details">
                                    <h4><a href="/news/{{ $news->id }}">{{ $news->title }}</a></h4>
                                    {{-- <p class="news-meta">{{ $news->date->diffForHumans() }}</p> --}}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>
        </aside>
    </div>
</main>

<footer class="main-footer">
    <div class="container">
        <div class="footer-columns">
            <div class="footer-col">
                <h4>LIÊN HỆ</h4>
                <ul>
                    <li><a href="/gioi-thieu">Giới thiệu</a></li>
                    <li><a href="/dieu-khoan-su-dung">Điều khoản sử dụng</a></li>
                    <li><a href="/chinh-sach-bao-mat">Chính sách bảo mật</a></li>
                    <li><a href="/quang-cao">Quảng cáo</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>KHÁC</h4>
                <ul>
                    <li><a href="/tong-hop">Tổng hợp</a></li>
                </ul>
            </div>
            <div class="footer-col contact-info">
                <p>Giấy phép thiết lập trang thông tin điện tử tổng hợp số 188/GP-TTĐT do Sở Thông tin và Truyền thông Hà Nội cấp ngày 05/05/2025.</p>
                <p>Đơn vị thiết lập: Công ty cổ phần công nghệ ERF - Chịu trách nhiệm quản lý nội dung: Bà Trang Xuân</p>
                <p>Địa chỉ: Tầng 16, tòa nhà KDT Tower, số 344 Nguyễn Trãi, Thanh Xuân, Hà Nội.</p>
                <p>Điện thoại: (024) 3.542.xxxx | Email: contact@example.com</p>
                <p>BAOMOI tổng hợp và sắp xếp các thông tin từ đóng góp của cộng đồng dựa trên chương trình máy tính.</p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>