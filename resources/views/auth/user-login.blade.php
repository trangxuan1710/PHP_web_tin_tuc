<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url(background/background-xanh-trang-dep.jpg);
        }

        .icon {
            display: inline-block;
            width: 1em;
            height: 1em;
            stroke-width: 2;
            stroke: currentColor;
            fill: none;
            stroke-linecap: "round";
            stroke-linejoin: "round";
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-cover bg-center p-4">

    <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-2xl w-full max-w-md backdrop-blur-sm">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Đăng Nhập</h2>

        <div id="message-container" class="hidden flex items-center p-3 mb-4 rounded-md">
            <span id="message-icon" class="mr-2 h-5 w-5"></span>
            <span id="message-text"></span>
        </div>

        <form id="login-form" class="space-y-4">
            {{-- @csrf --}}
            <div>
                <label for="email" class="sr-only">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i data-lucide="mail" class="icon h-5 w-5 text-gray-400"></i>
                    </span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        placeholder="Email"
                        required
                        autofocus />
                </div>
            </div>

            <div>
                <label for="password" class="sr-only">Mật khẩu</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i data-lucide="lock" class="icon h-5 w-5 text-gray-400"></i>
                    </span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        placeholder="Mật khẩu"
                        required />
                    <span
                        class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                        onclick="togglePasswordVisibility('password', 'toggle-password-icon')">
                        <i id="toggle-password-icon" data-lucide="eye" class="icon h-5 w-5 text-gray-400"></i>
                    </span>
                </div>
            </div>
            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200 font-semibold">
                Đăng Nhập
            </button>
        </form>

        <p class="mt-6 text-center text-gray-600 text-sm">
            Chưa có tài khoản?
            <a href="/signup" class="text-blue-600 hover:underline">
                Đăng ký
            </a>
        </p>
    </div>

    <script>
        // Function to display messages (tương tự như form đăng ký)
        function showUserMessage(msg, type) {
            const messageContainer = document.getElementById('message-container');
            const messageText = document.getElementById('message-text');
            const messageIcon = document.getElementById('message-icon');

            messageText.textContent = msg;
            messageContainer.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');

            if (type === 'success') {
                messageContainer.classList.add('bg-green-100', 'text-green-700');
                messageIcon.innerHTML = '<svg class="icon h-5 w-5"><use href="#lucide-check-circle"></use></svg>';
            } else {
                messageContainer.classList.add('bg-red-100', 'text-red-700');
                messageIcon.innerHTML = '<svg class="icon h-5 w-5"><use href="#lucide-x-circle"></use></svg>';
            }
            messageContainer.classList.remove('hidden');

            setTimeout(() => {
                messageContainer.classList.add('hidden');
                messageText.textContent = '';
            }, 3000); // Message disappears after 3 seconds
        }

        // Function to toggle password visibility (tương tự như form đăng ký)
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons(); // Cập nhật lại icon
        }

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons(); // Initialize Lucide icons

            const loginForm = document.getElementById('login-form');
            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault(); // Ngăn chặn form gửi đi theo cách truyền thống

                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                try {
                    const response = await fetch('/login', { // Thay đổi URL API của bạn
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({
                            email,
                            password,
                        })
                    });

                    const data = await response.json();

                    if (response.ok) { // Kiểm tra nếu phản hồi là thành công (status 2xx)
                        showUserMessage(data.message, 'success');
                        console.log('Đăng nhập thành công:', data.message);
                        // Chuyển hướng người dùng hoặc cập nhật UI sau khi đăng nhập thành công
                        window.location.href = '/'; // Ví dụ: chuyển hướng đến trang dashboard
                    } else {
                        const errorMessage = data.message;
                        showUserMessage(errorMessage, 'error');
                        console.error('Lỗi đăng nhập:', errorMessage);
                    }
                } catch (error) {
                    console.error('Lỗi khi gửi yêu cầu đăng nhập:', error);
                    showUserMessage('Có lỗi xảy ra. Vui lòng thử lại sau.');
                }
            });

        });
    </script>
</body>

</html>
