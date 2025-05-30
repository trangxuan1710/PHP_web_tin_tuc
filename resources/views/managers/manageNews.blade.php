@extends("managers.layouts.app")

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Quản lý bài viết</h3>
            <div class="flex items-center space-x-4">
                <a href="{{ route('addNews') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow transition-colors duration-200">
                    Thêm bài viết
                </a>
                <form action="{{ route('manageNews') }}" method="GET" class="m-0 flex items-center space-x-2">
                    {{-- Dropdown để chọn nhãn --}}
                    <select name="label_id" class="py-2 px-4 border w-36 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tất cả nhãn</option>
                        @foreach($labels as $labelOption)
                            <option value="{{ $labelOption->id }}" {{ old('label_id', $labelId ?? '') == $labelOption->id ? 'selected' : '' }}>
                                {{ $labelOption->type }}
                            </option>
                        @endforeach
                    </select>
                    {{-- Ô nhập nội dung tìm kiếm theo tiêu đề --}}
                    <div class="relative">
                        <input type="text"
                               name="keyword"
                               placeholder="Tìm kiếm tin tức..."
                               value="{{ old('keyword', $keyword ?? '') }}"
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    {{-- Nút tìm kiếm --}}
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow transition-colors duration-200">Tìm</button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Thành công!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentNode.remove()">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.697l-2.651 2.652a1.2 1.2 0 1 1-1.697-1.697L8.303 10l-2.652-2.651a1.2 1.2 0 1 1 1.697-1.697L10 8.303l2.651-2.652a1.2 1.2 0 1 1 1.697 1.697L11.697 10l2.652 2.651a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        @endif

        <div class="space-y-4 mb-6">
            @php use Illuminate\Support\Str; @endphp

            @forelse ($news as $item)
                @php
                    $bgColorClass = 'bg-gray-50'; // Màu nền mặc định
                    if (isset($item->status)) {
                        if ($item->status == 'publish') {
                            $bgColorClass = 'bg-green-50'; // Màu nền cho trạng thái public
                        }
                    }
                    $hoverShadowClass = 'hover:shadow-md';

                @endphp
                <div class="flex items-center {{$bgColorClass}} p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="flex-1">

                        <p class="font-medium text-gray-900">ID: {{ $item->id }} - {{ $item->title }} </p>

                        <p class="text-sm text-gray-600">
                            @if ($item->manager)
                                {{ $item->manager->fullName }} -
                            @else
                                Người dùng không xác định -
                            @endif
                            {{ $item->date->format('H:i d/m/Y') }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        @php
                            $status = $item->isHot ? 'Tin nóng' : 'Bình thường';
                            $statusClass = '';
                            switch ($status) {
                                case 'Tin nóng':
                                    $statusClass = 'bg-red-200 text-red-800';
                                    break;
                                case 'Bình thường':
                                    $statusClass = 'bg-gray-200 text-gray-800';
                                    break;
                                default:
                                    $statusClass = 'bg-gray-200 text-gray-800';
                                    break;
                            }
                        @endphp
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                    {{ $status }}
                </span>

                        <a href="{{ route('news.edit', $item->id) }}" class="text-yellow-500 hover:text-yellow-600 transition-colors duration-200">
                            <i class="fas fa-edit text-lg"></i>
                        </a>

                        <button onclick="" type="button" data-id="{{ $item->id }}" class="delete-news-btn text-red-500 hover:text-red-600 transition-colors duration-200 ">
                            <i class="fas fa-trash-alt text-lg"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-gray-500 bg-white rounded-lg shadow-sm">
                    Chưa có tin tức nào được tạo.
                </div>
            @endforelse
        </div>
    </div>
    <div id="alert-messages" class="fixed bottom-4 right-4 z-50"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-news-btn'); // Lấy tất cả các nút xóa
            const alertMessagesContainer = document.getElementById('alert-messages');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const newsId = this.dataset.id; // Lấy ID của tin tức từ data-id
                    const newsItemElement = document.querySelector(`.news-item-${newsId}`); // Lấy phần tử cha của tin tức
                    console.log(newsId,"loooo")
                    if (confirm('Bạn có chắc chắn muốn xóa tin tức này không?')) {

                        fetch(`/news/${newsId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                            .then(response => {

                                if (!response.ok) {
                                    return response.json().then(errorData => {
                                        throw new Error(errorData.message || 'Lỗi không xác định.');
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Xóa thành công
                                console.log('Xóa thành công:', data);
                                if (newsItemElement) {
                                    newsItemElement.remove();
                                }
                                showAlert(data.message || 'Tin tức đã được xóa thành công!', 'success');

                                if (document.querySelectorAll('.delete-news-btn').length === 0) {
                                    const parentDiv = newsItemElement.closest('.space-y-4');
                                    if (parentDiv) {
                                        parentDiv.innerHTML = '<div class="p-4 text-center text-gray-500 bg-white rounded-lg shadow-sm">Chưa có tin tức nào được tạo.</div>';
                                    }
                                }

                            })
                            .catch(error => {
                                // Xử lý lỗi
                                console.error('Lỗi khi xóa:', error);
                                showAlert(error.message || 'Đã xảy ra lỗi khi xóa tin tức.', 'error');
                            });
                    }
                });
            });

            // Hàm hiển thị thông báo
            function showAlert(message, type) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `p-3 mb-2 rounded-lg shadow-md max-w-sm w-full transition-opacity duration-300 ease-out opacity-0 transform translate-y-4`;

                if (type === 'success') {
                    alertDiv.classList.add('bg-green-500', 'text-white');
                } else if (type === 'error') {
                    alertDiv.classList.add('bg-red-500', 'text-white');
                }

                alertDiv.innerHTML = `
            <div class="flex items-center">
                <i class="${type === 'success' ? 'fas fa-check-circle' : 'fas fa-times-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
                alertMessagesContainer.appendChild(alertDiv);

                // Hiển thị alert
                setTimeout(() => {
                    alertDiv.classList.remove('opacity-0', 'translate-y-4');
                    alertDiv.classList.add('opacity-100', 'translate-y-0');
                }, 100);

                // Tự động ẩn sau 3 giây
                setTimeout(() => {
                    alertDiv.classList.remove('opacity-100', 'translate-y-0');
                    alertDiv.classList.add('opacity-0', 'translate-y-4');
                    // Xóa phần tử khỏi DOM sau khi ẩn hoàn toàn
                    alertDiv.addEventListener('transitionend', () => alertDiv.remove());
                }, 3000);
            }
        });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40j/6Pqq/VHzUfTsL7W/feV6S4q60o7N_iO1d7k4h1X7VvT8f3GjZ6zQ0U5s2M8Q2gK5W9J5m0Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
