<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao Diện Tin Tức</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            /* Màu nền xám nhạt cho tổng thể */
        }

        .comment-actions svg {
            width: 1rem;
            height: 1rem;
            margin-right: 0.25rem;
        }

        /* Custom scrollbar for latest news (optional) */
        .latest-news-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .latest-news-sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .latest-news-sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            /* slate-300 */
            border-radius: 10px;
        }

        .latest-news-sidebar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
            /* slate-500 */
        }
    </style>
</head>

<body class="text-gray-800">

    @if(Auth::check())
    @include('layouts.header_loged')
    @else
    @include('layouts.header_notloged')
    @endif

    <div class="container mx-auto p-4 lg:p-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <main class="w-full lg:w-2/3 bg-white rounded-lg shadow-lg p-6 md:p-8">
                <img src="{{ $news->thumbNailUrl }}" alt="Ảnh thumbnail bài viết" class="w-full h-auto max-h-96 object-cover rounded-md mb-6 shadow">

                <h1 class="text-3xl md:text-4xl font-bold text-blue-700 mb-4 leading-tight">
                    {{ $news->title }}
                </h1>

                <div class="flex flex-wrap items-center text-sm text-gray-500 mb-6 space-x-4">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block mr-1 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Người đăng: <span class="font-semibold text-blue-600">{{ optional($news->manager)->fullName ?? 'Ẩn danh' }}</span>
                    </span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block mr-1 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Ngày đăng: <span class="font-semibold">{{ $news->date }}</span>
                    </span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block mr-1 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Lượt xem: <span class="font-semibold">{{ $news->views }} </span>
                    </span>
                </div>

                <button
                    id="save-news-btn"
                    class="mb-8 flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-150 ease-in-out"
                    data-news-id="{{ $news->id }}" {{-- Lấy ID của bài viết --}}
                    data-is-save="{{ $isSave ? 'true' : 'false' }}" {{-- Truyền trạng thái đã lưu --}}>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.5 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                    </svg>
                    <span>Lưu bài viết</span>
                </button>

                <div class="text-md prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {!! $news->content !!}
                </div>

                <section class="mt-12 pt-8 border-t border-gray-200">
                    <h2 class="text-2xl font-semibold text-blue-700 mb-6">Bình luận</h2>
                    <form id="comment-form" method="POST" action="{{ route('comments.store', $news->id) }}" class="mb-8 p-4 bg-gray-50 rounded-lg shadow">
                        @csrf
                        <input id="reply-to-id" type="hidden" name="commentId">
                        <textarea id="comment-content" name="content" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" rows="4" placeholder="Viết bình luận của bạn..." required></textarea>
                        <div class="flex items-center mt-3">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition duration-150 ease-in-out">
                                Gửi bình luận
                            </button>
                            <button type="button" id="cancel-reply-button" class="ml-3 px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hidden">
                                Hủy phản hồi
                            </button>
                        </div>
                    </form>
{{--                    report form--}}
                    <div id="report-comment-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
                        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-sm">
                            <h3 class="text-lg font-bold mb-4 text-gray-800">Báo cáo bình luận</h3>
                            <form id="report-comment-form">
                                @csrf
                                <input type="hidden" name="commentId" id="report-comment-id-input"> {{-- Field name is now 'commentId' --}}

                                <div class="mb-4">
                                    <label for="report_reason_comment" class="block text-gray-700 text-sm font-bold mb-2">Lý do báo cáo:</label>
                                    <select name="reason" id="report_reason_comment" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                                        <option value="">Chọn một lý do</option>
                                        <option value="Tin rác">Tin rác</option>
                                        <option value="Quấy rối">Quấy rối</option>
                                        <option value="Nội dung không phù hợp">Nội dung không phù hợp</option>
                                        <option value="Khác">Khác</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="report_content_comment" class="block text-gray-700 text-sm font-bold mb-2">Chi tiết (Tùy chọn):</label>
                                    <textarea name="content" id="report_content_comment" rows="3" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Cung cấp thêm chi tiết (ví dụ: lý do khác)..."></textarea>
                                </div>
                                <div class="flex justify-end mt-4">
                                    <button type="button" id="cancel-report-comment" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md mr-2 transition duration-150 ease-in-out">Hủy</button>
                                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition duration-150 ease-in-out">Gửi báo cáo</button>
                                </div>
                            </form>
                        </div>
                    </div>
{{--                    comment--}}
                    <div id="comments-list" class="space-y-6">
                        @if($news->comments && $news->comments->count() > 0)
                            @foreach($news->comments as $comment)
                                @if (is_null($comment->commentId))
                                    <div id="comment-{{ $comment->id }}" class="p-4 bg-white rounded-lg shadow border border-gray-100">
                                        <div class="flex items-start space-x-3">
                                            <img src="{{ $comment->client->avatarUrl ?? 'https://placehold.co/40x40/a0aec0/ffffff?text=User' }}" alt="Avatar của {{ $comment->client->fullName ?? 'Người dùng' }}" class="w-10 h-10 rounded-full">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between">
                                                    <span class="font-semibold text-blue-600">{{ optional($comment->client)->fullName ?? 'Người dùng ẩn danh' }}</span>
                                                    <span class="text-xs text-gray-400">{{ $comment->date?->diffForHumans() ?? 'Không rõ thời gian' }}</span>
                                                </div>
                                                <p class="text-gray-700 mt-1">{{ $comment->content }}</p>
                                                <div class="comment-actions flex items-center space-x-3 mt-3 text-sm text-gray-500" data-id="{{ $comment->id }}">
                                                    <button onclick="react('{{ $comment->id }}', 'like')" class="like-count hover:text-blue-500 flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V3a.75.75 0 0 1 .75-.75A2.25 2.25 0 0 1 16.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904M6.633 10.5l-1.07-1.07m1.07 1.07V15m0 0H3m3.75 0v4.5m0-4.5h.75m0 0V11.25m0 0h.75m0 0V15m0 0h.75M6.633 10.5c-.636 0-1.257.074-1.844.208M10.5 15.75a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5h-4.5Z" />
                                                        </svg>
                                                        Thích (<span class="like-count-value">{{ $comment->like_count ?? 0 }}</span>)
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="reply-button hover:text-blue-500 flex items-center" {{-- Xóa onclick --}}
                                                        data-comment-id="{{ $comment->id }}"
                                                        data-client-name="{{ optional($comment->client)->fullName }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443h2.284M17.25 9.76c0-1.6-1.123-2.994-2.707-3.227A48.344 48.344 0 0 0 12 6.245c-1.108 0-2.206.086-3.293.245A3.228 3.228 0 0 0 6 9.756v3.006M21.75 12a9.75 9.75 0 1 1-19.5 0 9.75 9.75 0 0 1 19.5 0Z" />
                                                        </svg>
                                                        Phản hồi
                                                    </button>
                                                    <button type="button"
                                                            class="report-comment-button hover:text-red-500 flex items-center"
                                                            data-comment-id="{{ $comment->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                                        </svg>
                                                        Báo cáo
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="replies-container ml-10 mt-4 pl-4 border-l-2 border-blue-200 space-y-4">
                                            @if($comment->replies && $comment->replies->count() > 0)
                                                @foreach($comment->replies as $reply)
                                                    <div id="comment-{{ $reply->id }}" class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg shadow-sm">
                                                        <img src="{{ $reply->client->avatarUrl ?? 'https://placehold.co/32x32/718096/ffffff?text=User' }}" alt="Avatar của {{ $reply->client->fullName ?? 'Người dùng' }}" class="w-8 h-8 rounded-full">
                                                        <div class="flex-1">
                                                            <div class="flex items-center justify-between">
                                                                <span class="font-semibold text-blue-500">{{ optional($reply->client)->fullName ?? 'Người dùng ẩn danh' }}</span>
                                                                <span class="text-xs text-gray-400">{{ $reply->date?->diffForHumans() ?? 'Không rõ thời gian' }}</span>
                                                            </div>
                                                            <p class="text-gray-600 mt-1 text-sm">{{ $reply->content }}</p>
                                                            <div class="comment-actions flex items-center space-x-3 mt-2 text-xs text-gray-500" data-id="{{ $reply->id }}">
                                                                <button onclick="react('{{ $reply->id }}', 'like')" class="like-count hover:text-blue-500 flex items-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V3a.75.75 0 0 1 .75-.75A2.25 2.25 0 0 1 16.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904M6.633 10.5l-1.07-1.07m1.07 1.07V15m0 0H3m3.75 0v4.5m0-4.5h.75m0 0V11.25m0 0h.75m0 0V15m0 0h.75M6.633 10.5c-.636 0-1.257.074-1.844.208M10.5 15.75a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5h-4.5Z" />
                                                                    </svg>
                                                                    Thích (<span class="like-count-value">{{ $reply->like_count ?? 0 }}</span>)
                                                                </button>
                                                                <button
                                                                    type="button"
                                                                    class="reply-button hover:text-blue-500 flex items-center" {{-- Xóa onclick --}}
                                                                    data-comment-id="{{ $comment->id }}" {{-- Vẫn trả lời comment gốc --}}
                                                                    data-client-name="{{ optional($reply->client)->fullName }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 mr-1">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443h2.284M17.25 9.76c0-1.6-1.123-2.994-2.707-3.227A48.344 48.344 0 0 0 12 6.245c-1.108 0-2.206.086-3.293.245A3.228 3.228 0 0 0 6 9.756v3.006M21.75 12a9.75 9.75 0 1 1-19.5 0 9.75 9.75 0 0 1 19.5 0Z" />
                                                                    </svg>
                                                                    Phản hồi
                                                                </button>
                                                                <button type="button"
                                                                        class="report-comment-button hover:text-red-500 flex items-center"
                                                                        data-comment-id="{{ $comment->id }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                                                    </svg>
                                                                    Báo cáo
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </section>
            </main>

            <aside class="w-full lg:w-1/3">
                <div class="sticky top-8">
                    <div class="bg-white rounded-lg shadow-lg p-6 latest-news-sidebar max-h-[calc(100vh-4rem)] overflow-y-auto">
                        <h2 class="text-xl font-semibold text-blue-700 mb-6 border-b pb-3">Tin tức mới nhất</h2>
                        <div class="space-y-5">
                            @foreach($hotNews as $item)
                            <a href="/news/{{ $item->id }}" class="block group hover:bg-blue-50 p-3 rounded-md transition duration-150">
                                <div class="flex items-start space-x-3">
                                    <img src="{{ $item->thumbNailUrl }}" class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                                    <div>
                                        <h3 class="text-md font-semibold text-gray-800 group-hover:text-blue-600 leading-tight">{{ $item->title }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">{{ $item->date?->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    @php
    $client = Auth::user();
    @endphp

    @if(session('scroll_to_comment'))
    <script>
        window.onload = () => {
            document.getElementById("comment-form")?.scrollIntoView({
                behavior: 'smooth'
            });
        };
    </script>
    @endif

    <script>
        function startReply(id, name = '') {
            const input = document.getElementById('reply-to-id');
            const textarea = document.getElementById('comment-content');
            if (input) input.value = id;
            if (textarea && name && !textarea.value.startsWith(`@${name}`)) {
                textarea.value = `@${name} `;
            }
            document.getElementById('comment-form')?.scrollIntoView({
                behavior: 'smooth'
            });
        }
        function react(commentId, type) {
            fetch(`/comments/${commentId}/${type}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const wrapper = document.querySelector(`[data-id='${commentId}']`);
                    if (wrapper) {
                        wrapper.querySelector(`.${type}-count`).innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V3a.75.75 0 0 1 .75-.75A2.25 2.25 0 0 1 16.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904M6.633 10.5l-1.07-1.07m1.07 1.07V15m0 0H3m3.75 0v4.5m0-4.5h.75m0 0V11.25m0 0h.75m0 0V15m0 0h.75M6.633 10.5c-.636 0-1.257.074-1.844.208M10.5 15.75a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5h-4.5Z" />
                        </svg>
                        Thích (${data[`${type}_count`]})
                        `;
                    }
                })
                .catch(() => alert(`Không thể ${type} bình luận.`));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const saveNewsBtn = document.getElementById('save-news-btn');
            const newsId = saveNewsBtn.dataset.newsId;
            let isSave = saveNewsBtn.dataset.isSave === 'true'; // Chuyển đổi chuỗi 'true'/'false' thành boolean
            const buttonTextSpan = saveNewsBtn.querySelector('span'); // Thêm một span để dễ thay đổi text

            // Hàm cập nhật trạng thái UI của nút
            function updateSaveButtonUI() {
                if (isSave) {
                    saveNewsBtn.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                    saveNewsBtn.classList.add('bg-gray-400', 'cursor-not-allowed'); // Màu xám và không cho phép click
                    saveNewsBtn.disabled = true; // Vô hiệu hóa nút
                    buttonTextSpan.textContent = 'Bài viết đã lưu';
                } else {
                    saveNewsBtn.classList.add('bg-blue-500', 'hover:bg-blue-600');
                    saveNewsBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    saveNewsBtn.disabled = false;
                    buttonTextSpan.textContent = 'Lưu bài viết';
                }
            }

            // Gọi hàm lần đầu khi trang tải xong
            updateSaveButtonUI();

            // Xử lý sự kiện click để lưu bài viết
            // Giả sử bạn có hàm `save()` để gửi request lưu bài viết
            saveNewsBtn.addEventListener('click', async () => {
                if (!isSave) { // Chỉ thực hiện nếu chưa lưu
                    try {
                        const response = await fetch('/save-news', { // Thay đổi URL này thành route của bạn
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Đảm bảo có CSRF token
                            },
                            body: JSON.stringify({
                                newsId: newsId
                            })
                        });
                        const data = await response.json();

                        console.log(response);

                        if (response.ok) {
                            isSave = true; // Cập nhật trạng thái
                            updateSaveButtonUI(); // Cập nhật UI
                            alert(data.message || 'Bài viết đã được lưu thành công!');
                        } else {
                            const loginUrl = "{{ route('login') }}";
                            window.location.href = loginUrl;
                            alert(data.message || 'Có lỗi xảy ra khi lưu bài viết.');
                        }
                    } catch (error) {
                        console.error('Lỗi khi gửi yêu cầu lưu:', error);
                        alert('Lỗi kết nối hoặc server. Vui lòng thử lại.');
                    }
                }
            });
        });
    </script>

{{--    handle submit content + report--}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Existing Comment & Reply Form Elements ---
            const commentForm = document.getElementById('comment-form');
            const commentContent = document.getElementById('comment-content');
            const replyToIdInput = document.getElementById('reply-to-id');
            const commentsList = document.getElementById('comments-list');
            const cancelReplyButton = document.getElementById('cancel-reply-button');

            // --- Report Comment Form Elements ---
            const reportCommentModal = document.getElementById('report-comment-modal');
            const reportCommentForm = document.getElementById('report-comment-form');
            const reportCommentIdInput = document.getElementById('report-comment-id-input'); // Updated ID to match form
            const cancelReportCommentButton = document.getElementById('cancel-report-comment');
            const reportReasonCommentSelect = document.getElementById('report_reason_comment');
            const reportContentCommentTextarea = document.getElementById('report_content_comment');

            // Helper function to create comment HTML (kept as is)
            function createCommentHtml(commentData, isReply = false) {
                let mainDivClasses = 'flex p-4 bg-white rounded-lg shadow border border-gray-100';
                let imgSize = 'w-10 h-10';
                let contentClasses = 'text-gray-700 mt-1';
                let userTextClasses = 'font-semibold text-blue-600';
                let actionsClasses = 'comment-actions flex items-center space-x-3 mt-3 text-sm text-gray-500';
                let iconSize = 'w-4 h-4';

                if (isReply) {
                    mainDivClasses = 'flex items-start space-x-3 p-3 bg-gray-50 rounded-lg shadow-sm';
                    imgSize = 'w-8 h-8';
                    contentClasses = 'text-gray-600 mt-1 text-sm';
                    userTextClasses = 'font-semibold text-blue-500';
                    actionsClasses = 'comment-actions flex items-center space-x-3 mt-2 text-xs text-gray-500';
                    iconSize = 'w-3 h-3';
                }

                let contentDisplay = commentData.content;
                const avatarUrl = "{{ $client->avatarUrl }}";

                return `
                <div id="comment-${commentData.id}" class="${mainDivClasses}">
                    <div class="flex items-start space-x-3 w-full">
                        <img src="${avatarUrl}"
                             alt="Avatar của ${commentData.client_name}" class="${imgSize} rounded-full">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <span class="${userTextClasses}">${commentData.client_name}</span>
                                <span class="text-xs text-gray-400">Vừa xong</span>
                            </div>
                            <p class="${contentClasses}">${contentDisplay}</p>
                            <div class="${actionsClasses}" data-id="${commentData.id}">
                                <button onclick="react('${commentData.id}', 'like')" class="like-count hover:text-blue-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="${iconSize} mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V3a.75.75 0 0 1 .75-.75A2.25 2.25 0 0 1 16.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904M6.633 10.5l-1.07-1.07m1.07 1.07V15m0 0H3m3.75 0v4.5m0-4.5h.75m0 0V11.25m0 0h.75m0 0V15m0 0h.75M6.633 10.5c-.636 0-1.257.074-1.844.208M10.5 15.75a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5h-4.5Z" />
                                    </svg>
                                    Thích (<span class="like-count-value">${commentData.like_count}</span>)
                                </button>
                                <button type="button" class="reply-button hover:text-blue-500 flex items-center"
                                    data-comment-id="${isReply ? commentData.comment_id : commentData.id}"
                                    data-client-name="${commentData.client_name}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="${iconSize} mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443h2.284M17.25 9.76c0-1.6-1.123-2.994-2.707-3.227A48.344 48.344 0 0 0 12 6.245c-1.108 0-2.206.086-3.293.245A3.228 3.228 0 0 0 6 9.756v3.006M21.75 12a9.75 9.75 0 1 1-19.5 0 9.75 9.75 0 0 1 19.5 0Z" />
                                    </svg>
                                    Phản hồi
                                </button>
                                <button type="button" class="report-comment-button hover:text-red-500 flex items-center"
                                        data-comment-id="${commentData.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="${iconSize} mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                    </svg>
                                    Báo cáo
                                </button>
                            </div>
                        </div>
                    </div>
                    ${isReply ? '' : `
                        <div class="replies-container ml-10 mt-4 pl-4 border-l-2 border-blue-200 space-y-4">
                            </div>
                    `}
                </div>
            `;
            }

            // Functions for comment/reply management (kept as is)
            function startReply(commentId, clientName) {
                replyToIdInput.value = commentId;
                commentContent.value = `@${clientName} `;
                commentContent.focus();
                commentForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
                cancelReplyButton.classList.remove('hidden');
            }

            window.react = function(commentId, actionType) {
                console.log(`Đang xử lý ${actionType} cho comment ID: ${commentId}`);
                // Implement AJAX call for like/report on comments here if not done yet
            };

            // Event delegation for reply buttons (kept as is)
            commentsList.addEventListener('click', function(event) {
                const replyButton = event.target.closest('.reply-button');
                if (replyButton) {
                    const commentId = replyButton.dataset.commentId;
                    const clientName = replyButton.dataset.clientName;
                    startReply(commentId, clientName);
                }
            });

            // Event listener for cancel reply button (kept as is)
            cancelReplyButton.addEventListener('click', function() {
                replyToIdInput.value = '';
                commentContent.value = '';
                commentContent.placeholder = 'Viết bình luận của bạn...';
                cancelReplyButton.classList.add('hidden');
            });

            // Comment form submission (kept as is)
            commentForm.addEventListener('submit', async function(event) {
                event.preventDefault();
                const formData = new FormData(commentForm);
                const actionUrl = commentForm.getAttribute('action');
                const parentCommentId = replyToIdInput.value;

                try {
                    const response = await fetch(actionUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData,
                    });
                    const data = await response.json();

                    if (response.ok && data.success) {
                        const newCommentData = data.comment;
                        let newCommentHtml;

                        if (parentCommentId) {
                            const parentCommentElement = document.getElementById(`comment-${parentCommentId}`);
                            if (parentCommentElement) {
                                const repliesContainer = parentCommentElement.querySelector('.replies-container');
                                if (repliesContainer) {
                                    newCommentHtml = createCommentHtml(newCommentData, true);
                                    repliesContainer.insertAdjacentHTML('beforeend', newCommentHtml);
                                } else {
                                    console.warn('Không tìm thấy container replies cho bình luận cha. Chèn như bình luận gốc.');
                                    newCommentHtml = createCommentHtml(newCommentData, false);
                                    commentsList.insertAdjacentHTML('afterbegin', newCommentHtml);
                                }
                            } else {
                                console.warn('Không tìm thấy element bình luận cha. Chèn như bình luận gốc.');
                                newCommentHtml = createCommentHtml(newCommentData, false);
                                commentsList.insertAdjacentHTML('afterbegin', newCommentHtml);
                            }
                        } else {
                            newCommentHtml = createCommentHtml(newCommentData, false);
                            commentsList.insertAdjacentHTML('afterbegin', newCommentHtml);
                        }

                        commentContent.value = '';
                        replyToIdInput.value = '';
                        commentContent.placeholder = 'Viết bình luận của bạn...';
                        cancelReplyButton.classList.add('hidden');
                        console.log('Bình luận đã được thêm thành công!', newCommentData);
                    } else {
                        let errorMessage = data.message || 'Có lỗi xảy ra khi gửi bình luận.';
                        if (data.errors) { for (const field in data.errors) { errorMessage += `\n- ${data.errors[field].join(', ')}`; } }
                        alert(errorMessage); console.error('Lỗi khi gửi bình luận:', data);
                    }
                } catch (error) {
                    alert('Không thể kết nối đến server. Vui lòng thử lại.'); console.error('Lỗi fetch request:', error);
                }
            });

            // --- Report Comment Functionality JavaScript ---
            // Show Comment Report Modal via Event Delegation
            commentsList.addEventListener('click', function(event) {
                const reportCommentBtn = event.target.closest('.report-comment-button');
                if (reportCommentBtn) {
                    const commentId = reportCommentBtn.dataset.commentId;
                    reportCommentIdInput.value = commentId; // Set the ID of the comment to be reported
                    reportCommentModal.classList.remove('hidden'); // Show the modal
                    reportReasonCommentSelect.value = ''; // Reset dropdown
                    reportContentCommentTextarea.value = ''; // Reset content
                }
            });

            // Hide Comment Report Modal
            if (cancelReportCommentButton) {
                cancelReportCommentButton.addEventListener('click', function() {
                    reportCommentModal.classList.add('hidden');
                    reportCommentForm.reset();
                });
            }

            // Handle Report Comment Form Submission
            if (reportCommentForm) {
                reportCommentForm.addEventListener('submit', async function(event) {
                    event.preventDefault();

                    const formData = new FormData(reportCommentForm);
                    // Action URL points to the dedicated comment report route
                    const actionUrl = '{{ route('reports.comments.store') }}';
                    try {
                        const response = await fetch(actionUrl, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData,
                        });
                        const data = await response.json();
                        if (response.ok && data.success) {
                            alert(data.message);
                            reportCommentModal.classList.add('hidden'); // Hide modal on success
                            reportCommentForm.reset(); // Reset form
                        } else {
                            let errorMessage = data.message || 'Có lỗi xảy ra khi gửi báo cáo.';
                            if (data.errors) {
                                // Display validation errors clearly
                                for (const field in data.errors) {
                                    errorMessage += `\n- ${field}: ${data.errors[field].join(', ')}`;
                                }
                            }
                            alert(errorMessage);
                            console.error('Lỗi khi gửi báo cáo:', data);
                        }
                    } catch (error) {
                        alert('Không thể kết nối đến server. Vui lòng thử lại.');
                        console.error('Lỗi fetch request cho báo cáo:', error);
                    }
                });
            }
        });
    </script>
</body>
</html>
