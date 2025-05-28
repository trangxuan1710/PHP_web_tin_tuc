<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url(background/background-xanh-trang-dep.jpg);
        }

        /* Custom styles for Lucide icons */
        .icon {
            display: inline-block;
            width: 1em;
            height: 1em;
            stroke-width: 2;
            stroke: currentColor;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

    </style>
</head>

<body id="main-content" class="min-h-screen flex items-center justify-center bg-cover bg-center p-4">

    <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-2xl w-full max-w-md backdrop-blur-sm">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-10">Đăng Ký</h2>

        <div id="message-container" class="hidden flex items-center p-3 mb-4 rounded-md">
            <span id="message-icon" class="mr-2 h-5 w-5"></span>
            <span id="message-text"></span>
        </div>

        <form id="registration-form" class="space-y-4">
            <div>
                <label for="fullName" class="sr-only">Họ và tên</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i data-lucide="user" class="icon h-5 w-5 text-gray-400"></i>
                    </span>
                    <input
                        type="text"
                        id="fullName"
                        name="fullName"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        placeholder="Tên người dùng"
                        required />
                </div>
            </div>

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
                        required />
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

            <div>
                <label for="confirmPassword" class="sr-only">Xác nhận mật khẩu</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i data-lucide="lock-keyhole" class="icon h-5 w-5 text-gray-400"></i>
                    </span>
                    <input
                        type="password"
                        id="confirmPassword"
                        name="confirmPassword"
                        class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        placeholder="Xác nhận mật khẩu"
                        required />
                    <span
                        class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                        onclick="togglePasswordVisibility('confirmPassword', 'toggle-confirm-password-icon')">
                        <i id="toggle-confirm-password-icon" data-lucide="eye" class="icon h-5 w-5 text-gray-400"></i>
                    </span>
                </div>
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-200 font-semibold">
                Đăng Ký
            </button>
        </form>

        <div class="relative flex items-center justify-center my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative bg-white px-4 text-sm text-gray-500 rounded-full">
                Hoặc
            </div>
        </div>

        <button
            id="google-register-btn"
            class="w-full flex items-center justify-center bg-white text-gray-700 py-2 px-4 rounded-md border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition duration-200 font-semibold">
            <svg class="h-5 w-5 mr-4" viewBox="0 0 48 48">
                <path fill="#fbc02d" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12	s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20	s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                <path fill="#e53935" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039	l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                <path fill="#4caf50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                <path fill="#1565c0" d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
            </svg>
            Đăng ký bằng Google
        </button>

        <p class="mt-6 text-center text-gray-600 text-sm">
            Đã có tài khoản?
            <a href="/login" class="text-blue-600 hover:underline">
                Đăng nhập
            </a>
        </p>
    </div>

    <script>
        // Function to display messages
        function showUserMessage(msg, type) {
            const messageContainer = document.getElementById('message-container');
            const messageText = document.getElementById('message-text');
            const messageIcon = document.getElementById('message-icon');

            messageText.textContent = msg;
            messageContainer.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');

            if (type === 'success') {
                messageContainer.classList.add('bg-green-100', 'text-green-700');
                // Lucide check-circle icon
                messageIcon.innerHTML = '<svg class="icon h-5 w-5"><use href="#lucide-check-circle"></use></svg>';
            } else {
                messageContainer.classList.add('bg-red-100', 'text-red-700');
                // Lucide x-circle icon
                messageIcon.innerHTML = '<svg class="icon h-5 w-5"><use href="#lucide-x-circle"></use></svg>';
            }
            messageContainer.classList.remove('hidden');

            setTimeout(() => {
                messageContainer.classList.add('hidden');
                messageText.textContent = '';
            }, 3000); // Message disappears after 3 seconds
        }

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
            lucide.createIcons();

            const registrationForm = document.getElementById('registration-form');
            registrationForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                const fullName = document.getElementById('fullName').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                if (!fullName || !email || !password || !confirmPassword) {
                    showUserMessage('Vui lòng điền đầy đủ tất cả các trường.', 'error');
                    return;
                }
                if (password !== confirmPassword) {
                    showUserMessage('Mật khẩu xác nhận không khớp.', 'error');
                    return;
                }
                if (password.length < 6) {
                    showUserMessage('Mật khẩu phải có ít nhất 6 ký tự.', 'error');
                    return;
                }

                console.log('Đăng ký với:', {
                    fullName,
                    email,
                    password
                });

                const csrfToken = '{{ csrf_token() }}';

                fetch('/signup', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken, 

                    },
                    body: JSON.stringify({ fullName, email, password, password_confirmation: confirmPassword })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showUserMessage('Đăng ký thành công!', 'success');
                        console.log(data);
                    } else {
                        showUserMessage(data.message || 'Đăng ký thất bại.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showUserMessage('Có lỗi xảy ra trong quá trình đăng ký.', 'error');
                });

                // Clear form fields after successful simulation
                document.getElementById('fullName').value = '';
                document.getElementById('email').value = '';
                document.getElementById('password').value = '';
                document.getElementById('confirmPassword').value = '';
            });

            const googleRegisterBtn = document.getElementById('google-register-btn');
            googleRegisterBtn.addEventListener('click', function() {
                showUserMessage('Đang chuyển hướng đến Google để đăng ký...', 'success');
                console.log('Đăng ký bằng Google');
            });
        });
    </script>
</body>

</html>