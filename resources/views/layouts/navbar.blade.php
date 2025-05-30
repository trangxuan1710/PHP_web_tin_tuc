<nav class="bg-white shadow-sm py-3 px-4 md:px-8 lg:px-12 mt-0.5 flex justify-center rounded-b-lg">
    <div class="flex flex-wrap justify-center gap-x-8 gap-y-2 lg:gap-x-16">
        <a href=" {{ route('tab', ['tab' => 'tin-nong']) }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 p-2 rounded-md hover:bg-blue-50 whitespace-nowrap">Tin nóng</a>
        <a href=" {{ route('tab', ['tab' => 'doi-song']) }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 p-2 rounded-md hover:bg-blue-50 whitespace-nowrap">Đời sống</a>
        <a href=" {{ route('tab', ['tab' => 'the-thao']) }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 p-2 rounded-md hover:bg-blue-50 whitespace-nowrap">Thể thao</a>
        <a href=" {{ route('tab', ['tab' => 'khoa-hoc-cong-nghe']) }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 p-2 rounded-md hover:bg-blue-50 whitespace-nowrap">Khoa học - Công nghệ</a>
        <a href=" {{ route('tab', ['tab' => 'suc-khoe']) }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 p-2 rounded-md hover:bg-blue-50 whitespace-nowrap">Sức khoẻ</a>
        <a href=" {{ route('tab', ['tab' => 'giai-tri']) }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 p-2 rounded-md hover:bg-blue-50 whitespace-nowrap">Giải trí</a>
        <a href=" {{ route('tab', ['tab' => 'kinh-doanh']) }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 p-2 rounded-md hover:bg-blue-50 whitespace-nowrap">Kinh doanh</a>
    </div>
</nav>

<script>
    window.onload = () => {
        document.getElementById("comment-form")?.scrollIntoView({
            behavior: 'smooth'
        });
    };
</script>