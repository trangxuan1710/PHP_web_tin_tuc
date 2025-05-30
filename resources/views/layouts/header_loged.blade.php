@php
$client = Auth::user();
$notifications = $client->receivedNotifications()
->orderByDesc('created_at')
->get()
->map(function ($notification) {
return [
'id' => $notification->id,
'replierId' => $notification->replierId,
'replierName' => $notification->replierName,
'newsURL' => $notification->newsURL,
'content' => $notification->content,
'date' => $notification->created_at->format('Y-m-d H:i'),
'isRead' => $notification->isRead,
];
});
@endphp

<header class="bg-white shadow-md py-5 px-6  md:px-10 lg:px-14 flex space-x-8 items-center justify-between rounded-b-lg">
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
                    <path fill="#0d99ff" d="m12 5.69l5 4.5V18h-2v-6H9v6H7v-7.81zM12 3L2 12h3v8h6v-6h2v6h6v-8h3z" />
                </svg>
            </a>
            <div class="w-1/2 mx-8">
                <form action="{{ route('news.search') }}" method="GET" class="relative">
                    <input type="text"
                           name="q"
                           placeholder="Nhập từ khoá"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="{{ request('q') }}" >
                    <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="relative flex-shrink-0 flex items-center space-x-4 flex-1">
        <div class="relative">
            <button id="notification-bell"
                class="text-gray-600 hover:text-blue-600 transition-colors duration-200 p-2 rounded-full hover:bg-blue-50 relative"
                aria-label="Thông báo">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span id="notification-dot" class="absolute left-1/2 -bottom-0.5 -translate-x-1/2 w-2 h-2 bg-red-500 rounded-full border-2 border-white block"></span>
            </button>
            @php
            if (!function_exists('getMessages')) {
            function getMessages($replierName, $content) {
            if ($content === 'like') {
            return $replierName . ' đã thích bình luận của bạn.';
            } else {
            return $replierName . ' đã phản hồi bình luận của bạn.';
            }
            }
            }
            @endphp
            <div id="notification-dropdown-menu"
                class="hidden dropdown-menu absolute right-0 mt-3 w-64 bg-white border border-gray-200 rounded-md shadow-lg z-10 overflow-hidden">
                <div class="px-4 py-2 text-sm font-semibold text-gray-700 border-b border-gray-100">Thông báo mới</div>
                @forelse($notifications as $notification)
                <a href="{{ $notification->data['newsUrl'] ?? '#' }}"
                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 text-sm notification-item"
                    data-replier-name="{{ $notification['replierName'] ?? '' }}"
                    data-content="{{ $notification['content'] ?? '' }}">
                    <span class="font-bold font-sans">Thông báo</span>
                    <span class="notification-message">{{ getMessages($notification['replierName'], $notification['content']) }}</span>
                    <span class="block text-xs text-gray-500">
                        {{ $notification['date'] }}
                    </span>
                </a>
                @empty
                <div class="px-4 py-2 text-gray-500 text-sm">Không có thông báo mới.</div>
                @endforelse
                <a href="/user/profile"
                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 text-sm text-center border-t border-gray-100">
                    Xem tất cả
                </a>
            </div>
        </div>

        <div id="user-profile" class="flex items-center space-x-2 cursor-pointer" aria-haspopup="true"
            aria-expanded="false">
            <img src="{{ $client['avatarUrl'] }}" alt="Avatar người dùng"
                class="w-10 h-10 rounded-full border-2 border-blue-400 object-cover">
            <span class="font-regular font-sans text-gray-800 hidden md:block whitespace-nowrap">Chào, {{ $client['fullName'] }}!</span>
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>

                <div id="user-dropdown-menu"
                    class="hidden dropdown-menu absolute w-56 right-0 mt-4 bg-white border border-gray-200 rounded-md shadow-lg z-10 overflow-hidden">
                    <a href="/user/profile"
                        class="flex gap-3 px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="#4B5563" d="M12 2a5 5 0 1 0 5 5a5 5 0 0 0-5-5m0 8a3 3 0 1 1 3-3a3 3 0 0 1-3 3m9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z" />
                        </svg>Thông tin cá nhân</a>
                    <a href="/user/accountSettings"
                        class="flex gap-3 px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="#4B5563" d="M19.43 12.98c.04-.32.07-.64.07-.98s-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46a.5.5 0 0 0-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65A.49.49 0 0 0 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1a.6.6 0 0 0-.18-.03c-.17 0-.34.09-.43.25l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98s.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46a.5.5 0 0 0 .61.22l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1q.09.03.18.03c.17 0 .34-.09.43-.25l2-3.46c.12-.22.07-.49-.12-.64zm-1.98-1.71c.04.31.05.52.05.73s-.02.43-.05.73l-.14 1.13l.89.7l1.08.84l-.7 1.21l-1.27-.51l-1.04-.42l-.9.68c-.43.32-.84.56-1.25.73l-1.06.43l-.16 1.13l-.2 1.35h-1.4l-.19-1.35l-.16-1.13l-1.06-.43c-.43-.18-.83-.41-1.23-.71l-.91-.7l-1.06.43l-1.27.51l-.7-1.21l1.08-.84l.89-.7l-.14-1.13c-.03-.31-.05-.54-.05-.74s.02-.43.05-.73l.14-1.13l-.89-.7l-1.08-.84l.7-1.21l1.27.51l1.04.42l.9-.68c.43-.32.84-.56 1.25-.73l1.06-.43l.16-1.13l.2-1.35h1.39l.19 1.35l.16 1.13l1.06.43c.43.18.83.41 1.23.71l.91.7l1.06-.43l1.27-.51l.7 1.21l-1.07.85l-.89.7zM12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4s4-1.79 4-4s-1.79-4-4-4m0 6c-1.1 0-2-.9-2-2s.9-2 2-2s2 .9 2 2s-.9 2-2 2" />
                        </svg>Cài
                        đặt tài khoản</a>
                    <a href="/user/saveNews"
                        class="flex gap-3 px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="#4B5563" d="M14 5H6c-1.103 0-2 .897-2 2v16l6-3.601L16 23V7c0-1.103-.897-2-2-2m0 14.467l-4-2.399l-4 2.399V7h8z" />
                            <path fill="#4B5563" d="M18 1h-8c-1.103 0-2 .897-2 2h8c1.103 0 2 .897 2 2v10.443l2 2.489V3c0-1.103-.897-2-2-2" />
                        </svg>Tin
                        đã lưu</a>
                    <a href="/user/nearestNews"
                        class="flex gap-3 px-3 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1-4 0V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a3 3 0 0 0 3 3h11M8 8h4m-4 4h4m-4 4h4" />
                        </svg>Đã
                        xem gần đây</a>
                    <hr class="border-gray-200 my-1">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="flex gap-3 px-3 py-2 text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="#dc2626" d="M6 2h9a2 2 0 0 1 2 2v2h-2V4H6v16h9v-2h2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2" />
                            <path fill="#dc2626" d="M16.09 15.59L17.5 17l5-5l-5-5l-1.41 1.41L18.67 11H9v2h9.67z" />
                        </svg>Đăng xuất
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var notificationBell = document.getElementById('notification-bell');
        var notificationDot = document.getElementById('notification-dot');
        var hasUnread = true;

        // Dropdown toggle for user profile
        var userProfile = document.getElementById('user-profile');
        var userDropdown = document.getElementById('user-dropdown-menu');
        var notificationDropdownMenu = document.getElementById('notification-dropdown-menu');

        // Ẩn cả hai dropdown khi tải trang
        userDropdown.style.display = 'none';
        notificationDropdownMenu.style.display = 'none';

        notificationBell.addEventListener('click', function() {
            if (hasUnread) {
                notificationDot.style.display = 'none';
                hasUnread = false;
            }
        });

        userProfile.addEventListener('click', function(event) {
            event.stopPropagation();
            if (userDropdown.style.display === 'none') {
                userDropdown.style.display = 'block';
                notificationDropdownMenu.style.display = 'none';
            } else {
                userDropdown.style.display = 'none';
            }
        });

        notificationBell.addEventListener('click', function(event) {
            event.stopPropagation();
            if (notificationDropdownMenu.style.display === 'none') {
                notificationDropdownMenu.style.display = 'block';
                userDropdown.style.display = 'none';
            } else {
                notificationDropdownMenu.style.display = 'none';
            }
        });

        document.addEventListener('click', function(event) {
            if (!userProfile.contains(event.target)) {
                userDropdown.style.display = 'none';
                notificationDropdownMenu.style.display = 'none';
            }
        });
    });
</script>
