<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Đăng nhập</h2>

    <form method="POST" action="{{ route('managerLogin') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email"
                   name="email"
                   id="email"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                   value="{{ old('email') }}"
                   required
                   autocomplete="email"
                   autofocus>
            @error('email')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu:</label>
            <input type="password"
                   name="password"
                   id="password"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                   required
                   autocomplete="current-password">
            @error('password')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 flex items-center justify-between">
            <label class="flex items-center text-gray-700 text-sm">
                <input type="checkbox" name="remember" id="remember" class="mr-2 leading-tight">
                <span>Ghi nhớ tôi</span>
            </label>

            @if (Route::has('password.request'))
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('password.request') }}">
                    Quên mật khẩu?
                </a>
            @endif
        </div>

        <div class="flex items-center justify-center">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                Đăng nhập
            </button>
        </div>
    </form>

    @if (Route::has('register'))
        <p class="text-center text-gray-600 text-xs mt-4">
            Chưa có tài khoản?
            <a class="text-blue-500 hover:text-blue-800 font-bold" href="{{ route('register') }}">Đăng ký ngay</a>
        </p>
    @endif
</div>
</body>
</html>
