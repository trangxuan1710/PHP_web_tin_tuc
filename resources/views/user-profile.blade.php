<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS tùy chỉnh cho nút chỉnh sửa avatar */
        .avatar-edit-button {
            position: absolute;
            bottom: 0;
            right: 4px;
            /* Điều chỉnh vị trí để phù hợp với thiết kế */
            background-color: #3b82f6;
            /* blue-500 */
            color: white;
            border-radius: 9999px;
            /* bo tròn hoàn toàn */
            padding: 8px;
            /* p-2 */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            /* shadow-md */
            transition: background-color 0.2s ease-in-out;
            cursor: pointer;
        }

        .avatar-edit-button:hover {
            background-color: #2563eb;
            /* blue-600 khi hover */
        }
    </style>
</head>

<body class="min-h-screen bg-gray-100 font-sans text-gray-900 flex flex-col">

    @if(Auth::check())
    @include('layouts.header_loged')
    @else
    @include('layouts.header_notloged')
    @endif

    <div class="flex flex-1 py-8 px-2">
        <aside id="sidebar" class="w-full md:w-96 bg-white rounded-lg shadow-lg p-6 mr-6 flex-shrink-0 mb-6 md:mb-0">
            <div class="text-center mb-8">
                <div class="w-24 h-24 mx-auto rounded-full overflow-hidden flex items-center justify-center text-blue-800 text-4xl font-bold mb-4 border-4 border-blue-200">
                    <img id="sidebar-avatar" alt="User Avatar" class="w-full h-full object-cover" />
                </div>
                <h3 id="sidebar-user-name" class="text-xl font-semibold text-blue-800"></h3>
                <p id="sidebar-user-email" class="text-gray-600 text-sm"></p>
            </div>

            <nav>
                <ul>
                    <li class="mb-2">
                        <button id="tab-profile" class="w-full text-left px-4 py-3 rounded-md transition duration-200">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Thông tin cá nhân
                            </span>
                        </button>
                    </li>
                    <li class="mb-2">
                        <button id="tab-saveNews" class="w-full text-left px-4 py-3 rounded-md transition duration-200">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                </svg>
                                Tin tức đã lưu
                            </span>
                        </button>
                    </li>
                    <li class="mb-2">
                        <button id="tab-nearestNews" class="w-full text-left px-4 py-3 rounded-md transition duration-200">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1-4 0V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a3 3 0 0 0 3 3h11M8 8h4m-4 4h4m-4 4h4" />
                                </svg>
                                Đã xem gần đây
                            </span>
                        </button>
                    </li>
                    <li class="mb-2">
                        <button id="tab-accountSettings" class="w-full text-left px-4 py-3 rounded-md transition duration-200">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.562.344 1.25.626 2.182.5"></path>
                                </svg>
                                Cài đặt tài khoản
                            </span>
                        </button>
                    </li>
                    <li class="mt-auto pt-4 border-t border-gray-200">
                        <button id="btn-logout" class="w-full text-left px-4 py-3 rounded-md text-red-600 hover:bg-red-50 transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Đăng xuất
                        </button>
                    </li>
                </ul>
            </nav>
        </aside>

        <main id="main-content" class="flex-[2]"></main>
    </div>

    @include('layouts.footer')

    <!-- Modal đổi mật khẩu -->
    <div id="change-password-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button id="close-change-password-modal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
            <h2 class="text-xl font-semibold text-blue-800 mb-4">Đổi mật khẩu</h2>
            <form id="change-password-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu hiện tại</label>
                    <input type="password" id="current-password" name="current_password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới</label>
                    <input type="password" id="new-password" name="new_password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu mới</label>
                    <input type="password" id="confirm-password" name="confirm_password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                </div>
                <div id="change-password-error" class="text-red-600 text-sm"></div>
                <div id="change-password-success" class="text-green-600 text-sm"></div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" id="cancel-change-password-btn" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Hủy</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Đổi mật khẩu</button>
                </div>
            </form>
        </div>
    </div>

    <script id="notifications-data" type="application/json">
        @json($notifications ?? [])
    </script>
    <script id="saveNews-data" type="application/json">
        @json($saveNews ?? [])
    </script>
    <script id="nearestNews-data" type="application/json">
        @json($nearestNews ?? [])
    </script>

    <script>
        // Hàm tạo avatar mặc định từ tên
        function getDefaultAvatarUrl(name) {
            if (!name) return 'https://placehold.co/96x96/CCCCCC/333333?text=U';
            const initials = name
                .split(/\s+/)
                .filter(Boolean)
                .map(w => w[0] ? w[0].toUpperCase() : '')
                .join('');
            return `https://placehold.co/96x96/CCCCCC/333333?text=${encodeURIComponent(initials || 'U')}`;
        }

        // Các biến trạng thái toàn cục
        let user = {
            fullName: "{{ $client->fullName ?? 'null' }}",
            email: "{{ addslashes($client->email) ?? 'null' }}",
            bio: "{{ $client->bio ?? '' }}",
            avatarUrl: (function() {
                const url = "{{ $client->avatarUrl ?? '' }}";
                return url && url !== 'null' ? url : getDefaultAvatarUrl("{{ $client->fullName ?? 'null' }}");
            })()
        };

        let saveNews = JSON.parse(document.getElementById('saveNews-data').textContent);
        let nearestNews = JSON.parse(document.getElementById('nearestNews-data').textContent);
        let notifications = JSON.parse(document.getElementById('notifications-data').textContent);

        // Kiểm tra dữ liệu từ backend
        console.log('user:', user);
        console.log('saveNews:', saveNews);
        console.log('nearestNews', nearestNews);
        console.log('notifications:', notifications);

        let isEditing = false; // Trạng thái chỉnh sửa thông tin cá nhân
        let editedUser = {
            ...user
        }; // Sao chép đối tượng người dùng để chỉnh sửa

        let activeTab = 'profile';

        // Tham chiếu đến các phần tử DOM
        const sidebarAvatar = document.getElementById('sidebar-avatar');
        const sidebarUserName = document.getElementById('sidebar-user-name');
        const sidebarUserEmail = document.getElementById('sidebar-user-email');
        const mainContent = document.getElementById('main-content');

        const tabProfileBtn = document.getElementById('tab-profile');
        const tabSaveNewsBtn = document.getElementById('tab-saveNews');
        const tabNearestNewsBtn = document.getElementById('tab-nearestNews')
        const tabAccountSettingsBtn = document.getElementById('tab-accountSettings');
        const logoutBtn = document.getElementById('btn-logout');

        const newsPerPage = 6; // Số tin tức mỗi trang
        let currentPage = 1; // Trang hiện tại

        const notificationsPerPage = 5; // Số thông báo mỗi trang
        let currentNotificationPage = 1; // Trang thông báo hiện tại


        /**
         * Hiển thị nội dung chính dựa trên tab đang hoạt động.
         */
        function renderMainContent() {
            mainContent.innerHTML = ''; // Xóa nội dung cũ

            let contentHtml = '';
            if (activeTab === 'profile') {
                contentHtml = `
                <div class="flex flex-col md:flex-row gap-6 w-full">
                        <div class="flex-1">
                            ${renderProfileInfo()}
                        </div>
                        <div class="w-full md:w-80 flex-shrink-0">
                            ${renderNotificationsSidebar()}
                        </div>
                    </div>
                `;
            } else if (activeTab === 'saveNews') {
                contentHtml = renderNews(data = saveNews, isSaveNews = true);
            } else if (activeTab === 'accountSettings') {
                contentHtml = renderAccountSettings();
            } else if (activeTab === 'nearestNews') {
                contentHtml = renderNews(data = nearestNews, isSaveNews = false);
            }
            mainContent.innerHTML = contentHtml;
            // Gắn lại các trình nghe sự kiện sau khi render HTML mới
            attachEventListeners();
        }

        /**
         * Cập nhật giao diện sidebar.
         */
        function updateSidebar() {
            sidebarAvatar.src = user.avatarUrl;
            sidebarUserName.textContent = user.fullName;
            sidebarUserEmail.textContent = user.email;

            // Cập nhật kiểu dáng tab đang hoạt động
            tabProfileBtn.className = `w-full text-left px-4 py-3 rounded-md transition duration-200 ${
                activeTab === 'profile' ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-gray-50'
            }`;
            tabSaveNewsBtn.className = `w-full text-left px-4 py-3 rounded-md transition duration-200 ${
                activeTab === 'saveNews' ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-gray-50'
            }`;
            tabAccountSettingsBtn.className = `w-full text-left px-4 py-3 rounded-md transition duration-200 ${
                activeTab === 'accountSettings' ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-gray-50'
            }`;
            tabNearestNewsBtn.className = `w-full text-left px-4 py-3 rounded-md transition duration-200 ${
                activeTab === 'nearestNews' ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-gray-50'
            }`;
        }

        /**
         * Tạo HTML cho phần thông tin cá nhân.
         * @returns {string} Chuỗi HTML.
         */
        function renderProfileInfo() {
            return `
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold text-blue-800 mb-6 border-b pb-2">Thông tin cá nhân</h2>

                    <div class="flex items-center mb-6">
                        <div class="relative">
                            <img
                                id="profile-avatar-img"
                                src="${editedUser.avatarUrl}"
                                alt="User Avatar"
                                class="w-24 h-24 rounded-full object-cover mr-2 border-4 border-blue-200"
                            />
                            ${!isEditing ? '' : `
                            <button id="profile-avatar-edit-btn" class="avatar-edit-button">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <input type="file" id="avatarFileInput" accept="image/*" class="hidden" />
                            `}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên:</label>
                            ${isEditing ? `
                                <input
                                    type="text"
                                    id="nameInput"
                                    name="name"
                                    value="${editedUser.fullName}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                />
                            ` : `
                                <p class="text-gray-900 text-lg font-medium">${user.fullName}</p>
                            `}
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
                            ${isEditing ? `
                                <input
                                    type="email"
                                    id="emailInput"
                                    name="email"
                                    value="${editedUser.email}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                />
                            ` : `
                                <p class="text-gray-900 text-lg font-medium">${user.email}</p>
                            `}
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tiểu sử:</label>
                            ${isEditing ? `
                                <textarea
                                    id="bioInput"
                                    name="bio"
                                    value="${editedUser.bio}"
                                    rows="3"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                ></textarea>
                            ` : `
                                <p class="text-gray-900 text-lg font-medium">${user.bio}</p>
                            `}
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-4">
                        ${isEditing ? `
                            <button id="save-profile-btn" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                                Lưu thay đổi
                            </button>
                            <button id="cancel-edit-btn" class="px-6 py-2 bg-gray-300 text-gray-800 font-semibold rounded-md shadow-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                                Hủy
                            </button>
                        ` : `
                            <button id="edit-profile-btn" class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-md shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                                Chỉnh sửa
                            </button>
                        `}
                    </div>
                </div>
            `;
        }

        /**
         * Tạo HTML cho phần tin tức đã lưu.
         * @returns {string} Chuỗi HTML.
         */

        function renderNews(data, isSaveNews) {
            if (data.length === 0)
                if (isSaveNews) {
                    return `
                    <div class="p-6 bg-white rounded-lg shadow-md">
                        <h2 class="text-2xl font-semibold text-blue-800 mb-6 border-b pb-2">Tin tức đã lưu</h2>
                        <p class="text-gray-600 italic">Bạn chưa lưu tin tức nào.</p>
                    </div>
                `;
                }
            else return `
                    <div class="p-6 bg-white rounded-lg shadow-md">
                        <h2 class="text-2xl font-semibold text-blue-800 mb-6 border-b pb-2">Tin tức đã xem gần đây</h2>
                        <p class="text-gray-600 italic">Bạn chưa xem tin tức nào.</p>
                    </div>
                `;

            const totalPages = Math.ceil(data.length / newsPerPage);
            const startIndex = (currentPage - 1) * newsPerPage;
            const endIndex = startIndex + newsPerPage;
            const currentNews = data.slice(startIndex, endIndex);

            const newsCardsHtml = currentNews.map(news => `
                <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                    <img src="${news.thumbnail}" alt="Thumbnail" class="w-full h-44 object-cover rounded-t-lg" onerror="this.onerror=null;this.src='https://placehold.co/600x200/cccccc/333333?text=No+Image';" />
                    <div class="p-4 flex-1">
                        <h3 class="text-xl font-semibold text-blue-700 mb-2">
                            <a href="${news.url}" target="_blank" rel="noopener noreferrer" class="hover:underline">
                                ${news.title}
                            </a>    
                        </h3>
                        <p class="text-gray-600 text-xs">Lưu ngày: ${news.date}</p>
                    </div>
                    <div class="flex justify-between items-center p-4 border-t border-gray-200">
                        <button data-url="" class="news-read-more-btn px-4 py-2 bg-blue-500 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.747 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span>Đọc tiếp</span>
                        </button>
                        <button data-id="${news.id}" data-title="${news.title}" class="news-delete-btn p-2 text-red-600 rounded-full hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `).join('');

            let paginationHtml = '';
            if (totalPages > 1) {
                paginationHtml = `
                    <div class="flex justify-center items-center space-x-2 mt-6">
                        <button id="prev-page-btn" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}" ${currentPage === 1 ? 'disabled' : ''}>
                            Trước
                        </button>
                        ${Array.from({ length: totalPages }, (_, i) => i + 1).map(page => ` <
                    button data - page = "${page}"
                class = "page-number-btn px-4 py-2 rounded-md shadow-sm ${
                page === currentPage ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
            }
            ">
            $ {
                page
            } <
            /button>
            `).join('')}
                        <button id="next-page-btn" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 ${currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : ''}" ${currentPage === totalPages ? 'disabled' : ''}>
                            Sau
                        </button>
                    </div>
                `;
        }

        return `
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold text-blue-800 mb-6 border-b pb-2">Tin tức đã lưu</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        ${newsCardsHtml}
                    </div>
                    ${paginationHtml}
                </div>
            `;
        }

        function getNotificationMessages(notification) {
            if (notification.content == 'like') {
                return `${notification.replierName} đã thích bình luận của bạn.`;
            } else {
                return `${notification.replierName} đã phản hồi binh luận của bạn.`;
            }
        }


        /**
         * Tạo HTML cho phần thông báo.
         * @returns {string} Chuỗi HTML.
         */
        function renderNotificationsSidebar() {
            // Nếu notifications là null hoặc không phải mảng, hiển thị thông báo không có thông báo nào
            if (notifications == null) {
                return `
                    <div class="p-6 bg-white rounded-lg shadow-md h-full flex flex-col">
                        <h2 class="text-xl font-semibold text-blue-800 mb-4 border-b pb-2">
                            Thông báo (0)
                        </h2>
                        <p class="text-gray-600 italic text-sm text-center">Không có thông báo nào.</p>
                    </div>
                `;
            }

            const readNotificationsCount = notifications.filter(n => n.isRead).length;
            const totalNotifications = notifications.length;

            const totalNotificationPages = Math.ceil(totalNotifications / notificationsPerPage);
            const startNotificationIndex = (currentNotificationPage - 1) * notificationsPerPage;
            const endNotificationIndex = startNotificationIndex + notificationsPerPage;
            const currentNotifications = notifications.slice(startNotificationIndex, endNotificationIndex);

            let notificationsListHtml = '';
            if (currentNotifications.length === 0) {
                notificationsListHtml = `
                    <p class="text-gray-600 italic text-sm text-center">Không có thông báo nào</p>
                `;
            } else {
                notificationsListHtml = currentNotifications.map(notification => `
                    <div data-id="${notification.id}" class="notification-item border border-gray-200 rounded-lg p-3 ${
                        notification.isRead? 'bg-gray-50' : 'bg-blue-50 font-medium'
                    } hover:shadow-sm transition duration-200 cursor-pointer text-sm flex items-center justify-between">
                        <div>
                            <p class="text-gray-900 mb-1">${getNotificationMessages(notification)}</p>
                            <p class="text-gray-500 text-xs">Ngày: ${notification.date}</p>
                        </div>
                        ${notification.isRead? `
                            <button data-id="${notification.id}" class="delete-notification-btn p-1 text-red-600 rounded-full hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 ml-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        ` : ''}
                    </div>
                `).join('');
            }


            let paginationHtml = '';
            if (totalNotificationPages > 1) {
                paginationHtml = `
                    <div class="flex justify-center items-center space-x-1 mt-4 text-xs">
                        <button id="prev-notification-page-btn" class="px-2 py-1 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 ${window.currentNotificationPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}" ${window.currentNotificationPage === 1 ? 'disabled' : ''}>
                            Trước
                        </button>
                        ${Array.from({ length: totalNotificationPages }, (_, i) => i + 1).map(page => ` <
                    button data - page = "${page}"
                class = "notification-page-number-btn px-2 py-1 rounded-md shadow-sm ${
                page === currentNotificationPage ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
            }
            ">
            $ {
                page
            } <
            /button>
            `).join('')}
                        <button id="next-notification-page-btn" class="px-2 py-1 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600 ${window.currentNotificationPage === totalNotificationPages ? 'opacity-50 cursor-not-allowed' : ''}" ${window.currentNotificationPage === totalNotificationPages ? 'disabled' : ''}>
                            Sau
                        </button>
                    </div>
                `;
        }


        return `
                <div class="p-6 bg-white rounded-lg shadow-md h-full flex flex-col">
                    <h2 class="text-xl font-semibold text-blue-800 mb-4 border-b pb-2">
                        Thông báo (${totalNotifications})
                    </h2>
                    <div class="flex flex-wrap gap-2 mb-4">
                        ${readNotificationsCount > 0 ? `
                            <button id="delete-all-read-notifications-btn" class="px-4 py-2 bg-red-500 text-white font-semibold rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200 text-sm flex-1">
                                Xóa tất cả đã đọc (${readNotificationsCount})
                            </button>
                        ` : ''}
                        ${(totalNotifications - readNotificationsCount) > 0 ? `
                            <button id="mark-all-as-read-btn" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 text-sm flex-1">
                                Đánh dấu tất cả là đã đọc
                            </button>
                        ` : ''}
                    </div>
                    <div class="space-y-2 flex-grow overflow-y-auto pr-2">
                        ${notificationsListHtml}
                    </div>
                    ${paginationHtml}
                </div>
            `;
        }

        function renderAccountSettings() {
            return `
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold text-blue-800 mb-6 border-b pb-2">Cài đặt tài khoản</h2>
                    <div class="space-y-4">
                        <p class="text-gray-700">Tại đây bạn có thể quản lý các cài đặt liên quan đến tài khoản của mình.</p>
                        <button id="change-password-btn" class="px-6 py-2 bg-gray-600 text-white font-semibold rounded-md shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                            Đổi mật khẩu
                        </button>
                        </div>
                </div>
            `;
        }

        const csrfToken = "{{ csrf_token() }}";


        async function updateProfile(data) {
            try {
                const updateUrl = "{{ route('api.profile.update', ['id' => $client->id]) }}";

                // Gửi yêu cầu Fetch và chờ phản hồi
                const response = await fetch(updateUrl, {
                    method: 'PUT', // Hoặc 'PATCH' tùy theo route của bạn
                    headers: {
                        'Content-Type': 'application/json', // Báo cho server biết bạn gửi JSON
                        'X-CSRF-TOKEN': csrfToken, // Gửi CSRF token
                        'Accept': 'application/json', // Chấp nhận phản hồi JSON
                    },
                    body: JSON.stringify(data), // Chuyển đổi đối tượng JS thành chuỗi JSON
                });

                // Kiểm tra xem phản hồi có thành công không (status 2xx)
                if (!response.ok) {
                    // Nếu phản hồi không OK, cố gắng phân tích lỗi từ JSON
                    const errorData = await response.json();

                    // Xử lý lỗi xác thực (HTTP Status 422)
                    if (response.status === 422) {
                        if (typeof displayValidationErrors === 'function') {
                            displayValidationErrors(errorData.errors); // Gọi hàm hiển thị lỗi xác thực
                        } else {
                            console.error('Lỗi xác thực:', errorData.errors);
                        }
                        // Ném lỗi để khối catch bên ngoài bắt được
                        throw new Error('Lỗi xác thực dữ liệu.');
                    } else {
                        // Xử lý các lỗi HTTP khác (401, 403, 404, 500, v.v.)
                        // Ném lỗi để khối catch bên ngoài bắt được
                        throw new Error(errorData.message || 'Có lỗi xảy ra.');
                    }
                }

                // Nếu phản hồi OK, phân tích dữ liệu JSON thành công
                const responseData = await response.json();

                // Hiển thị thông báo thành công trong console
                if (responseData.message) {
                    console.log('Thành công:', responseData.message);
                } else {
                    console.log('Thành công: Cập nhật thông tin thành công!');
                }
                console.log('Dữ liệu mới nhận được:', responseData.client);

                // Cập nhật giao diện người dùng với dữ liệu mới nhận được
                if (responseData.client) {
                    // Đảm bảo các hàm này đã được định nghĩa và có sẵn trong phạm vi
                    if (typeof updateSidebar === 'function') {
                        updateSidebar(); // Truyền dữ liệu client mới nếu hàm cần
                    }
                    if (typeof renderMainContent === 'function') {
                        renderMainContent(); // Truyền dữ liệu client mới nếu hàm cần
                    }
                }

            } catch (error) {
                // Bắt tất cả các lỗi xảy ra trong khối try (lỗi mạng, lỗi throw từ if (!response.ok))
                console.error('Lỗi khi cập nhật thông tin:', error.message);
                // Hiển thị lỗi trong giao diện người dùng nếu cần (ví dụ: dùng alert hoặc một div thông báo)
                alert(`Lỗi: ${error.message}`);
            }
        }

        function displayValidationErrors(errors) {
            console.error('Lỗi xác thực: Vui lòng kiểm tra lại thông tin nhập vào.');
            for (const field in errors) {
                if (errors.hasOwnProperty(field)) {
                    // In từng lỗi xác thực ra console
                    console.error(`- Trường "${field}": ${errors[field][0]}`);
                }
            }
        }


        async function readNotifications(id = null) {
            console.log(id);
            try {
                const updateUrl = "{{ route('api.notifications.read', ['id' => $client->id]) }}";

                const response = await fetch(updateUrl, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        id: id
                    }),
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Có lỗi xảy ra khi cập nhật thông báo.');
                }

                const responseData = await response.json();
                console.log('Thông báo đã được cập nhật:', responseData);

            } catch (error) {
                console.error('Lỗi khi cập nhật thông báo:', error.message);
            }
        }

        async function deleteNotifications(notificationId = null) {
            if (notificationId != null) {
                if (!confirm(`Bạn có chắc chắn muốn xóa thông báo ID ${notificationId} không?`)) {
                    return; // Người dùng đã hủy
                }

                try {
                    // URL API để xóa thông báo
                    const deleteUrl = "{{ route('api.notifications.delete', ['id' => $client->id]) }}";

                    const response = await fetch(deleteUrl, {
                        method: 'DELETE', // Sử dụng phương thức DELETE
                        headers: {
                            'X-CSRF-TOKEN': csrfToken, // Gửi CSRF token
                            'Accept': 'application/json', // Chấp nhận phản hồi JSON
                        },
                        body: JSON.stringify({
                            id: notificationId
                        }), // Gửi ID thông báo cần xóa
                    });

                    const data = await response.json(); // Phân tích phản hồi JSON

                    if (response.ok) { // Mã trạng thái 2xx (ví dụ: 200 OK, 204 No Content)
                        console.log(`Thông báo ID: ${notificationId} đã bị xóa.`);

                    } else { // Mã trạng thái lỗi (4xx, 5xx)
                        console.error('Lỗi khi xóa thông báo:', data.message || 'Đã xảy ra lỗi không xác định.');
                    }

                } catch (error) {
                    console.error('Lỗi mạng hoặc server:', error);
                }
            } else {
                if (!confirm('Bạn có chắc chắn muốn xóa tất cả thông báo không?')) {
                    return; // Người dùng đã hủy
                }

                try {
                    // URL API để xóa thông báo
                    const deleteUrl = "{{ route('api.notifications.delete', ['id' => $client->id]) }}";

                    const response = await fetch(deleteUrl, {
                        method: 'DELETE', // Sử dụng phương thức DELETE
                        headers: {
                            'X-CSRF-TOKEN': csrfToken, // Gửi CSRF token
                            'Accept': 'application/json', // Chấp nhận phản hồi JSON
                        },
                    });

                    const data = await response.json(); // Phân tích phản hồi JSON

                    if (response.ok) { // Mã trạng thái 2xx (ví dụ: 200 OK, 204 No Content)
                        console.log(`Tất cả thông báo đã bị xóa.`);
                    } else { // Mã trạng thái lỗi (4xx, 5xx)
                        console.error('Lỗi khi xóa thông báo:', data.message || 'Đã xảy ra lỗi không xác định.');
                    }

                } catch (error) {
                    console.error('Lỗi mạng hoặc server:', error);
                }
            }
        }

        async function deleteAllNotifications() {
            if (!confirm('Bạn có chắc chắn muốn xóa tất cả thông báo đã đọc không?')) {
                return; // Người dùng đã hủy
            }

            try {
                // URL API để xóa tất cả thông báo đã đọc
                const deleteUrl = `/api/notifications/delete-all`;

                const response = await fetch(deleteUrl, {
                    method: 'DELETE', // Sử dụng phương thức DELETE
                    headers: {
                        'X-CSRF-TOKEN': csrfToken, // Gửi CSRF token
                        'Accept': 'application/json', // Chấp nhận phản hồi JSON
                    },
                });

                const data = await response.json(); // Phân tích phản hồi JSON

                if (response.ok) { // Mã trạng thái 2xx (ví dụ: 200 OK, 204 No Content)
                    notifications = notifications.filter(n => !n.read); // Giữ lại chỉ các thông báo chưa đọc
                    // Điều chỉnh trang hiện tại nếu trang đó trở nên trống
                    const totalNotificationsAfterDelete = notifications.length;
                    const totalNotificationPagesAfterDelete = Math.ceil(totalNotificationsAfterDelete / notificationsPerPage);
                    if (currentNotificationPage > totalNotificationPagesAfterDelete && totalNotificationPagesAfterDelete > 0) {
                        currentNotificationPage = totalNotificationPagesAfterDelete;
                    } else if (totalNotificationPagesAfterDelete === 0) {
                        currentNotificationPage = 1; // Về trang 1 nếu không còn thông báo
                    }
                    renderMainContent();
                    console.log(`Tất cả thông báo đã đọc đã bị xóa.`);
                } else { // Mã trạng thái lỗi (4xx, 5xx)
                    console.error('Lỗi khi xóa thông báo:', data.message || 'Đã xảy ra lỗi không xác định.');
                }

            } catch (error) {
                console.error('Lỗi mạng hoặc server:', error);
            }
        }

        // Hiển thị và ẩn modal đổi mật khẩu
        function showChangePasswordModal() {
            document.getElementById('change-password-modal').classList.remove('hidden');
            document.getElementById('change-password-form').reset();
            document.getElementById('change-password-error').textContent = '';
            document.getElementById('change-password-success').textContent = '';
        }

        function hideChangePasswordModal() {
            document.getElementById('change-password-modal').classList.add('hidden');
        }

        /**
         * Gắn tất cả các trình nghe sự kiện động sau khi nội dung được render.
         */
        function attachEventListeners() {

            // Nút tab Thông tin cá nhân
            const editProfileBtn = document.getElementById('edit-profile-btn');
            const saveProfileBtn = document.getElementById('save-profile-btn');
            const cancelEditBtn = document.getElementById('cancel-edit-btn');
            const changePasswordBtn = document.getElementById('change-password-btn');
            const changePasswordModal = document.getElementById('change-password-modal'); // Modal đổi mật khẩu
            const profileAvatarEditBtn = document.getElementById('profile-avatar-edit-btn'); // Nút icon bút chì
            const avatarFileInput = document.getElementById('avatarFileInput'); // Input file mới

            if (editProfileBtn) {
                editProfileBtn.onclick = () => {
                    isEditing = true;
                    editedUser = {
                        ...user
                    }; // Đặt lại editedUser về trạng thái người dùng hiện tại
                    renderMainContent();
                };
            }
            if (saveProfileBtn) {
                saveProfileBtn.onclick = () => {

                    if (editedUser.avatarUrl == getDefaultAvatarUrl(user.fullName)) {
                        editedUser.avatarUrl = getDefaultAvatarUrl(editedUser.fullName);
                    }

                    user = {
                        ...editedUser
                    }; // Cập nhật người dùng với dữ liệu đã chỉnh sửa

                    isEditing = false;
                    updateProfile(user); // Gọi hàm cập nhật thông tin người dùng
                    console.log('Thông tin người dùng đã được lưu:', user);
                };
            }
            if (cancelEditBtn) {
                cancelEditBtn.onclick = () => {
                    isEditing = false;
                    editedUser = {
                        ...user
                    }; // Khôi phục editedUser về trạng thái người dùng ban đầu
                    renderMainContent();
                };
            }
            if (changePasswordBtn) {
                changePasswordBtn.onclick = () => {
                    showChangePasswordModal();
                };
            }
            if (profileAvatarEditBtn && avatarFileInput) {
                profileAvatarEditBtn.onclick = () => {
                    avatarFileInput.click(); // Kích hoạt input file ẩn
                };
            }
            if (avatarFileInput) {
                avatarFileInput.onchange = (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            editedUser.avatarUrl = event.target.result; // Cập nhật avatarUrl với chuỗi base64
                            document.getElementById('profile-avatar-img').src = event.target.result; // Cập nhật ảnh xem trước ngay lập tức
                        };
                        reader.readAsDataURL(file); // Đọc tệp dưới dạng Data URL (base64)
                    }
                };
            }

            // Xử lý thay đổi trường nhập liệu cho hồ sơ
            const nameInput = document.getElementById('nameInput');
            const emailInput = document.getElementById('emailInput');
            const bioInput = document.getElementById('bioInput');

            if (nameInput) {
                nameInput.oninput = (e) => {
                    editedUser.fullName = e.target.value;
                };
            }
            if (emailInput) {
                emailInput.oninput = (e) => {
                    editedUser.email = e.target.value;
                };
            }
            if (bioInput) {
                bioInput.oninput = (e) => {
                    editedUser.bio = e.target.value;
                };
            }

            const prevPageBtn = document.getElementById('prev-page-btn');
            const nextPageBtn = document.getElementById('next-page-btn');
            if (prevPageBtn) {
                prevPageBtn.onclick = () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderMainContent();
                    }
                };
            }
            if (nextPageBtn) {
                const totalPages = Math.ceil(saveNews.length / newsPerPage);
                nextPageBtn.onclick = () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderMainContent();
                    }
                };
            }
            document.querySelectorAll('.page-number-btn').forEach(button => {
                button.onclick = (e) => {
                    const page = parseInt(e.currentTarget.dataset.page);
                    if (page !== currentPage) {
                        currentPage = page;
                        renderMainContent();
                    }
                };
            });

            // Nút Tin tức đã lưu
            document.querySelectorAll('.news-read-more-btn').forEach(button => {
                button.onclick = (e) => {
                    const url = e.currentTarget.dataset.url;
                    window.open(url, '_blank');
                };
            });
            document.querySelectorAll('.news-delete-btn').forEach(button => {
                button.onclick = (e) => {
                    const id = parseInt(e.currentTarget.dataset.id);
                    const title = e.currentTarget.dataset.title;
                    if (confirm(`Bạn có chắc chắn muốn xóa tin tức "${title}"?`)) { // Sử dụng confirm theo hướng dẫn, nhưng sẽ dùng modal tùy chỉnh trong ứng dụng thực tế
                        saveNews = saveNews.filter(item => item.id !== id);
                        renderMainContent(); // Render lại tin tức đã lưu
                        console.log(`Tin tức "${title}" đã bị xóa.`);
                    }
                };
            });

            document.querySelectorAll('.notification-item').forEach(item => {
                item.onclick = (e) => {
                    // Chỉ đánh dấu là đọc nếu thông báo chưa đọc và click không phải vào nút xóa
                    if (!e.currentTarget.classList.contains('bg-gray-50') && !e.target.closest('.delete-notification-btn')) {
                        const id = parseInt(e.currentTarget.dataset.id);
                        notifications = notifications.map(n =>
                            n.id === id ? {
                                ...n,
                                isRead: true
                            } : n
                        );
                        readNotifications(id); // Cập nhật trạng thái đã đọc trên server
                        renderMainContent();
                        console.log(`Thông báo ID: ${id} đã được đọc.`);
                    }
                };
            });

            // Xóa một thông báo đã đọc
            document.querySelectorAll('.delete-notification-btn').forEach(button => {
                button.onclick = (e) => {
                    e.stopPropagation(); // Ngăn chặn sự kiện click của item cha (đánh dấu đã đọc)
                    const idToDelete = parseInt(e.currentTarget.dataset.id);
                    deleteNotifications(idToDelete); // Gọi hàm xóa thông báo
                    notifications = notifications.filter(n => n.id !== idToDelete);
                    // Điều chỉnh trang hiện tại nếu trang đó trở nên trống
                    const totalNotificationsAfterDelete = notifications.length;
                    const totalNotificationPagesAfterDelete = Math.ceil(totalNotificationsAfterDelete / notificationsPerPage);
                    if (currentNotificationPage > totalNotificationPagesAfterDelete && totalNotificationPagesAfterDelete > 0) {
                        currentNotificationPage = totalNotificationPagesAfterDelete;
                    } else if (totalNotificationPagesAfterDelete === 0) {
                        currentNotificationPage = 1; // Về trang 1 nếu không còn thông báo
                    }
                    renderMainContent();
                };
            });

            // Xóa tất cả thông báo đã đọc
            const deleteAllReadNotificationsBtn = document.getElementById('delete-all-read-notifications-btn');
            if (deleteAllReadNotificationsBtn) {
                deleteAllReadNotificationsBtn.onclick = () => {
                    deleteNotifications();
                    notifications = notifications.filter(n => !n.isRead); // Giữ lại chỉ các thông báo chưa đọc
                    // Điều chỉnh trang hiện tại nếu trang đó trở nên trống
                    const totalNotificationsAfterDelete = notifications.length;
                    const totalNotificationPagesAfterDelete = Math.ceil(totalNotificationsAfterDelete / notificationsPerPage);
                    if (currentNotificationPage > totalNotificationPagesAfterDelete && totalNotificationPagesAfterDelete > 0) {
                        currentNotificationPage = totalNotificationPagesAfterDelete;
                    } else if (totalNotificationPagesAfterDelete === 0) {
                        currentNotificationPage = 1; // Về trang 1 nếu không còn thông báo
                    }
                    renderMainContent();
                    console.log(`Tất cả thông báo đã đọc đã bị xóa.`);
                };
            }

            // Đánh dấu tất cả là đã đọc
            const markAllAsReadBtn = document.getElementById('mark-all-as-read-btn');
            if (markAllAsReadBtn) {
                markAllAsReadBtn.onclick = () => {
                    notifications = notifications.map(n => ({
                        ...n,
                        read: true
                    }));
                    readNotifications(); // Cập nhật trạng thái đã đọc trên server
                    renderMainContent();
                    console.log('Tất cả thông báo đã được đánh dấu là đã đọc.');
                };
            }

            // Nút phân trang thông báo: Trước
            const prevNotificationPageBtn = document.getElementById('prev-notification-page-btn');
            if (prevNotificationPageBtn) {
                prevNotificationPageBtn.onclick = () => {
                    if (currentNotificationPage > 1) {
                        currentNotificationPage--;
                        renderMainContent();
                    }
                };
            }

            // Nút phân trang thông báo: Sau
            const nextNotificationPageBtn = document.getElementById('next-notification-page-btn');
            if (nextNotificationPageBtn) {
                const totalNotificationPages = Math.ceil(notifications.length / notificationsPerPage);
                nextNotificationPageBtn.onclick = () => {
                    if (currentNotificationPage < totalNotificationPages) {
                        currentNotificationPage++;
                        renderMainContent();
                    }
                };
            }

            // Nút số trang thông báo
            document.querySelectorAll('.notification-page-number-btn').forEach(button => {
                button.onclick = (e) => {
                    const page = parseInt(e.currentTarget.dataset.page);
                    currentNotificationPage = page;
                    renderMainContent();
                };
            });
        }

        /**
         * Khởi tạo ứng dụng khi trang tải.
         */
        document.addEventListener('DOMContentLoaded', () => {
            // Render ban đầu của sidebar và nội dung chính
            updateSidebar();
            renderMainContent();

            // Gắn trình nghe sự kiện cho việc chuyển đổi tab
            tabProfileBtn.addEventListener('click', () => {
                activeTab = 'profile';
                isEditing = false; // Đặt lại chế độ chỉnh sửa khi chuyển tab
                editedUser = {
                    ...user
                }; // Đặt lại dữ liệu người dùng đã chỉnh sửa
                updateSidebar();
                renderMainContent();
            });
            tabSaveNewsBtn.addEventListener('click', () => {
                activeTab = 'saveNews';
                isEditing = false; // Đặt lại chế độ chỉnh sửa khi chuyển tab
                updateSidebar();
                renderMainContent();
            });
            tabNearestNewsBtn.addEventListener('click', () => {
                activeTab = 'nearestNews';
                isEditing = false; // Đặt lại chế độ chỉnh sửa khi chuyển tab
                updateSidebar();
                renderMainContent();
            });
            tabAccountSettingsBtn.addEventListener('click', () => {
                activeTab = 'accountSettings';
                isEditing = false; // Đặt lại chế độ chỉnh sửa khi chuyển tab
                updateSidebar();
                renderMainContent();
            });
            logoutBtn.addEventListener('click', () => {
                console.log('Đăng xuất');
                // Trong một ứng dụng thực tế, điều này sẽ xử lý logic đăng xuất
            });

            // Modal đổi mật khẩu
            document.getElementById('close-change-password-modal').onclick = hideChangePasswordModal;
            document.getElementById('cancel-change-password-btn').onclick = hideChangePasswordModal;

            document.getElementById('change-password-form').onsubmit = async function(e) {
                e.preventDefault();
                const errorDiv = document.getElementById('change-password-error');
                const successDiv = document.getElementById('change-password-success');
                errorDiv.textContent = '';
                successDiv.textContent = '';

                const currentPassword = document.getElementById('current-password').value.trim();
                const newPassword = document.getElementById('new-password').value.trim();
                const confirmPassword = document.getElementById('confirm-password').value.trim();

                if (!currentPassword || !newPassword || !confirmPassword) {
                    errorDiv.textContent = 'Vui lòng nhập đầy đủ thông tin.';
                    return;
                }
                if (newPassword.length < 6) {
                    errorDiv.textContent = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
                    return;
                }
                if (newPassword !== confirmPassword) {
                    errorDiv.textContent = 'Mật khẩu xác nhận không khớp.';
                    return;
                }

                try {
                    const url = "{{ route('profile.changePassword', ['id' => $client->id]) }}";
                    const res = await fetch(url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            currentPassword: currentPassword,
                            newPassword: newPassword,
                            newPassword_confirmation: confirmPassword
                        })
                    });
                    const data = await res.json();
                    if (res.ok) {
                        successDiv.textContent = data.message || 'Đổi mật khẩu thành công!';
                        setTimeout(hideChangePasswordModal, 1200);
                    } else {
                        errorDiv.textContent = data.message || 'Đổi mật khẩu thất bại.';
                    }
                } catch (err) {
                    errorDiv.textContent = 'Có lỗi xảy ra. Vui lòng thử lại.';
                }
            };
        });
    </script>
</body>


</html>