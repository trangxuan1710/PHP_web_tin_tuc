<header class="bg-white shadow-md py-5 px-6 md:px-10 lg:px-14 flex items-center justify-between rounded-b-lg space-x-8">
    <div class="flex items-center space-x-20 lg:space-x-20 w-3/4">
        <div class="flex items-center flex-shrink-0">
            <div
                class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-sans text-lg font-medium">
                N</div>
            <span class="ml-2 text-blue-800 text-2xl font-bold font-sans whitespace-nowrap">Tin Tức 24/7</span>
        </div>

        <div class="flex items-center space-x-4 flex-1">
            <a href="/"
                class="text-blue-600 hover:text-blue-800 transition-colors duration-200 p-2 rounded-full hover:bg-blue-50 flex-shrink-0"
                aria-label="Trang chủ">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="#0d99ff" d="m12 5.69l5 4.5V18h-2v-6H9v6H7v-7.81zM12 3L2 12h3v8h6v-6h2v6h6v-8h3z"
                        stroke-width="0.5" stroke="#0d99ff" />
                </svg>
            </a>
            <div
                class="flex items-center space-x-2 px-2 py-1 border-gray-300 border-2 rounded-full focus-within:ring-2 focus-within:ring-blue-500 flex-1 w-fit sm:w-24 md:w-72 max-w-md">
                <a href="#" class="text-gray-600 hover:text-blue-600 transition-colors duration-200 p-2 rounded-full
                        hover:bg-blue-50" aria-label="Tìm kiếm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 15 15">
                        <path fill="#0d99ff" fill-rule="evenodd"
                            d="M10 6.5a3.5 3.5 0 1 1-7 0a3.5 3.5 0 0 1 7 0m-.691 3.516a4.5 4.5 0 1 1 .707-.707l2.838 2.837a.5.5 0 0 1-.708.708z"
                            clip-rule="evenodd" stroke-width="0.5" stroke="#0d99ff" />
                    </svg>
                </a>
                <input type="text" id="search-input" placeholder="Nhập từ khoá"
                    class="bg-transparent focus:outline-none text-gray-700 placeholder-gray-400 w-full">
            </div>
        </div>
    </div>

    <div class="flex items-center flex-1 justify-end space-x-2">
        <a href="/login" class="text-blue-600 hover:text-blue-800 font-medium font-sans transition-colors duration-200 whitespace-nowrap text-base px-4 py-2 rounded-full hover:bg-blue-50">Đăng nhập</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="/signup" class="text-blue-600 hover:text-blue-800 font-medium font-sans transition-colors duration-200 whitespace-nowrap text-base px-4 py-2 rounded-full hover:bg-blue-50">Đăng ký</a>
    </div>
</header>