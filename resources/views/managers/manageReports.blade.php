{{-- resources/views/reports/index.blade.php --}}

@extends('managers.layouts.app') {{-- Updated to managers.layouts.app as per user's provided context --}}

@section('title', 'Quản lý báo cáo') {{-- Set page title --}}

@section('content')
    <div class="flex-1"> {{-- Added a subtle background color to the main content area --}}
        {{-- Display success/error messages --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 max-w-4xl mx-auto" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 max-w-4xl mx-auto" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Check if there are any pending reports --}}
        @if ($reports->isNotEmpty())
            {{-- Removed grid layout to display one card per row --}}
            @foreach ($reports as $report)

                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-red-500 w-full max-w-4xl mx-auto mb-6"> {{-- Increased max-width, centered --}}
                    <div class="flex items-center mb-4">
                        <i class="fas fa-exclamation-triangle text-red-500 text-2xl mr-3"></i>
                        <h3 class="text-xl font-semibold text-gray-800">Báo cáo từ: {{ $report->client->fullName ?? 'Người dùng không xác định' }}</h3>
                    </div>

                    <div class="mb-3">
                        <p class="text-gray-700 text-base">
                            <span class="font-medium">Thời gian:</span> {{ $report->created_at->format('H:i:s d/m/Y') ?? 'Không rõ thời gian' }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <p class="text-gray-700 text-base">
                            <span class="font-medium">Lý do:</span> {{ $report->reason }}
                        </p>
                    </div>
                    {{-- New: Display 'content' from the Reports model (chú thích) --}}
                    @if ($report->content)
                        <div class="mb-4 bg-blue-50 p-3 rounded-lg border border-blue-200">
                            <p class="text-blue-800 text-base italic">
                                <span class="font-medium">Chú thích:</span> "{{ $report->content }}"
                            </p>
                        </div>
                    @endif
                    <div class="mb-4 bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <p class="text-gray-800 text-base italic line-clamp-2">
                            <span class="font-medium">Bình luận bị báo cáo:</span> "{{ $report->comment->content ?? 'Bình luận không tồn tại' }}"
                        </p>
                    </div>

                    <div class="flex justify-end space-x-3 mt-4">
                        {{-- Form for processing the report (resolve or ignore) --}}
                        <form action="{{ route('processReport', ['id' => $report->id]) }}" method="POST">
                            @csrf
                            {{-- Hidden input to specify the action --}}
                            <input type="hidden" name="action" value="resolve">
                            <button type="submit" class="px-5 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 text-sm">
                                xóa bình luận
                            </button>
                        </form>

                        <form action="{{ route('processReport', ['id' => $report->id]) }}" method="POST">
                            @csrf
                            {{-- Hidden input to specify the action --}}
                            <input type="hidden" name="action" value="ignore">
                            <button type="submit" class="px-5 py-2 bg-gray-200 text-gray-800 font-semibold rounded-lg shadow-md hover:bg-gray-300 transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 text-sm">
                                Bỏ qua
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto text-center text-gray-600">
                <p class="text-xl">Không có báo cáo mới nào.</p>
            </div>
        @endif
    </div>
@endsection
