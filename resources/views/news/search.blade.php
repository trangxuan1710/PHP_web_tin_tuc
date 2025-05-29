<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm Tin Tức</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }
        .search-result-item:hover {
            background-color: #f9fafb;
        }

        .pagination { display: flex; justify-content: center; list-style: none; padding: 0; }
        .pagination li { margin: 0 0.25rem; }
        .pagination li a, .pagination li span {
            display: block; padding: 0.5rem 0.75rem; border: 1px solid #e2e8f0;
            color: #4a5568; text-decoration: none; border-radius: 0.375rem;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        }
        .pagination li a:hover { background-color: #edf2f7; }
        .pagination li.active span { background-color: #3b82f6; color: white; border-color: #3b82f6; }
        .pagination li.disabled span { color: #a0aec0; background-color: #f7fafc; cursor: not-allowed; }

        /* CSS cho slider quảng cáo */
        .ad-slider .swiper-slide {
            width: 100%;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ad-slider .ad-slide-link,
        .ad-slider .ad-slide-image {
            display: block;
            width: 100%;
            height: 100%;
        }

        .ad-slider .ad-slide-image {
            object-fit: cover;
            border-radius: 0.375rem;
        }
        /* Tùy chỉnh nhỏ cho nút prev/next của Swiper */
        .advisory-slider .swiper-button-prev,
        .advisory-slider .swiper-button-next {
            top: 50%;
            transform: translateY(-50%);
        }
        .advisory-slider .swiper-button-prev { left: 4px; }
        .advisory-slider .swiper-button-next { right: 4px; }
    </style>
</head>
<body class="bg-gray-100">

@if(Auth::check())
    @include('layouts.header_loged')
@else
    @include('layouts.header_notloged')
@endif

@include('layouts.navbar')

<main class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <div class="w-full lg:w-2/3">
            <div class="flex items-center mb-5">
                <h1 class="text-3xl font-semibold text-gray-800 mr-2">Tìm kiếm</h1>
            </div>
            <form id="filterForm" action="{{ url('/search') }}" method="GET">
                <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                    <div class="mb-6">
                        <label for="keyword_search_page" class="block text-sm font-medium text-gray-700 mb-1">
                            Từ khóa tìm kiếm theo tiêu đề
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                name="q"
                                id="keyword_search_page"
                                value="{{ request('q', '') }}"
                                placeholder="Nhập từ khóa..."
                                class="w-full py-2.5 px-4 pr-10 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <button type="submit" class="absolute top-0 right-0 h-full px-3 text-gray-500 hover:text-blue-600" aria-label="Tìm kiếm theo từ khóa">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="time_filter" class="block text-sm font-medium text-gray-700 mb-1">Thời gian</label>
                            <select id="time_filter" name="time_filter" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="all" {{ (request('time_filter') == 'all' || !request()->filled('time_filter')) ? 'selected' : '' }}>Tất cả</option>
                                <option value="today" {{ request('time_filter') == 'today' ? 'selected' : '' }}>Hôm nay</option>
                                <option value="this_week" {{ request('time_filter') == 'this_week' ? 'selected' : '' }}>Tuần này</option>
                                <option value="this_month" {{ request('time_filter') == 'this_month' ? 'selected' : '' }}>Tháng này</option>
                            </select>
                        </div>
                        <div>
                            <label for="category_filter" class="block text-sm font-medium text-gray-700 mb-1">Chuyên mục</label>
                            <select id="category_filter" name="category_filter" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="all" {{ (request('category_filter') == 'all' || !request()->filled('category_filter')) ? 'selected' : '' }}>Tất cả</option>
                                @if(isset($labels) && $labels->count() > 0)
                                    @foreach ($labels as $label)
                                        <option value="{{ $label->type }}" {{ request('category_filter') == $label->type ? 'selected' : '' }}>
                                            {{ $label->type}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="mt-6 text-right">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition-colors duration-300">
                            Áp dụng bộ lọc
                        </button>
                    </div>
                </div>
            </form>

            @if(request()->filled('q') || (request()->filled('category_filter') && request('category_filter') != 'all') || (request()->filled('time_filter') && request('time_filter') != 'all'))
                <h2 class="text-xl font-semibold text-gray-700 mb-2">
                    Kết quả cho
                    @if(request()->filled('q'))
                        <span class="font-normal italic">từ khóa "{{ request('q') }}"</span>
                    @endif
                    {{-- Có thể thêm hiển thị tên category, time filter đang chọn tại đây --}}
                </h2>
            @elseif(request()->hasAny(['q', 'category_filter', 'time_filter']) && (!request()->filled('q') && (!request()->filled('category_filter') || request('category_filter') == 'all') && (!request()->filled('time_filter') || request('time_filter') == 'all')))
                {{-- Chỉ hiển thị "Tất cả kết quả" nếu không có filter nào thực sự được áp dụng --}}
                <h2 class="text-xl font-semibold text-gray-700 mb-2">
                    Hiển thị tất cả kết quả
                </h2>
            @endif
            <div class="space-y-6">
                @forelse ($results as $newsItem)
                    <article class="bg-white p-4 rounded-lg shadow-md flex flex-col sm:flex-row gap-4 search-result-item transition-all duration-200">
                        @if($newsItem->thumbNailUrl)
                            <div class="w-full sm:w-1/4 lg:w-1/5 flex-shrink-0">
                                <a href="{{ url('/news/' . $newsItem->id) }}">
                                    <img src="{{ asset($newsItem->thumbNailUrl) }}" alt="Ảnh minh họa cho {{ $newsItem->title }}" class="w-full h-auto object-cover rounded-md aspect-video sm:aspect-[4/3]" onerror="this.onerror=null;this.src='https://placehold.co/150x100/e2e8f0/cbd5e0?text=Ảnh+lỗi';">
                                </a>
                            </div>
                        @endif
                        <div class="flex-grow">
                            <h2 class="text-lg font-semibold text-gray-800 hover:text-blue-600 mb-1">
                                <a href="{{ url('/news/' . $newsItem->id) }}">{{-- TODO: Cập nhật route --}} {{ $newsItem->title }}</a>
                            </h2>
                            <p class="text-sm text-gray-600 mb-2 leading-relaxed">
                                {{ Str::limit(strip_tags($newsItem->content), 150) }}
                            </p>
                            <div class="text-xs text-gray-500 flex flex-wrap items-center gap-x-3 gap-y-1">
                                @if($newsItem->label)
                                    <span class="flex items-center"><i class="fas fa-tag opacity-75 mr-1"></i>{{ $newsItem->label->name }}</span>
                                @endif
                                @if($newsItem->date)
                                    <span class="flex items-center" title="{{ $newsItem->date->format('d/m/Y H:i:s') }}"><i class="fas fa-calendar-alt opacity-75 mr-1"></i>{{ $newsItem->date->diffForHumans() }}</span>
                                @endif
                                <span class="flex items-center"><i class="fas fa-eye opacity-75 mr-1"></i>{{ $newsItem->views ?? 0 }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="bg-white p-6 rounded-lg shadow-md text-center">
                        <i class="fas fa-search fa-3x text-gray-400 mb-4"></i>
                        <p class="text-gray-600 text-lg">Không tìm thấy kết quả nào phù hợp.</p>
                        <p class="text-gray-500 text-sm mt-1">Vui lòng thử với từ khóa khác hoặc điều chỉnh bộ lọc.</p>
                    </div>
                @endforelse
            </div>

            @if ($results->hasPages())
                <div class="mt-8">
                    {{ $results->links('pagination::tailwind') }}
                </div>
            @endif
        </div>

        <aside class="w-full lg:w-1/3 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="overflow-hidden swiper-container advisory-slider ad-slider relative">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="#" target="_blank" rel="noopener noreferrer" class="block ad-slide-link">
                                <img src="https://colour.vn/wp-content/uploads/mau-banner-quang-cao-khuyen-mai.jpg" alt="Quảng cáo 1" class="ad-slide-image">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" target="_blank" rel="noopener noreferrer" class="block ad-slide-link">
                                <img src="https://xuonginhanoi.vn/files/black-friday-mega-sale-facebook-timeline-cover-web-banner-template_173189-77%20(1).jpg" alt="Quảng cáo 2" class="ad-slide-image">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" target="_blank" rel="noopener noreferrer" class="block ad-slide-link">
                                <img src="https://d3design.vn/uploads/5495874fhgtrty567.jpg" alt="Quảng cáo 3" class="ad-slide-image">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-pagination advisory-slider-pagination !relative !bottom-0 pt-4"></div>
                    <div class="swiper-button-prev advisory-slider-prev !text-gray-400 hover:!text-blue-600 after:!text-lg !w-5 !h-5 !mt-[-10px] left-1 md:left-0"></div>
                    <div class="swiper-button-next advisory-slider-next !text-gray-400 hover:!text-blue-600 after:!text-lg !w-5 !h-5 !mt-[-10px] right-1 md:right-0"></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-3 flex items-center">
                    <i class="fas fa-fire text-red-500 mr-2"></i>
                    Bài viết đọc nhiều nhất
                </h3>
                @if(isset($hotNews) && $hotNews->count() > 0)
                    <ul class="space-y-4">
                        @foreach ($hotNews as $newsItem)
                            <li class="group border-b border-gray-100 pb-3 last:border-b-0 last:pb-0">
                                <a href="{{ url('/news/' . $newsItem->id) }}" {{-- TODO: Cập nhật route --}}
                                class="block text-sm font-semibold text-gray-800 leading-snug group-hover:text-blue-700 group-hover:underline mb-1.5">
                                    {{ $newsItem->title }}
                                </a>
                                @if($newsItem->content)
                                    <p class="text-xs text-gray-600 mb-2 group-hover:text-gray-700 leading-relaxed">
                                        {{ Str::limit(strip_tags($newsItem->content), 80, '...') }}
                                    </p>
                                @endif
                                <div class="text-xs text-gray-500 flex flex-wrap items-center gap-x-3 gap-y-1">
                                    @if($newsItem->label)
                                        <span class="flex items-center group-hover:text-gray-700 transition-colors duration-150">
                                                <i class="fas fa-tag opacity-75 mr-1"></i>{{ $newsItem->label->name }}
                                            </span>
                                    @endif
                                    @if($newsItem->date)
                                        <span class="flex items-center group-hover:text-gray-700 transition-colors duration-150">
                                                <i class="fas fa-calendar-alt opacity-75 mr-1"></i>{{ $newsItem->date->format('d/m/Y') }}
                                            </span>
                                    @endif
                                    <span class="flex items-center group-hover:text-gray-700 transition-colors duration-150">
                                            <i class="fas fa-eye opacity-75 mr-1"></i>{{ $newsItem->views ?? 0 }} lượt xem
                                        </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 mt-1">Chưa có bài viết nào nổi bật.</p>
                @endif
            </div>
        </aside>
    </div>
</main>

<footer class="bg-gray-800 text-gray-300 mt-12 py-8">
    <div class="container mx-auto px-4 text-center">
        <p>&copy; {{ date('Y') }} Tin Tức 24/7. Bảo lưu mọi quyền.</p>
        <p class="text-sm mt-1">Một sản phẩm của Cộng Đồng Sáng Tạo</p>
    </div>
</footer>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Swiper for Advertisement Slider
        var advisorySlider = new Swiper('.advisory-slider', {
            loop: true,
            autoplay: {
                delay: 4000, // Giảm delay một chút
                disableOnInteraction: false,
            },
            slidesPerView: 1,
            spaceBetween: 10,
            pagination: {
                el: '.advisory-slider-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.advisory-slider-next',
                prevEl: '.advisory-slider-prev',
            },
        });
    });
</script>
</body>
</html>
