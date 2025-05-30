@foreach($newsList as $item)
    <div class="news-item mb-4">
        <h4>{{ $item->title }}</h4>
        <p><a href="{{ route('news.show', $item->id) }}">Xem chi tiết</a></p>
    </div>
@endforeach

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            {{-- BÀI VIẾT --}}
            <div class="card mb-4">
                <img class="card-img-top" src="{{ $news->thumbNailUrl }}" alt="{{ $news->title }}">
                <div class="card-body">
                    <h2 class="card-title">{{ $news->title }}</h2>
                    <p class="card-text">{{ $news->content }}</p>
                    <p class="text-muted">Đăng bởi: {{ optional($news->manager)->fullName ?? 'Ẩn danh' }}
                        | {{ $news->created_at?->diffForHumans() }}</p>
                    <p class="text-muted">👁 {{ $news->views }} lượt xem</p>

                    <form method="POST" action="{{ route('news.save', $news->id) }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary">📌 Lưu bài viết</button>
                    </form>
                </div>
            </div>

            {{-- BÌNH LUẬN --}}
            <div class="card">
                <div class="card-body">
                    <h5>Bình luận</h5>
                    <form id="comment-form" method="POST" action="{{ route('comments.store', $news->id) }}">
                        @csrf
                        <input type="hidden" name="commentId" id="reply-to-id">
                        <textarea name="content" id="comment-content" class="form-control mb-2" rows="2"
                            placeholder="Viết bình luận..." required></textarea>
                        <button class="btn btn-primary">Gửi bình luận</button>
                    </form>

                    <hr>

                    @php $count = 0; $limit = 10; @endphp

                    @foreach($news->comments as $comment)
                    @break($count >= $limit)

                    <div class="mb-3 border-bottom pb-2">
                        <strong>{{ optional($comment->client)->fullName ?? 'Ẩn danh' }}</strong> <small
                            class="text-muted">{{ $comment->date?->diffForHumans() ?? 'Không rõ thời gian' }}</small>
                        <p>{{ $comment->content }}</p>
                        <div class="text-muted" data-id="{{ $comment->id }}">
                            <button onclick="react('{{ $comment->id }}', 'like')">👍 <span
                                    class="like-count">{{ $comment->like_count }}</span></button>
                            <button onclick="react('{{ $comment->id }}', 'dislike')">👎 <span
                                    class="dislike-count">{{ $comment->dislike_count }}</span></button>
                            <button onclick="react('{{ $comment->id }}', 'report')">🚩 <span
                                    class="report-count">{{ $comment->report_count }}</span></button>
                            <a href="#comment-form"
                                onclick="startReply('{{ $comment->id }}', '{{ optional($comment->client)->fullName }}')"
                                class="ml-3">Phản hồi</a>
                        </div>
                        @php $count++; @endphp

                        {{-- PHẢN HỒI --}}
                        @foreach ($comment->replies->where('commentId', $comment->id) as $reply)

                        @break($count >= $limit)
                        <div class="ml-4 mt-2 border-left pl-2">
                            <strong>{{ optional($reply->client)->fullName ?? 'Ẩn danh' }}</strong> <small
                                class="text-muted">{{ $reply->date?->diffForHumans() ?? 'Không rõ thời gian' }}</small>
                            <p>{{ $reply->content }}</p>
                            <div class="text-muted" data-id="{{ $reply->id }}">
                                <button onclick="react('{{ $reply->id }}', 'like')">👍 <span
                                        class="like-count">{{ $reply->like_count }}</span></button>
                                <button onclick="react('{{ $reply->id }}', 'dislike')">👎 <span
                                        class="dislike-count">{{ $reply->dislike_count }}</span></button>
                                <button onclick="react('{{ $reply->id }}', 'report')">🚩 <span
                                        class="report-count">{{ $reply->report_count }}</span></button>
                                <a href="#comment-form"
                                    onclick="startReply('{{ $reply->id }}', '{{ optional($reply->client)->fullName }}')"
                                    class="ml-3">Phản hồi</a>
                            </div>
                        </div>
                        @php $count++; @endphp
                        @endforeach
                    </div>
                    @endforeach

                    {{-- XEM THÊM --}}
                    @if(count($news->comments) > 0 && $count >= $limit)
                    <div class="text-center">
                        <a href="{{ route('comments.index', $news->id) }}"
                            class="btn btn-sm btn-outline-secondary">Xem thêm bình luận...</a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@if(session('scroll_to_comment'))
<script>
    window.onload = () => {
        document.getElementById("comment-form")?.scrollIntoView({
            behavior: 'smooth'
        });
    };
</script>
@endif

<script>
    function startReply(id, name = '') {
        const input = document.getElementById('reply-to-id');
        const textarea = document.getElementById('comment-content');
        if (input) input.value = id;
        if (textarea && name && !textarea.value.startsWith(`@${name}`)) {
            textarea.value = `@${name} `;
        }
        document.getElementById('comment-form')?.scrollIntoView({
            behavior: 'smooth'
        });
    }

    function react(commentId, type) {
        fetch(`/comments/${commentId}/${type}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                const wrapper = document.querySelector(`[data-id='${commentId}']`);
                if (wrapper) {
                    wrapper.querySelector(`.${type}-count`).innerText = data[`${type}_count`];
                }
            })
            .catch(() => alert(`Không thể ${type} bình luận.`));
    }
</script>
@endsection