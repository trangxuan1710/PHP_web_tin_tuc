@extends("managers.layouts.app")
{{-- Kế thừa layout chính của bạn --}}

@section('title', 'Đổi mật khẩu')

@section('content')
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <h2 class="text-2xl text-gray-800 font-semibold border-b border-gray-200 pb-4 mb-6">Đổi mật khẩu</h2>

        <form action="{{ route('managerChangePassword') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex flex-col">
                <label for="current_password" class="mb-2 text-gray-700 font-medium">Mật khẩu hiện tại</label>
                <input type="password" id="current_password" name="current_password" placeholder="Nhập mật khẩu hiện tại"
                       class="p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800">
                @error('current_password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col">
                <label for="password" class="mb-2 text-gray-700 font-medium">Mật khẩu mới</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu mới"
                       class="p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800">
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col">
                <label for="password_confirmation" class="mb-2 text-gray-700 font-medium">Xác nhận mật khẩu mới</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu mới"
                       class="p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800">
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
@endsection
