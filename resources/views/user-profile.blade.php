<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="asset('css/app.css')" rel="stylesheet">
    <style>
        /* CSS tùy chỉnh cho nút chỉnh sửa avatar */
        .avatar-edit-button {
            position: absolute;
            bottom: 0;
            right: 4px; /* Điều chỉnh vị trí để phù hợp với thiết kế */
            background-color: #3b82f6; /* blue-500 */
            color: white;
            border-radius: 9999px; /* bo tròn hoàn toàn */
            padding: 8px; /* p-2 */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-md */
            transition: background-color 0.2s ease-in-out;
            cursor: pointer;
        }
        .avatar-edit-button:hover {
            background-color: #2563eb; /* blue-600 khi hover */
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
                    <img id="sidebar-avatar" src="" alt="User Avatar" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='https://placehold.co/96x96/CCCCCC/333333?text=Error';" />
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
                        <button id="tab-savedNews" class="w-full text-left px-4 py-3 rounded-md transition duration-200">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                </svg>
                                Tin tức đã lưu
                            </span>
                        </button>
                    </li>
                    <li class="mb-2">
                        <button id="tab-notifications" class="w-full text-left px-4 py-3 rounded-md transition duration-200">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                Thông báo
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

    <script>
        // Các biến trạng thái toàn cục
        let user = {
            name: 'Nguyễn Văn A',
            email: 'nguyenvana@example.com',
            bio: 'Yêu thích đọc tin tức công nghệ và kinh tế.',
            avatarUrl: 'https://placehold.co/96x96/ADD8E6/000000?text=AVATAR',
        };

        let savedNews = [
            {
                id: 1,
                category: 'AI News',
                title: 'Tin tức công nghệ mới nhất về AI',
                date: '2023-10-26',
                summary: 'Tổng hợp các phát triển đột phá trong lĩnh vực trí tuệ nhân tạo và ứng dụng của chúng trong đời sống.',
                url: '#',
                thumbnail: 'https://placehold.co/600x200/3b82f6/ffffff?text=AI+News',
            },
            {
                id: 2,
                category: 'Thị trường',
                title: 'Phân tích thị trường chứng khoán cuối năm',
                date: '2023-10-25',
                summary: 'Cái nhìn sâu sắc về xu hướng và dự báo thị trường chứng khoán trong quý cuối năm.',
                url: '#',
                thumbnail: 'https://placehold.co/600x200/16a34a/ffffff?text=Thị+trường',
            },
            {
                id: 3,
                category: 'Ẩm thực',
                title: 'Khám phá ẩm thực đường phố Hà Nội',
                date: '2023-10-24',
                summary: 'Những món ăn không thể bỏ qua khi đến thủ đô Hà Nội.',
                url: '#',
                thumbnail: 'https://placehold.co/600x200/f59e42/ffffff?text=Ẩm+thực',
            },
            {
                id: 4,
                category: 'Du lịch',
                title: 'Top 5 điểm đến hấp dẫn tại Việt Nam năm 2023',
                date: '2023-10-23',
                summary: 'Khám phá những địa điểm du lịch nổi bật không thể bỏ lỡ.',
                url: '#',
                thumbnail: 'https://placehold.co/600x200/0ea5e9/ffffff?text=Du+lịch',
            },
            {
                id: 5,
                category: 'Giáo dục',
                title: 'Xu hướng học trực tuyến sau đại dịch',
                date: '2023-10-22',
                summary: 'Phân tích sự phát triển của các nền tảng học trực tuyến tại Việt Nam.',
                url: '#',
                thumbnail: 'https://placehold.co/600x200/6366f1/ffffff?text=Giáo+dục',
            },
            {
                id: 6,
                category: 'Thể thao',
                title: 'Việt Nam giành chiến thắng tại SEA Games',
                date: '2023-10-21',
                summary: 'Những khoảnh khắc đáng nhớ của đoàn thể thao Việt Nam.',
                url: '#',
                thumbnail: 'https://placehold.co/600x200/f43f5e/ffffff?text=Thể+thao',
            },
            {
                id: 7,
                category: 'Sức khỏe',
                title: 'Bí quyết sống khỏe mỗi ngày',
                date: '2023-10-20',
                summary: 'Những lời khuyên hữu ích giúp bạn duy trì sức khỏe tốt.',
                url: '#',
                thumbnail: 'https://placehold.co/600x200/22d3ee/ffffff?text=Sức+khỏe',
            },
        ];

        let notifications = [
            {
                id: 1,
                message: 'Có tin tức mới về Trí tuệ nhân tạo.',
                date: '2023-10-26 10:30',
                read: false,
            },
            {
                id: 2,
                message: 'Tài khoản của bạn đã được cập nhật thông tin.',
                date: '2023-10-25 15:00',
                read: true,
            },
            {
                id: 3,
                message: 'Bạn có 5 tin tức mới chưa đọc trong mục "Kinh tế".',
                date: '2023-10-24 08:00',
                read: false,
            },
        ];

        let activeTab = 'profile';
        let isEditing = false;
        let editedUser = { ...user }; // Sao chép dữ liệu người dùng để chỉnh sửa

        // Tham chiếu đến các phần tử DOM
        const sidebarAvatar = document.getElementById('sidebar-avatar');
        const sidebarUserName = document.getElementById('sidebar-user-name');
        const sidebarUserEmail = document.getElementById('sidebar-user-email');
        const mainContent = document.getElementById('main-content');

        const tabProfileBtn = document.getElementById('tab-profile');
        const tabSavedNewsBtn = document.getElementById('tab-savedNews');
        const tabNotificationsBtn = document.getElementById('tab-notifications');
        const logoutBtn = document.getElementById('btn-logout');

        const newsPerPage = 6; // Số tin tức mỗi trang
        let currentPage = 1; // Trang hiện tại

        /**
         * Hiển thị nội dung chính dựa trên tab đang hoạt động.
         */
        function renderMainContent() {
            mainContent.innerHTML = ''; // Xóa nội dung cũ

            let contentHtml = '';
            if (activeTab === 'profile') {
                contentHtml = renderProfileInfo();
            } else if (activeTab === 'savedNews') {
                contentHtml = renderSavedNews();
            } else if (activeTab === 'notifications') {
                contentHtml = renderNotifications();
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
            sidebarUserName.textContent = user.name;
            sidebarUserEmail.textContent = user.email;

            // Cập nhật kiểu dáng tab đang hoạt động
            tabProfileBtn.className = `w-full text-left px-4 py-3 rounded-md transition duration-200 ${
                activeTab === 'profile' ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-gray-50'
            }`;
            tabSavedNewsBtn.className = `w-full text-left px-4 py-3 rounded-md transition duration-200 ${
                activeTab === 'savedNews' ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-gray-50'
            }`;
            tabNotificationsBtn.className = `w-full text-left px-4 py-3 rounded-md transition duration-200 ${
                activeTab === 'notifications' ? 'bg-blue-100 text-blue-700 font-semibold shadow-sm' : 'text-gray-700 hover:bg-gray-50'
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
                                src="editedUser.avatarUrl"
                                alt="User Avatar"
                                class="w-24 h-24 rounded-full object-cover mr-2 border-4 border-blue-200"
                                onerror="this.onerror=null;this.src='https://placehold.co/96x96/CCCCCC/333333?text=Error';"
                            />
                            <button id="profile-avatar-edit-btn" class="avatar-edit-button">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <input type="file" id="avatarFileInput" accept="image/*" class="hidden" />
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
                                    value="${editedUser.name}"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                />
                            ` : `
                                <p class="text-gray-900 text-lg font-medium">${user.name}</p>
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
                            <button id="change-password-btn" class="px-6 py-2 bg-gray-600 text-white font-semibold rounded-md shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                                Đổi mật khẩu
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
        function renderSavedNews() {
            if (savedNews.length === 0) {
                return `
                    <div class="p-6 bg-white rounded-lg shadow-md">
                        <h2 class="text-2xl font-semibold text-blue-800 mb-6 border-b pb-2">Tin tức đã lưu</h2>
                        <p class="text-gray-600 italic">Bạn chưa lưu tin tức nào.</p>
                    </div>
                `;
            }

            const totalPages = Math.ceil(savedNews.length / newsPerPage);
            const startIndex = (currentPage - 1) * newsPerPage;
            const endIndex = startIndex + newsPerPage;
            const currentNews = savedNews.slice(startIndex, endIndex);

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
                        <button data-url="${news.url}" class="news-read-more-btn px-4 py-2 bg-blue-500 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 flex items-center space-x-2">
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
                        ${Array.from({ length: totalPages }, (_, i) => i + 1).map(page => `
                            <button data-page="${page}" class="page-number-btn px-4 py-2 rounded-md shadow-sm ${
                                page === currentPage ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                            }">
                                ${page}
                            </button>
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

        /**
         * Tạo HTML cho phần thông báo.
         * @returns {string} Chuỗi HTML.
         */
        function renderNotifications() {
            if (notifications.length === 0) {
                return `
                    <div class="p-6 bg-white rounded-lg shadow-md">
                        <h2 class="text-2xl font-semibold text-blue-800 mb-6 border-b pb-2">Thông báo</h2>
                        <p class="text-gray-600 italic">Bạn không có thông báo nào.</p>
                    </div>
                `;
            }

            const notificationsHtml = notifications.map(notification => `
                <div data-id="${notification.id}" class="notification-item border border-gray-200 rounded-lg p-4 ${
                    notification.read ? 'bg-gray-50' : 'bg-blue-50 font-medium'
                } hover:shadow-sm transition duration-200 cursor-pointer">
                    <p class="text-gray-900 mb-1">${notification.message}</p>
                    <p class="text-gray-500 text-xs">Ngày: ${notification.date}</p>
                </div>
            `).join('');

            return `
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h2 class="text-2xl font-semibold text-blue-800 mb-6 border-b pb-2">Thông báo</h2>
                    <div class="space-y-4">
                        ${notificationsHtml}
                    </div>
                </div>
            `;
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
            const profileAvatarEditBtn = document.getElementById('profile-avatar-edit-btn'); // Nút icon bút chì
            const avatarFileInput = document.getElementById('avatarFileInput'); // Input file mới

            if (editProfileBtn) {
                editProfileBtn.onclick = () => {
                    isEditing = true;
                    editedUser = { ...user }; // Đặt lại editedUser về trạng thái người dùng hiện tại
                    renderMainContent();
                };
            }
            if (saveProfileBtn) {
                saveProfileBtn.onclick = () => {
                    user = { ...editedUser }; // Cập nhật người dùng với dữ liệu đã chỉnh sửa
                    isEditing = false;
                    updateSidebar();
                    renderMainContent();
                    console.log('Thông tin người dùng đã được lưu:', user);
                };
            }
            if (cancelEditBtn) {
                cancelEditBtn.onclick = () => {
                    isEditing = false;
                    editedUser = { ...user }; // Khôi phục editedUser về trạng thái người dùng ban đầu
                    renderMainContent();
                };
            }
            if (changePasswordBtn) {
                changePasswordBtn.onclick = () => {
                    console.log('Chức năng đổi mật khẩu');
                    // Trong một ứng dụng thực tế, điều này sẽ mở một modal hoặc điều hướng đến trang đổi mật khẩu
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
                nameInput.oninput = (e) => { editedUser.name = e.target.value; };
            }
            if (emailInput) {
                emailInput.oninput = (e) => { editedUser.email = e.target.value; };
            }
            if (bioInput) {
                bioInput.oninput = (e) => { editedUser.bio = e.target.value; };
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
                const totalPages = Math.ceil(savedNews.length / newsPerPage);
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
                        savedNews = savedNews.filter(item => item.id !== id);
                        renderMainContent(); // Render lại tin tức đã lưu
                        console.log(`Tin tức "${title}" đã bị xóa.`);
                    }
                };
            });

            // Thông báo
            document.querySelectorAll('.notification-item').forEach(item => {
                item.onclick = (e) => {
                    const id = parseInt(e.currentTarget.dataset.id);
                    notifications = notifications.map(n =>
                        n.id === id ? { ...n, read: true } : n
                    );
                    renderMainContent(); // Render lại thông báo
                    console.log(`Thông báo đã được đọc.`);
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
                editedUser = { ...user }; // Đặt lại dữ liệu người dùng đã chỉnh sửa
                updateSidebar();
                renderMainContent();
            });
            tabSavedNewsBtn.addEventListener('click', () => {
                activeTab = 'savedNews';
                isEditing = false; // Đặt lại chế độ chỉnh sửa khi chuyển tab
                updateSidebar();
                renderMainContent();
            });
            tabNotificationsBtn.addEventListener('click', () => {
                activeTab = 'notifications';
                isEditing = false; // Đặt lại chế độ chỉnh sửa khi chuyển tab
                updateSidebar();
                renderMainContent();
            });
            logoutBtn.addEventListener('click', () => {
                console.log('Đăng xuất');
                // Trong một ứng dụng thực tế, điều này sẽ xử lý logic đăng xuất
            });
        });
    </script>
    <script src="{{ asset('js/login-auth.js') }}"></script>
</body>
</html>
