@extends('layouts.app')


@section('title', $article->title ?? 'Chi tiết bài báo') {{-- Tùy chọn: Đặt tiêu đề trang --}}

@section('content')
    <div class="container mx-auto px-2 sm:px-4 py-8">
        <div class="grid grid-cols-12 gap-6">
            {{-- Cột chính cho nội dung bài viết --}}
            <main class="col-span-12 lg:col-span-9">
                <article class="bg-white shadow-lg rounded-lg overflow-hidden">
                    {{-- Hình ảnh đại diện cho bài viết (nếu có) --}}
                    @if(isset($article) && $article->featured_image_url)
                        <img src="{{ $article->featured_image_url }}" alt="{{ $article->title ?? 'Hình ảnh bài viết' }}" class="w-full h-64 sm:h-80 md:h-96 object-cover">
                    @else
                        {{-- Placeholder image if no specific article image --}}
                        {{-- <img src="https://via.placeholder.com/1200x600?text=Tin+Tuc+24/7" alt="Hình ảnh bài viết" class="w-full h-64 sm:h-80 md:h-96 object-cover"> --}}
                    @endif

                    <div class="p-5 sm:p-6 md:p-8">
                        {{-- Thông tin meta: Danh mục, Ngày đăng --}}
                        <div class="mb-4 text-sm text-gray-500">
                            @if(isset($article) && $article->category)
                                <a href="{{ $article->category->url ?? '#' }}" class="font-semibold text-blue-600 hover:text-blue-700 uppercase">{{ $article->category->name ?? 'Chưa phân loại' }}</a>
                                <span class="mx-2">|</span>
                            @endif
                            <span>{{ isset($article) ? ($article->published_at ? $article->published_at->format('d/m/Y H:i') : 'Đang cập nhật') : \Carbon\Carbon::now()->format('d/m/Y') }}</span>
                        </div>

                        {{-- Tiêu đề bài viết --}}
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4 leading-tight">
                            {{ $article->title ?? 'Đây là Tiêu Đề Mẫu Cho Bài Viết Của Bạn' }}
                        </h1>

                        {{-- Thông tin tác giả --}}
                        @if(isset($article) && $article->author)
                            <div class="flex items-center text-sm text-gray-700 mb-6">
                                <img src="{{ $article->author->avatar_url ?? 'https://via.placeholder.com/40' }}" alt="{{ $article->author->name ?? 'Tác giả' }}" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full mr-3 object-cover">
                                <div>
                                    <span>Bởi <a href="{{ $article->author->profile_url ?? '#' }}" class="font-semibold text-gray-800 hover:underline">{{ $article->author->name ?? 'Tên Tác Giả' }}</a></span>
                                    {{-- <p class="text-xs text-gray-500">Chức danh tác giả (nếu có)</p> --}}
                                </div>
                            </div>
                        @endif

                        {{-- Đoạn mô tả ngắn/Sapo (nếu có) --}}
                        @if(isset($article) && $article->excerpt)
                            <p class="text-gray-700 text-lg italic mb-6 border-l-4 border-blue-500 pl-4">
                                {{ $article->excerpt }}
                            </p>
                        @endif

                        {{-- Nội dung chính của bài viết --}}
                        {{-- QUAN TRỌNG: Để định dạng HTML từ trình soạn thảo (WYSIWYG) hiển thị đẹp,
                             bạn nên dùng plugin @tailwindcss/typography và thêm class "prose".
                             Nếu không, bạn cần tự style các thẻ p, h1, h2, ul, blockquote... bằng Tailwind.
                        --}}
                        <div class="prose prose-sm sm:prose lg:prose-lg max-w-none text-gray-800 article-content">
                            @if(isset($article) && $article->content)
                                {!! $article->content !!} {{-- Sử dụng {!! !!} nếu content là HTML --}}
                            @else
                                <p>Mở đầu bài viết, giới thiệu chung về vấn đề sẽ được đề cập. Đoạn văn này cần đủ hấp dẫn để giữ chân người đọc.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                <h2 class="text-xl sm:text-2xl font-semibold mt-6 mb-3">Tiêu đề phụ cấp 1</h2>
                                <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris.</p>
                                <figure class="my-6">
                                    <img src="https://via.placeholder.com/800x450?text=Hinh+Anh+Minh+Hoa" alt="Image inside article" class="w-full h-auto rounded-md shadow-md">
                                    <figcaption class="text-center text-sm text-gray-500 mt-2">Chú thích cho hình ảnh trong bài viết.</figcaption>
                                </figure>
                                <p>Integer in mauris eu nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu tempor congue, eros est euismod turpis, id tincidunt sapien risus a quam. Maecenas fermentum consequat mi. Donec fermentum.</p>
                                <blockquote class="border-l-4 border-blue-500 pl-4 italic text-gray-700 my-6 py-2">
                                    "Đây là một trích dẫn quan trọng hoặc một ý kiến nổi bật trong bài viết. Nó giúp làm phong phú thêm nội dung."
                                </blockquote>
                                <h3 class="text-lg sm:text-xl font-semibold mt-6 mb-3">Tiêu đề phụ cấp 2</h3>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Mục danh sách thứ nhất.</li>
                                    <li>Mục danh sách thứ hai với nội dung dài hơn một chút để kiểm tra.</li>
                                    <li>Mục danh sách thứ ba.</li>
                                </ul>
                                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin pharetra nonummy pede. Mauris et orci. Aenean nec lorem.</p>
                            @endif
                        </div>

                        {{-- Tags (nếu có) --}}
                        @if(isset($article) && $article->tags && $article->tags->count() > 0)
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <span class="text-gray-600 font-semibold mr-2">Tags:</span>
                                @foreach($article->tags as $tag)
                                    <a href="{{ $tag->url ?? '#' }}" class="inline-block bg-gray-200 hover:bg-gray-300 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        @endif

                        {{-- Nút chia sẻ (cần JavaScript để hoạt động đầy đủ) --}}
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <span class="text-gray-700 font-semibold mb-2 block sm:inline sm:mr-2">Chia sẻ bài viết:</span>
                            <div class="inline-flex items-center space-x-3">
                                <a href="#" title="Chia sẻ lên Facebook" class="text-blue-600 hover:text-blue-800 transition-colors duration-200"><i class="fab fa-facebook-f fa-lg"></i></a>
                                <a href="#" title="Chia sẻ lên Twitter" class="text-blue-400 hover:text-blue-600 transition-colors duration-200"><i class="fab fa-twitter fa-lg"></i></a>
                                <a href="#" title="Chia sẻ lên Pinterest" class="text-red-600 hover:text-red-800 transition-colors duration-200"><i class="fab fa-pinterest-p fa-lg"></i></a>
                                <a href="#" title="Chia sẻ qua WhatsApp" class="text-green-500 hover:text-green-700 transition-colors duration-200"><i class="fab fa-whatsapp fa-lg"></i></a>
                                <a href="#" title="Sao chép liên kết" class="text-gray-600 hover:text-gray-800 transition-colors duration-200"><i class="fas fa-link fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- Phần bình luận (Placeholder) --}}
                <section class="mt-8 sm:mt-10" id="comments">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Bình luận ({{ $article->comments_count ?? 0 }})</h2>
                    <div class="bg-white shadow-lg rounded-lg p-5 sm:p-6">
                        {{-- Form bình luận --}}
                        <form class="mb-6">
                            <div>
                                <label for="comment_content" class="sr-only">Nội dung bình luận</label>
                                <textarea id="comment_content" name="comment_content" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200" rows="4" placeholder="Viết bình luận của bạn..."></textarea>
                            </div>
                            <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition-colors duration-200">
                                Gửi bình luận
                            </button>
                        </form>

                        {{-- Danh sách bình luận (Ví dụ) --}}
                        <div class="space-y-6">
                            {{-- Ví dụ một bình luận --}}
                            @for ($i = 0; $i < 2; $i++)
                                <div class="flex space-x-3">
                                    <img src="https://via.placeholder.com/40?text=User{{$i+1}}" alt="User Avatar" class="w-10 h-10 rounded-full flex-shrink-0">
                                    <div class="flex-1">
                                        <div class="bg-gray-100 p-3 rounded-lg shadow-sm">
                                            <p class="text-sm font-semibold text-gray-800 mb-1">Tên Người Dùng {{$i+1}}</p>
                                            <p class="text-gray-700 text-sm">Nội dung bình luận mẫu. Bài viết rất hay và cung cấp nhiều thông tin hữu ích. Cảm ơn tác giả!</p>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1.5 space-x-3">
                                            <button class="hover:underline">Thích</button>
                                            <button class="hover:underline">Trả lời</button>
                                            <span>{{ $i + 2 }} giờ trước</span>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                            {{-- Ví dụ bình luận có trả lời --}}
                            <div class="flex space-x-3">
                                <img src="https://via.placeholder.com/40?text=User3" alt="User Avatar" class="w-10 h-10 rounded-full flex-shrink-0">
                                <div class="flex-1">
                                    <div class="bg-gray-100 p-3 rounded-lg shadow-sm">
                                        <p class="text-sm font-semibold text-gray-800 mb-1">Người dùng có trả lời</p>
                                        <p class="text-gray-700 text-sm">Đây là một bình luận khác.</p>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1.5 space-x-3">
                                        <button class="hover:underline">Thích</button>
                                        <button class="hover:underline">Trả lời</button>
                                        <span>6 giờ trước</span>
                                    </div>
                                    {{-- Trả lời lồng nhau --}}
                                    <div class="flex space-x-3 mt-4 ml-6 sm:ml-8">
                                        <img src="https://via.placeholder.com/32?text=Reply" alt="User Avatar" class="w-8 h-8 rounded-full flex-shrink-0">
                                        <div class="flex-1">
                                            <div class="bg-gray-100 p-3 rounded-lg shadow-sm">
                                                <p class="text-sm font-semibold text-gray-800 mb-1">Người trả lời</p>
                                                <p class="text-gray-700 text-sm">Đồng ý với bạn!</p>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1.5 space-x-3">
                                                <button class="hover:underline">Thích</button>
                                                <button class="hover:underline">Trả lời</button>
                                                <span>5 giờ trước</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            {{-- Sidebar (Cột phụ cho các tin nổi bật, quảng cáo, etc.) --}}
            <aside class="col-span-12 lg:col-span-3">
                <div class="sticky top-24 space-y-6"> {{-- `top-24` hoặc giá trị khác tùy theo chiều cao header --}}
                    {{-- Widget: Tin nổi bật --}}
                    <div class="bg-white shadow-lg rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Tin nổi bật</h3>
                        <ul class="space-y-3">
                            @for ($i = 0; $i < 4; $i++)
                                <li class="flex items-start space-x-3">
                                    <img src="https://via.placeholder.com/80x60?text=Hot{{$i+1}}" alt="Tin nổi bật" class="w-20 h-16 object-cover rounded-md flex-shrink-0">
                                    <div>
                                        <a href="#" class="text-sm font-semibold text-gray-700 hover:text-blue-600 line-clamp-2">Tiêu đề tin tức nổi bật khá dài để kiểm tra hiển thị {{$i+1}}</a>
                                        <p class="text-xs text-gray-500 mt-1">{{ $i+1 }} ngày trước</p>
                                    </div>
                                </li>
                            @endfor
                        </ul>
                    </div>

                    {{-- Widget: Quảng cáo (Ví dụ) --}}
                    <div class="bg-white shadow-lg rounded-lg p-5 text-center">
                        <img src="https://via.placeholder.com/300x250?text=Quang+Cao" alt="Quảng cáo" class="mx-auto rounded-md">
                        <p class="text-xs text-gray-400 mt-2">Không gian quảng cáo</p>
                    </div>

                    {{-- Widget: Danh mục (Ví dụ) --}}
                    <div class="bg-white shadow-lg rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Danh mục</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-700 hover:text-blue-600 hover:ml-1 transition-all duration-150 block">Đời sống (15)</a></li>
                            <li><a href="#" class="text-gray-700 hover:text-blue-600 hover:ml-1 transition-all duration-150 block">Thể thao (22)</a></li>
                            <li><a href="#" class="text-gray-700 hover:text-blue-600 hover:ml-1 transition-all duration-150 block">Công nghệ (18)</a></li>
                            <li><a href="#" class="text-gray-700 hover:text-blue-600 hover:ml-1 transition-all duration-150 block">Sức khỏe (12)</a></li>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>

        {{-- Phần bài viết liên quan (nếu không muốn đặt trong cột chính) --}}
        <section class="mt-10 sm:mt-12" id="related-articles">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Bài viết liên quan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 sm:gap-6">
                {{-- Ví dụ một card bài viết liên quan --}}
                @for ($i = 0; $i < 4; $i++)
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-300">
                        <a href="#">
                            <img src="https://via.placeholder.com/400x250?text=Related+{{$i+1}}" alt="Bài viết liên quan" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-md font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-blue-600">Tiêu đề của bài viết liên quan thứ {{$i+1}} này cũng có thể khá dài</h3>
                                <span class="text-xs text-gray-500">{{ $i*2 + 1 }} ngày trước</span>
                            </div>
                        </a>
                    </div>
                @endfor
            </div>
        </section>
    </div>
@endsection

@push('styles')
    {{-- Đảm bảo Font Awesome đã được thêm vào layout chính của bạn nếu bạn sử dụng các icon fab, fas.
         Ví dụ: <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    --}}
    {{-- Nếu bạn sử dụng plugin @tailwindcss/typography (khuyến nghị cho phần .article-content):
         1. Cài đặt: npm install -D @tailwindcss/typography hoặc yarn add -D @tailwindcss/typography
         2. Thêm vào tailwind.config.js: plugins: [require('@tailwindcss/typography')],
         Sau đó, class "prose" sẽ tự động định dạng nội dung HTML.
    --}}
    <style>
        /* Tùy chỉnh thêm cho class .article-content nếu không dùng plugin typography */
        .article-content h1, .article-content h2, .article-content h3, .article-content h4 {
            /* font-weight: 600; */ /* Ví dụ */
            /* margin-bottom: 0.5em; */
        }
        .article-content p {
            margin-bottom: 1em;
            line-height: 1.7;
        }
        .article-content ul, .article-content ol {
            margin-bottom: 1em;
            padding-left: 1.5em;
        }
        .article-content blockquote {
            /* margin-bottom: 1em; */
            /* padding: 0.5em 1em; */
            /* border-left: 4px solid #ccc; */
            /* font-style: italic; */
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush

@push('scripts')
    {{-- Script cho các tương tác như nút chia sẻ, gallery ảnh, v.v. (nếu cần) --}}
    <script>
        // Ví dụ: Xử lý sao chép link
        // document.querySelectorAll('a[title="Sao chép liên kết"]').forEach(button => {
        //     button.addEventListener('click', event => {
        //         event.preventDefault();
        //         navigator.clipboard.writeText(window.location.href).then(() => {
        //             alert('Đã sao chép liên kết vào bộ nhớ tạm!');
        //         }).catch(err => {
        //             console.error('Không thể sao chép liên kết: ', err);
        //         });
        //     });
        // });
    </script>
@endpush
