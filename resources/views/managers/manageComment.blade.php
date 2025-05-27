@extends("managers.layouts.app")

@section('title', 'Quản lý bình luận')

@section('content')
    <div class="p-3 sm:p-4 bg-white rounded-lg shadow-md">
        <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-3 sm:mb-4">Quản lý bình luận</h1>

        {{-- Main Search Form --}}
        <form id="searchForm" action="{{ route('manageCommentsIndex') }}" method="GET" class="mb-3">
            <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4 mb-3">
                {{-- Search by ID --}}
                <div class="relative w-full sm:w-1/6"> {{-- Reduced width for ID input --}}
                    <input type="text" name="search_id" placeholder="Tìm ID..." value="{{ request('search_id') }}"
                           class="w-full pl-9 pr-3 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-2 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                {{-- Search by Sender Name --}}
                <div class="relative w-full sm:w-1/4"> {{-- Adjusted width for Sender input --}}
                    <input type="text" name="search_sender" placeholder="Tìm tên người gửi..." value="{{ request('search_sender') }}"
                           class="w-full pl-9 pr-3 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-2 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                {{-- Search by Content --}}
                <div class="relative w-full sm:w-1/3"> {{-- New input for Content --}}
                    <input type="text" name="search_content" placeholder="Tìm nội dung bình luận..." value="{{ request('search_content') }}"
                           class="w-full pl-9 pr-3 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-2 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                        Tìm
                    </button>
                    <a href="{{ route('manageCommentsIndex') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 text-sm">
                        Xóa tìm kiếm
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 text-sm px-3 py-2 rounded relative mb-3" role="alert">
                    <strong class="font-bold">Thành công!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 text-sm px-3 py-2 rounded relative mb-3" role="alert">
                    <strong class="font-bold">Lỗi!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                            ID
                        </th>
                        <th scope="col" class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-52">
                            Người gửi
                        </th>
                        <th scope="col" class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider sm:table-cell hidden w-24">
                            ID Bài viết
                        </th>
                        <th scope="col" class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nội dung (Click)
                        </th>
                        <th scope="col" class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider md:table-cell hidden w-16">
                            Thích
                        </th>
                        <th scope="col" class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider lg:table-cell hidden w-36">
                            Ngày tạo
                        </th>
                        <th scope="col" class="relative px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-20">
                            Hành động
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-base">
                    @forelse ($comments as $comment)
                        <tr>
                            <td class="px-1 py-1 whitespace-nowrap font-medium text-gray-900 text-center w-12">
                                {{ $comment->id }}
                            </td>
                            <td class="px-1 py-1 whitespace-nowrap text-gray-500 text-center w-32">
                                {{ Str::limit($comment->client->fullName ?? 'Người dùng', 15) }}
                            </td>
                            <td class="px-1 py-1 whitespace-nowrap text-gray-500 text-center sm:table-cell hidden w-24">
                                <a href="" class="text-blue-600 hover:text-blue-900" target="_blank">
                                    {{ $comment->news->id ?? 'Xóa' }}
                                </a>
                            </td>

                            <td  class=".view-comment-content px-1 py-1 whitespace-nowrap text-blue-600 cursor-pointer hover:underline view-comment-content text-center"
                                 data-content="{{ $comment->content }}"
                                 data-id="{{ $comment->id }}">
                                {{ Str::limit($comment->content, 30) }}
                            </td>
                            <td class="px-1 py-1 whitespace-nowrap text-gray-500 text-center md:table-cell hidden w-16">
                                {{ $comment->like_count }}

                            </td>
                            <td class="px-1 py-1 whitespace-nowrap text-gray-500 text-center lg:table-cell hidden w-28">
                                {{ $comment->date->format('d/m/Y') }}
                            </td>
                            <td class="px-1 py-1 whitespace-nowrap text-center font-medium w-20">
                                <form action="{{ route('manageCommentsDelete', $comment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 p-0.5" title="Xóa">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm6 0a1 1 0 11-2 0v6a1 1 0 112 0V8z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-1 py-1 whitespace-nowrap text-gray-500 text-center">
                                Không có bình luận nào để hiển thị.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <div class="mt-3 flex justify-center">
            {{ $comments->links() }}
        </div>
    </div>

    <div id="commentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-3 z-50 hidden">
        <div class="relative w-full max-w-lg mx-auto p-4 sm:p-5 border shadow-lg rounded-md bg-white transform transition-all duration-300 scale-95 opacity-0" id="modalContentWrapper">
            <div class="flex justify-between items-center pb-2 border-b border-gray-200 mb-2">
                <h3 class="text-base sm:text-xl font-semibold text-gray-800" id="modalCommentId"></h3>
                <button class="modal-close-button text-gray-500 hover:text-gray-700 text-2xl font-semibold leading-none focus:outline-none">
                    &times;
                </button>
            </div>
            <div class="mt-2 text-gray-700 text-lg sm:text-xl max-h-80 overflow-y-auto">
                <p id="modalCommentContent" class="whitespace-pre-line break-words"></p>
            </div>
            <div class="mt-3 text-right">
                <button class="modal-close-button px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 text-sm">
                    Đóng
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commentModal = document.getElementById('commentModal');
            const modalContentWrapper = document.getElementById('modalContentWrapper');
            const modalCommentId = document.getElementById('modalCommentId');
            const modalCommentContent = document.getElementById('modalCommentContent');
            const viewCommentButtons = document.querySelectorAll('.view-comment-content');
            const modalCloseButtons = document.querySelectorAll('.modal-close-button');

            function openModal() {
                commentModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden'); // Prevent body scroll
                // Animate modal in
                setTimeout(() => {
                    modalContentWrapper.classList.remove('scale-95', 'opacity-0');
                    modalContentWrapper.classList.add('scale-100', 'opacity-100');
                }, 10); // Small delay to allow 'hidden' removal to register
            }

            function closeModal() {
                // Animate modal out
                modalContentWrapper.classList.remove('scale-100', 'opacity-100');
                modalContentWrapper.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    commentModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden'); // Allow body scroll
                }, 300); // Wait for transition to complete
            }

            viewCommentButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const content = this.dataset.content;
                    console.log(content)
                    const id = this.dataset.id;
                    modalCommentId.textContent = 'Bình luận ID: ' + id;
                    modalCommentContent.textContent = content;
                    openModal();
                });
            });

            modalCloseButtons.forEach(button => {
                button.addEventListener('click', closeModal);
            });

            // Close modal when clicking outside of it
            commentModal.addEventListener('click', function(event) {
                if (event.target === commentModal) {
                    closeModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !commentModal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
@endsection
