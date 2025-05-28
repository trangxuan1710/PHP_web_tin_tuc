{{-- resources/views/news/saved.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>📌 Danh sách tin đã lưu</h2>

        @if (count($savedNews) > 0)
            <ul class="list-group mt-4">
                @foreach ($savedNews as $item)
                    <li class="list-group-item">
                        {{ $item }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>Chưa có bài viết nào được lưu.</p>
        @endif
    </div>
@endsection
