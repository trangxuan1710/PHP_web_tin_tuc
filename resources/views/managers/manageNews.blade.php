@extends("managers.layouts.app")

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Quản lý bài viết</h3>
            <div class="flex items-center space-x-4">
                <a href="{{ route('addNews') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow transition-colors duration-200">
                    Thêm bài viết
                </a>
                <div class="relative">
                    <input type="text" placeholder="Tìm kiếm" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
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
                <div class="flex items-center bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">ID: {{ $item->id }} - {{ $item->title }}</p>

                        <p class="text-sm text-gray-600">
                            {{-- Đã thay đổi từ $item->user thành $item->manager --}}
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
                                case 'Đã xuất bản':
                                    $statusClass = 'bg-green-200 text-green-800';
                                    break;
                                case 'Bản nháp':
                                    $statusClass = 'bg-yellow-200 text-yellow-800';
                                    break;
                                case 'Viết lại':
                                    $statusClass = 'bg-purple-200 text-purple-800';
                                    break;
                                case 'Chờ duyệt':
                                    $statusClass = 'bg-blue-200 text-blue-800';
                                    break;
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
                        <button class="text-yellow-500 hover:text-yellow-600 transition-colors duration-200">
                            <i class="fas fa-edit text-lg"></i>
                        </button>
                        <button class="text-red-500 hover:text-red-600 transition-colors duration-200">
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40j/6Pqq/VHzUfTsL7W/feV6S4q60o7N_iO1d7k4h1X7VvT8f3GjZ6zQ0U5s2M8Q2gK5W9J5m0Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
