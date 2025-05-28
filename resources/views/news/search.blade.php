@extends('layouts.app')

@section('title', ' - Kết quả tìm kiếm')

@section('content')
    <div class="search-page-content">
        <h1 class="text-2xl font-bold text-gray-700 mb-6 border-b pb-4">
            Kết quả tìm kiếm @if(!empty($query)) cho "{{ $query }}" @endif
        </h1>

        <form action="{{ route('news.search') }}" method="GET" class="search-form mb-8">
            <input type="hidden" name="q" value="{{ $query }}"> {{-- Đảm bảo giữ lại query khi thay đổi filter --}}

            <div class="filter-group flex gap-5 mb-5 flex-wrap">
                <div class="filter-item">
                    <label for="time" class="block text-gray-600 text-sm font-medium mb-1">Thời gian</label>
                    <select id="time" name="time" onchange="this.form.submit()" class="p-2 border border-gray-300 rounded-md">
                        <option value="all" {{ $time == 'all' ? 'selected' : '' }}>Tất cả</option>
                        <option value="today" {{ $time == 'today' ? 'selected' : '' }}>Hôm nay</option>
                        <option value="week" {{ $time == 'week' ? 'selected' : '' }}>Tuần này</option>
                        <option value="month" {{ $time == 'month' ? 'selected' : '' }}>Tháng này</option>
                        <option value="year" {{ $time == 'year' ? 'selected' : '' }}>Năm nay</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label for="tag" class="block text-gray-600 text-sm font-medium mb-1">Thẻ (Tags)</label>
                    <select id="tag" name="tag" onchange="this.form.submit()" class="p-2 border border-gray-300 rounded-md">
                        <option value="all" {{ $tag == 'all' ? 'selected' : '' }}>Tất cả</option>
                        @foreach($uniqueTags as $t)
                            <option value="{{ $t }}" {{ $tag == $t ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $t)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-item">
                    <label for="status" class="block text-gray-600 text-sm font-medium mb-1">Trạng thái</label>
                    <select id="status" name="status" onchange="this.form.submit()" class="p-2 border border-gray-300 rounded-md">
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Tất cả</option>
                        @foreach($statuses as $s)
                            <option value="{{ $s }}" {{ $status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="sort-buttons flex space-x-3">
                <button type="submit" name="sort" value="latest" class="px-5 py-2 rounded-md transition-colors
                    {{ $sortBy == 'latest' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Mới nhất
                </button>
                <button type="submit" name="sort" value="relevance" class="px-5 py-2 rounded-md transition-colors
                    {{ $sortBy == 'relevance' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Liên quan
                </button>
            </div>
        </form>

        <div class="search-results pt-5 border-t border-gray-200">
            @if($results->isEmpty())
                <p class="text-gray-600 text-center text-lg py-10">Không tìm thấy bài viết nào phù hợp.</p>
            @else
                @foreach($results as $article)
                    <div class="article-item flex bg-white border border-gray-200 rounded-lg p-4 mb-5 shadow-sm">
                        <div class="article-content flex-grow pr-4">
                            <h2 class="text-lg font-semibold text-blue-700 mb-2 hover:underline"><a href="#">{{ $article->title }}</a></h2>
                            <p class="text-gray-600 text-sm leading-relaxed mb-3">{{ Str::limit($article->content, 180) }}</p>
                            <div class="article-meta flex items-center text-gray-500 text-xs">
                                @if($article->isHot)
                                    <span class="bg-red-500 text-white px-2 py-0.5 rounded-full text-xs mr-2">HOT</span>
                                @endif
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.11C6.234 14.137 9.2 12 12 12s5.766 2.137 7.605 4.89L21 20l-1.395-3.11A9.863 9.863 0 0021 12z"></path></svg>
                                {{-- Số lượng comment thực tế cần join bảng comments hoặc dùng withCount --}}
                                <span>{{ $article->comments()->count() }} bình luận</span>
                                <span class="ml-4">Thẻ: {{ $article->tag }}</span>
                            </div>
                        </div>
                        @if($article->thumbNailUrl)
                            <div class="article-thumbnail flex-shrink-0 w-48 h-32 overflow-hidden rounded-md">
                                <img src="{{ $article->thumbNailUrl }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="mt-8">
                    {{ $results->appends(request()->input())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
