<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form - {{ isset($news) ? 'Chỉnh sửa Tin tức' : 'Tạo Tin tức mới' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* CSS của bạn giữ nguyên */
        /* ... */
        .file-input-hidden { display: none; }
        .ck-editor__editable_inline { min-height: 300px; max-height: 500px; overflow-y: auto; padding: 1rem; border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; border: none;}
        .ck-editor__main {border: none !important;}
        .ck.ck-editor__main > .ck-editor__editable:not(.ck-editor__nested-editable) {border: none;box-shadow: none;}
        .ck.ck-toolbar { background-color: #f9fafb !important; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; border-bottom: 1px solid #e5e7eb !important; border-left: none !important; border-right: none !important; border-top: none !important;}
        .ck.ck-editor__top.ck-reset_all {border-bottom: none !important;}
        .ck.ck-editor__editable {border-bottom-left-radius: 0.5rem !important;border-bottom-right-radius: 0.5rem !important;}
        .ck.ck-editor {border-radius: 0.5rem !important;border: 1px solid #d1d5db !important;box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important;}
        .ck.ck-icon {color: #6b7280 !important;}
        .ck.ck-button.ck-off:hover {background-color: #e5e7eb !important;}
        .ck.ck-button.ck-on {background-color: #cbd5e0 !important;}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40j/6Pqq/VHzUfTsL7W/feV6S4q60o7N_iO1d7k4h1X7VvT8f3GjZ6zQ0U5s2M8Q2gK5W9J5m0Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
<div class="bg-white p-6 md:p-8 rounded-lg shadow-xl w-full max-w-4xl border border-gray-200">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">
        {{ isset($news) ? 'Chỉnh sửa Tin tức' : 'Soạn bài viết mới' }}
    </h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Thành công!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentNode.remove()">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.697l-2.651 2.652a1.2 1.2 0 1 1-1.697-1.697L8.303 10l-2.652-2.651a1.2 1.2 0 1 1 1.697-1.697L10 8.303l2.651-2.652a1.2 1.2 0 1 1 1.697 1.697L11.697 10l2.652 2.651a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Lỗi!</strong>
            <span class="block sm:inline">Có một số lỗi xảy ra:</span>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Thay đổi action của form dựa trên chế độ (tạo mới/chỉnh sửa) --}}
    <form action="{{ isset($news) ? route('news.update', $news->id) : route('news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        {{-- Nếu ở chế độ chỉnh sửa, thêm @method('PUT') --}}
        @if (isset($news))
            @method('PUT')
        @endif

        <div>
            <label for="title" class="block text-gray-700 text-sm font-medium mb-2">Tiêu đề:</label>
            <input type="text" id="title" name="title"
                   value="{{ old('title', isset($news) ? $news->title : '') }}" {{-- Hiển thị dữ liệu cũ --}}
                   placeholder="Nhập tiêu đề bài viết tại đây..."
                   class="shadow-sm appearance-none border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="label_id" class="block text-gray-700 text-sm font-medium mb-2">Tag bài viết (Nhãn):</label>
                <select id="label_id" name="label_id"
                        class="shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out">
                    <option value="">Chọn một tag (nhãn)</option>
                    @foreach($labels as $label)
                        <option value="{{ $label->id }}"
                            {{ old('label_id', isset($news) ? $news->labelId : '') == $label->id ? 'selected' : '' }}> {{-- Hiển thị dữ liệu cũ --}}
                            {{ $label->type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="isHot" class="block text-gray-700 text-sm font-medium mb-2">Tin nóng:</label>
                <select id="isHot" name="isHot"
                        class="shadow-sm border border-gray-300 rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out">
                    <option value="0" {{ old('isHot', isset($news) ? (string)(int)$news->isHot : '0') == '0' ? 'selected' : '' }}>Không</option> {{-- Hiển thị dữ liệu cũ --}}
                    <option value="1" {{ old('isHot', isset($news) ? (string)(int)$news->isHot : '') == '1' ? 'selected' : '' }}>Có</option> {{-- Chú ý (string)(int) để chuyển boolean thành '0' hoặc '1' --}}
                </select>
            </div>
        </div>

        <div>
            <label for="thumbnail-upload" class="block text-gray-700 text-sm font-medium mb-2">Ảnh Thumbnail:</label>
            <div class="flex items-center space-x-4">
                <div id="drop-area" class="flex-none w-32 h-32 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-400 hover:text-blue-600 transition-colors duration-200 text-gray-500 p-2">
                    <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <p class="text-xs font-medium text-center">Tải lên</p>
                    <input type="file" id="thumbnail-upload" name="thumbnail" accept="image/png, image/jpeg, image/gif" class="file-input-hidden">
                </div>

                <div id="thumbnail-preview-container" class="flex-1 border border-gray-300 rounded-lg overflow-hidden flex items-center justify-center p-2 min-h-[128px]">
                    <img id="thumbnail-preview-img"
                         src="{{ old('thumbNailUrl', isset($news) ? $news->thumbNailUrl : '') }}"
                         alt="Thumbnail Preview"
                         class="w-full h-auto object-contain max-h-40">
                    <p id="no-image-text" class="text-gray-400 text-sm italic">Chưa có ảnh nào được chọn</p>
                </div>
            </div>
        </div>

        <div>
            <label for="editor" class="block text-gray-700 text-sm font-medium mb-2">Nội dung:</label>
            <textarea id="editor" name="content">{{ old('content', isset($news) ? $news->content : '') }}</textarea> {{-- Hiển thị dữ liệu cũ --}}
        </div>

        <div class="flex flex-col md:flex-row items-center justify-end space-y-3 md:space-y-0 md:space-x-4 pt-4">
            <a href="{{ route('manageNews') }}" class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 transition duration-200 ease-in-out text-center">
                Hủy
            </a>
            <button type="submit" class="w-full md:w-auto bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75 transition duration-200 ease-in-out">
                Lưu nháp
            </button>
            <button type="submit" class="w-full md:w-auto bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-6 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-opacity-75 transition duration-200 ease-in-out">
                {{ isset($news) ? 'Cập nhật' : 'Lưu' }}
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
    // Khởi tạo CKEditor 5 (Giữ nguyên)
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            toolbar: { /* ... */ }, language: 'vi',
        } )
        .then( editor => { console.log( 'CKEditor 5 đã sẵn sàng!', editor ); } )
        .catch( error => { console.error( error ); } );

    // --- JavaScript cho Thumbnail Preview và Xóa ---
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('thumbnail-upload');
    const thumbnailPreviewImg = document.getElementById('thumbnail-preview-img');
    const noImageText = document.getElementById('no-image-text');

    // Hàm hiển thị preview ảnh
    function showImagePreview(file) {
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                thumbnailPreviewImg.src = e.target.result;
                noImageText.classList.add('hidden'); // Ẩn text placeholder khi có ảnh
            };
            reader.readAsDataURL(file);
        } else {
            thumbnailPreviewImg.src = '';
            noImageText.classList.remove('hidden'); // Hiện text placeholder khi không có ảnh
        }
    }

    // --- Kích hoạt preview ảnh khi tải trang nếu có ảnh cũ (chế độ chỉnh sửa) ---
    // Biến này sẽ được truyền từ Blade nếu đang ở chế độ chỉnh sửa
    const oldThumbnailUrl = "{{ isset($news) && $news->thumbNailUrl ? asset($news->thumbNailUrl) : '' }}";

    window.addEventListener('DOMContentLoaded', () => {
        if (oldThumbnailUrl) {
            thumbnailPreviewImg.src = oldThumbnailUrl;
            noImageText.classList.add('hidden'); // Ẩn text placeholder
        } else {
            noImageText.classList.remove('hidden'); // Đảm bảo text placeholder hiện nếu không có ảnh cũ
        }
    });


    // Xử lý khi file được chọn qua input change event
    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        if (files.length > 0) {
            showImagePreview(files[0]);
        } else {
            showImagePreview(null);
        }
    });

    // Xử lý click vào drop area để kích hoạt input file
    dropArea.addEventListener('click', () => {
        fileInput.click();
    });

    // Xử lý kéo và thả (giữ nguyên)
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.value = ''; // Luôn reset input file trước khi gán mới
        fileInput.files = files; // Gán file vào input
        if (files.length > 0) {
            showImagePreview(files[0]);
        } else {
            showImagePreview(null);
        }
    }
</script>
</body>
</html>
