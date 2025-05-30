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
    <div class="container mx-auto p-4 lg:p-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <main class="w-full lg:w-2/3 bg-white rounded-lg shadow-lg p-6 md:p-8">
                <img src="https://placehold.co/800x450/3b82f6/ffffff?text=Ảnh+Thumbnail" alt="Ảnh thumbnail bài viết" class="w-full h-auto max-h-96 object-cover rounded-md mb-6 shadow">

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
                        Giờ đăng: <span class="font-semibold">{{ $news->created_at?->diffForHumans() }}</span>
                    </span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 inline-block mr-1 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        Lượt xem: <span class="font-semibold">{{ $news->views }} </span>
                    </span>
                </div>

                <form id="save-news-form" method="POST" action="{{ route('news.save', $news->id) }}" display="none">
                </form>

                <button id="save-news-btn" class="mb-8 flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.5 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                    </svg>
                    Lưu bài viết
                </button>

                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {{ $news->content }}
                </div>

                <section class="mt-12 pt-8 border-t border-gray-200">
                    <h2 class="text-2xl font-semibold text-blue-700 mb-6">Bình luận ({{ $news->comments->count() }})</h2>

                    <form id="comment-form" method="POST" action="{{ route('comments.store', $news->id) }}" class="mb-8 p-4 bg-gray-50 rounded-lg shadow">
                        @csrf
                        <input id="reply-to-id" type="hidden" name="commentId">
                        <textarea id="comment-content" name="content" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150" rows="4" placeholder="Viết bình luận của bạn..." required></textarea>
                        <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition duration-150 ease-in-out">
                            Gửi bình luận
                        </button>
                    </form>

                    @if($news->comments && $news->comments->count() > 0)
                    <div class="space-y-6">

                        @foreach($news->comments as $comment)
                        <div class="p-4 bg-white rounded-lg shadow border border-gray-100">
                            <div class="flex items-start space-x-3">
                                <img src="{{ $comment->user->avatar_url ?? 'https://placehold.co/40x40/a0aec0/ffffff?text=User' }}" alt="Avatar của {{ $comment->user->name ?? 'Người dùng' }}" class="w-10 h-10 rounded-full">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-blue-600">{{ optional($comment->client)->fullName ?? 'Người dùng ẩẩn danh' }}</span>
                                        <span class="text-xs text-gray-400">{{ $comment->date?->diffForHumans() ?? 'Không rõ thời gian' }}</span>
                                    </div>
                                    <p class="text-gray-700 mt-1">{{ $comment->content }}</p>
                                    <div class="comment-actions flex items-center space-x-3 mt-3 text-sm text-gray-500">
                                        <button onclick="react('{{ $comment->id }}', 'like')" class="hover:text-blue-500 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V3a.75.75 0 0 1 .75-.75A2.25 2.25 0 0 1 16.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904M6.633 10.5l-1.07-1.07m1.07 1.07V15m0 0H3m3.75 0v4.5m0-4.5h.75m0 0V11.25m0 0h.75m0 0V15m0 0h.75M6.633 10.5c-.636 0-1.257.074-1.844.208M10.5 15.75a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5h-4.5Z" />
                                            </svg>
                                            Thích ({{ $comment->like_count ?? 0 }})
                                        </button>
                                        <button
                                            href="#comment-form"
                                            onclick="startReply('{{ $comment->id }}', '{{ optional($comment->client)->fullName }}')" class="hover:text-blue-500 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443h2.284M17.25 9.76c0-1.6-1.123-2.994-2.707-3.227A48.344 48.344 0 0 0 12 6.245c-1.108 0-2.206.086-3.293.245A3.228 3.228 0 0 0 6 9.756v3.006M21.75 12a9.75 9.75 0 1 1-19.5 0 9.75 9.75 0 0 1 19.5 0Z" />
                                            </svg>
                                            Phản hồi
                                        </button>
                                        <button onclick="react('{{ $comment->id }}', 'report')" class="hover:text-red-500 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                            </svg>
                                            Báo cáo
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @if($comment->replies && $comment->replies->count() > 0)
                            <div class="ml-10 mt-4 pl-4 border-l-2 border-blue-200 space-y-4">
                                @foreach($comment->replies->where('commentId', $comment->id) as $reply)
                                <div class="flex items-start space-x-3">
                                    <img src="{{ $reply->user->avatar_url ?? 'https://placehold.co/32x32/718096/ffffff?text=User' }}" alt="Avatar của {{ $reply->user->name ?? 'Người dùng' }}" class="w-8 h-8 rounded-full">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="font-semibold text-blue-500">{{ optional($reply->client)->fullName ?? 'Người dùng ẩẩn danh' }}</span>
                                            <span class="text-xs text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-600 mt-1 text-sm">{{ $reply->content }}</p>
                                        <div class="comment-actions flex items-center space-x-3 mt-2 text-xs text-gray-500">
                                            <button onclick="react('{{ $reply->id }}', 'like')" class="hover:text-blue-500 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V3a.75.75 0 0 1 .75-.75A2.25 2.25 0 0 1 16.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904M6.633 10.5l-1.07-1.07m1.07 1.07V15m0 0H3m3.75 0v4.5m0-4.5h.75m0 0V11.25m0 0h.75m0 0V15m0 0h.75M6.633 10.5c-.636 0-1.257.074-1.844.208M10.5 15.75a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5h-4.5Z" />
                                                </svg>
                                                Thích ({{ $reply->like_count }})
                                            </button>
                                            <button
                                                href="#comment-form"
                                                onclick="startReply('{{ $reply->id }}', '{{ optional($reply->client)->fullName }}')" class="hover:text-blue-500 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443h2.284M17.25 9.76c0-1.6-1.123-2.994-2.707-3.227A48.344 48.344 0 0 0 12 6.245c-1.108 0-2.206.086-3.293.245A3.228 3.228 0 0 0 6 9.756v3.006M21.75 12a9.75 9.75 0 1 1-19.5 0 9.75 9.75 0 0 1 19.5 0Z" />
                                                </svg>
                                                Phản hồi
                                            </button>
                                            <button onclick="react('{{ $reply->id }}', 'report')" class="hover:text-red-500 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                                </svg>
                                                Báo cáo
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                    @endif
                </section>
            </main>

            <aside class="w-full lg:w-1/3">
                <div class="sticky top-8">
                    <div class="bg-white rounded-lg shadow-lg p-6 latest-news-sidebar max-h-[calc(100vh-4rem)] overflow-y-auto">
                        <h2 class="text-xl font-semibold text-blue-700 mb-6 border-b pb-3">Tin tức mới nhất</h2>
                        <div class="space-y-5">
                            <a href="#" class="block group hover:bg-blue-50 p-3 rounded-md transition duration-150">
                                <div class="flex items-start space-x-3">
                                    <img src="https://placehold.co/80x80/3b82f6/ffffff?text=TN1" alt="Tin mới 1" class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                                    <div>
                                        <h3 class="text-md font-semibold text-gray-800 group-hover:text-blue-600 leading-tight">Đây là tiêu đề của một tin tức mới rất đáng chú ý</h3>
                                        <p class="text-xs text-gray-500 mt-1">15 phút trước</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="block group hover:bg-blue-50 p-3 rounded-md transition duration-150">
                                <div class="flex items-start space-x-3">
                                    <img src="https://placehold.co/80x80/10b981/ffffff?text=TN2" alt="Tin mới 2" class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                                    <div>
                                        <h3 class="text-md font-semibold text-gray-800 group-hover:text-blue-600 leading-tight">Một cập nhật quan trọng khác vừa được đăng tải</h3>
                                        <p class="text-xs text-gray-500 mt-1">45 phút trước</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="block group hover:bg-blue-50 p-3 rounded-md transition duration-150">
                                <div class="flex items-start space-x-3">
                                    <img src="https://placehold.co/80x80/f59e0b/ffffff?text=TN3" alt="Tin mới 3" class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                                    <div>
                                        <h3 class="text-md font-semibold text-gray-800 group-hover:text-blue-600 leading-tight">Khám phá những xu hướng công nghệ mới nhất năm 2025</h3>
                                        <p class="text-xs text-gray-500 mt-1">1 giờ trước</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="block group hover:bg-blue-50 p-3 rounded-md transition duration-150">
                                <div class="flex items-start space-x-3">
                                    <img src="https://placehold.co/80x80/ec4899/ffffff?text=TN4" alt="Tin mới 4" class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                                    <div>
                                        <h3 class="text-md font-semibold text-gray-800 group-hover:text-blue-600 leading-tight">Hướng dẫn chi tiết về phát triển ứng dụng di động</h3>
                                        <p class="text-xs text-gray-500 mt-1">2 giờ trước</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="block group hover:bg-blue-50 p-3 rounded-md transition duration-150">
                                <div class="flex items-start space-x-3">
                                    <img src="https://placehold.co/80x80/8b5cf6/ffffff?text=TN5" alt="Tin mới 5" class="w-16 h-16 object-cover rounded-md flex-shrink-0">
                                    <div>
                                        <h3 class="text-md font-semibold text-gray-800 group-hover:text-blue-600 leading-tight">Sự kiện công nghệ sắp diễn ra không thể bỏ lỡ</h3>
                                        <p class="text-xs text-gray-500 mt-1">3 giờ trước</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

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
                        wrapper.querySelector(`.${type}-count`).innerText = data[`${type}_count`];
                    }
                })
                .catch(() => alert(`Không thể ${type} bình luận.`));
        }
    </script>
</body>

</html>