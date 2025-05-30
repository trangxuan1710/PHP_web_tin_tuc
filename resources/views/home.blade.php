<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin tức 24/7 - Trang chủ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- No Custom CSS, only Tailwind CSS --}}
    {{-- <link rel="stylesheet" href="/css/app.css"> --}}
</head>

<body class="font-['Inter'] bg-[#f8faff] text-gray-800">
    {{-- Header and Navbar will be included from Laravel Blade, assuming they have a dark blue color --}}
    @if(Auth::check())
    @include('layouts.header_loged')
    @else
    @include('layouts.header_notloged')
    @endif

    @include('layouts.navbar')

    <main class="container max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <section class="featured-news">
            @if(isset($hotNews) && $hotNews->count() > 0)
            <div class="flex flex-col bg-white rounded-xl overflow-hidden shadow-lg mb-8">
                <img src="{{ $hotNews->first()->thumbNailUrl }}" alt="{{ $hotNews->first()->title }}" class="w-full h-96 object-cover rounded-t-xl">
                <div class="p-6">
                    <h2 class="text-4xl font-bold text-blue-600 mb-3 leading-tight">
                        <a href="/news/{{ $hotNews->first()->id }}" class="hover:text-blue-800 transition-colors duration-200 no-underline">
                            {{ $hotNews->first()->title }}
                        </a>
                    </h2>
                    {{-- Use text-base for featured content to avoid being too large, and limit lines --}}
                    <div class="text-base text-gray-700 leading-relaxed mt-4 line-clamp-4">{!! $hotNews->first()->content !!}</div>
                    {{-- Add other information like author, publish date if needed --}}
                    <p class="text-sm text-gray-500 mt-4">
                        <span>{{ optional($hotNews->first()->manager)->fullName }}</span> |
                        <span>{{ $hotNews->first()->date->diffForHumans() }}</span> |
                        <span>{{ $hotNews->first()->views ?? 0 }} lượt xem</span>
                    </p>
                </div>
            </div>
            @endif
        </section>

        <div id="scroll-here" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- This section will now display news from a dynamic label --}}
            <section class="lg:col-span-2"> {{-- Main content takes 2/3 width on large screens --}}
                <h3 class="text-3xl font-bold text-blue-600 mb-6 pb-2 border-b-2 border-gray-200">
                    {{ $dynamicCategoryTitle }}
                </h3>
                {{-- Add links to change dynamic label --}}
                <div id="dynamic-category-news-list" class="grid gap-6">
                </div>
                <div class="flex justify-center items-center mt-8 space-x-4">
                    <button id="prev-page" class="px-4 py-2 bg-white text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-100 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center border border-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <span id="page-info" class="text-lg font-medium text-gray-700"></span>
                    <button id="next-page" class="px-4 py-2 bg-white text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-100 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center border border-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </section>

            <aside class="lg:col-span-1"> {{-- Sidebar takes 1/3 width on large screens --}}
                <section class="bg-white rounded-xl p-6 shadow-sm mb-8">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4 pb-2 border-b border-gray-200">Góc nhìn</h3>
                    <div class="grid gap-3">
                        @if(isset($opinionNews))
                        @foreach($opinionNews as $news)
                        <div class="mb-3">
                            <h4 class="text-base font-semibold text-gray-800">
                                <a href="/news/{{ $news->id }}" class="hover:text-blue-600 transition-colors duration-200 no-underline line-clamp-2">
                                    {{ $news->title }}
                                </a>
                            </h4>
                            {{-- Can add author's avatar if available --}}
                        </div>
                        @endforeach
                        @endif
                    </div>
                </section>

                {{-- This section will now display "Latest News" in the sidebar --}}
                <section class="bg-white rounded-xl p-6 shadow-sm mb-8">
                    <h3 class="text-2xl font-bold text-blue-600 mb-4 pb-2 border-b border-gray-200">Tin mới nhất</h3>
                    <div class="grid gap-3">
                        @if(isset($latestNews))
                        {{-- Limit the number of news items displayed in the sidebar to 5 --}}
                        @foreach($latestNews->take(5) as $news)
                        <div class="flex items-center gap-3 shadow-none border-b border-dashed border-gray-300 pb-3 last:border-b-0 last:pb-0 last:mb-0">
                            @if($news->thumbNailUrl)
                            <img src="{{ $news->thumbNailUrl }}" alt="{{ $news->title }}" class="w-20 h-16 object-cover rounded-md">
                            @endif
                            <div class="flex-grow">
                                <h4 class="text-base font-semibold text-gray-800">
                                    <a href="/news/{{ $news->id }}" class="hover:text-blue-600 transition-colors duration-200 no-underline line-clamp-2">
                                        {{ $news->title }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-500 mt-1">
                                    <span>{{ $news->date->diffForHumans() }}</span>
                                </p>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </section>
            </aside>
        </div>
    </main>

    <footer class="bg-blue-600 text-white py-10 rounded-t-xl mt-8">
        <div class="container max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="footer-col">
                    <h4 class="text-xl font-bold mb-4 text-blue-100">LIÊN HỆ</h4>
                    <ul class="list-none p-0">
                        <li class="mb-2"><a href="/gioi-thieu" class="text-white hover:text-blue-200 transition-colors duration-200 no-underline">Giới thiệu</a></li>
                        <li class="mb-2"><a href="/dieu-khoan-su-dung" class="text-white hover:text-blue-200 transition-colors duration-200 no-underline">Điều khoản sử dụng</a></li>
                        <li class="mb-2"><a href="/chinh-sach-bao-mat" class="text-white hover:text-blue-200 transition-colors duration-200 no-underline">Chính sách bảo mật</a></li>
                        <li class="mb-2"><a href="/quang-cao" class="text-white hover:text-blue-200 transition-colors duration-200 no-underline">Quảng cáo</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="text-xl font-bold mb-4 text-blue-100">KHÁC</h4>
                    <ul class="list-none p-0">
                        <li class="mb-2"><a href="/tong-hop" class="text-white hover:text-blue-200 transition-colors duration-200 no-underline">Tổng hợp</a></li>
                    </ul>
                </div>
                <div class="footer-col contact-info">
                    <p class="text-sm leading-relaxed mb-2 text-blue-200">Giấy phép thiết lập trang thông tin điện tử tổng hợp số 188/GP-TTĐT do Sở Thông tin và Truyền thông Hà Nội cấp ngày 05/05/2025.</p>
                    <p class="text-sm leading-relaxed mb-2 text-blue-200">Đơn vị thiết lập: Công ty cổ phần công nghệ ERF - Chịu trách nhiệm quản lý nội dung: Bà Trang Xuân</p>
                    <p class="text-sm leading-relaxed mb-2 text-blue-200">Địa chỉ: Tầng 16, tòa nhà KDT Tower, số 344 Nguyễn Trãi, Thanh Xuân, Hà Nội.</p>
                    <p class="text-sm leading-relaxed mb-2 text-blue-200">Điện thoại: (024) 3.542.xxxx | Email: contact@example.com</p>
                    <p class="text-sm leading-relaxed mb-2 text-blue-200">BAOMOI tổng hợp và sắp xếp các thông tin từ đóng góp của cộng đồng dựa trên chương trình máy tính.</p>
                </div>
            </div>
        </div>
    </footer>

    <script id="data" type="application/json">
        @json($dynamicCategoryNews ?? [])
    </script>

    <script>
        let isHome = "{{ $isHome }}";
        let dynamicCategoryNews = JSON.parse(document.getElementById('data').textContent);
        console.log(dynamicCategoryNews);

        let currentPage = 1;
        const itemsPerPage = 5; // Display 5 news items per page

        function renderDynamicCategoryNews() {
            const dynamicCategoryNewsList = document.getElementById('dynamic-category-news-list');
            dynamicCategoryNewsList.innerHTML = ''; // Clear previous content

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const newsToDisplay = dynamicCategoryNews.slice(startIndex, endIndex);

            newsToDisplay.forEach(news => {
                dynamicCategoryNewsList.innerHTML += `
                    <div class="flex items-center gap-3 shadow-none border-b border-dashed border-gray-300 pb-3 last:border-b-0 last:pb-0 last:mb-0">
                            <img src="${news.thumbNailUrl}" alt="${news.title}" class="w-40 h-32 object-cover rounded-md">
                            <div class="flex-grow">
                                <h4 class="text-xl font-semibold text-gray-800">
                                    <a href="/news/${news.id}" class="hover:text-blue-600 transition-colors duration-200 no-underline line-clamp-2">
                                        ${news.title}
                                    </a>
                                </h4>
                                <p class="text-base text-gray-500 mt-1">
                                    <span>${news.views} lượt xem</span>
                                </p>
                            </div>
                        </div>
                </div>
                `;
            });

            updatePaginationControls();
        }

        function updatePaginationControls() {
            const totalPages = Math.ceil(dynamicCategoryNews.length / itemsPerPage);
            document.getElementById('page-info').textContent = `Trang ${currentPage} / ${totalPages}`;

            const prevButton = document.getElementById('prev-page');
            const nextButton = document.getElementById('next-page');

            prevButton.disabled = currentPage === 1;
            nextButton.disabled = currentPage === totalPages;

            // Adjust padding for buttons to make icons centered
            prevButton.classList.remove('px-6', 'py-3');
            prevButton.classList.add('px-4', 'py-2');
            nextButton.classList.remove('px-6', 'py-3');
            nextButton.classList.add('px-4', 'py-2');
        }

        document.getElementById('prev-page').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderDynamicCategoryNews();
            }
        });

        document.getElementById('next-page').addEventListener('click', () => {
            const totalPages = Math.ceil(dynamicCategoryNews.length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderDynamicCategoryNews();
            }
        });
        document.addEventListener('DOMContentLoaded', () => {
            renderDynamicCategoryNews();
            if (!isHome) {
                window.onload = () => {
                    document.getElementById("scroll-here")?.scrollIntoView({
                        behavior: 'smooth'
                    });
                };
            }
        });
    </script>
</body>

</html>