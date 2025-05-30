<header class="bg-white shadow-sm py-4">
    <div class="max-w-6xl mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('news.search') }}" class="text-blue-600 font-bold text-xl flex items-center">
                <img src="https://via.placeholder.com/32x32?text=N" alt="Logo" class="h-8 w-8 mr-2 rounded-full"> Tin Tức 24/7
            </a>
            <a href="{{ route('news.search') }}" class="text-gray-600 hover:text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l7 7m-1.5-1.5L9 11l-3 3-3-3m15 0l-3-3"></path></svg>
            </a>
        </div>

        <div class="flex-1 mx-8">
            <form action="{{ route('news.search') }}" method="GET" class="relative">
                <input type="text"
                       name="q"
                       placeholder="Nhập từ khoá"
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       value="{{ request('q') }}"
                >
                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div>

        <div class="flex items-center space-x-4 text-gray-600 text-sm">
            <a href="#" class="hover:text-blue-600">Đăng nhập</a>
            <span>/</span>
            <a href="#" class="hover:text-blue-600">Đăng ký</a>
        </div>
    </div>

    <nav class="max-w-6xl mx-auto px-4 mt-4">
        <ul class="flex space-x-8 text-gray-700 font-medium">
            <li><a href="#" class="hover:text-blue-600">Đời sống</a></li>
            <li><a href="#" class="hover:text-blue-600">Thể thao</a></li>
            <li><a href="#" class="hover:text-blue-600">Khoa học - Công nghệ</a></li>
            <li><a href="#" class="hover:text-blue-600">Sức khỏe</a></li>
            <li><a href="#" class="hover:text-blue-600">Giải trí</a></li>
            <li><a href="#" class="hover:text-blue-600">Kinh doanh</a></li>
        </ul>
    </nav>
</header>
