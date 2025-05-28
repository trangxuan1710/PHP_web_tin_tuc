@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Bình luận cho bài viết</h4>

        {{-- Danh sách bình luận + phản hồi --}}
        <div id="comments-wrapper" class="card p-3">
            @foreach ($comments as $comment)
                <div class="border-bottom mb-2 pb-2">
                    <strong>{{ optional($comment->client)->name ?? 'Ẩn danh' }}</strong>: {{ $comment->content }}
                    <div class="text-muted" data-id="{{ $comment->id }}">
                        <button onclick="react('{{ $comment->id }}', 'like')">👍 <span class="like-count">{{ $comment->like_count }}</span></button>
                        <button onclick="react('{{ $comment->id }}', 'dislike')">👎 <span class="dislike-count">{{ $comment->dislike_count }}</span></button>
                        <button onclick="react('{{ $comment->id }}', 'report')">🚩 <span class="report-count">{{ $comment->report_count }}</span></button>
                        <a href="#comment-form" onclick="startReply({{ $comment->id }}, '{{ optional($comment->client)->name ?? '' }}')" class="ml-3">Phản hồi</a>
                    </div>

                    {{-- Phản hồi --}}
                    @foreach ($comment->replies as $reply)
                        <div class="ml-4 mt-2">
                            <strong>{{ optional($reply->client)->name ?? 'Ẩn danh' }}</strong>: {{ $reply->content }}
                            <div class="text-muted" data-id="{{ $reply->id }}">
                                <button onclick="react('{{ $reply->id }}', 'like')">👍 <span class="like-count">{{ $reply->like_count }}</span></button>
                                <button onclick="react('{{ $reply->id }}', 'dislike')">👎 <span class="dislike-count">{{ $reply->dislike_count }}</span></button>
                                <button onclick="react('{{ $reply->id }}', 'report')">🚩 <span class="report-count">{{ $reply->report_count }}</span></button>
                                <a href="#comment-form" onclick="startReply({{ $reply->id }}, '{{ optional($reply->client)->name ?? '' }}')" class="ml-3">Phản hồi</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            {{-- Phân trang --}}
            <div class="mt-3">
                {{ $comments->links() }}
            </div>
        </div>

        {{-- Form bình luận --}}
        <form id="comment-form" class="mt-4">
            @csrf
            <input type="hidden" name="commentId" id="commentId">
            <input type="hidden" name="newsId" id="newsId" value="{{ $newsId }}">
            <textarea name="content" id="content" class="form-control" rows="2" placeholder="Viết bình luận..." required></textarea>
            <button type="submit" class="btn btn-primary mt-2">Gửi</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function startReply(id, name) {
            document.getElementById('commentId').value = id;
            const textarea = document.getElementById('content');
            textarea.focus();
            if (name) {
                textarea.value = `@${name} `;
            }
        }

        document.getElementById('comment-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch(`/news/${formData.get('newsId')}/comments`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value
                },
                body: formData
            })
                .then(response => response.ok ? location.reload() : alert('Thất bại khi gửi bình luận'));
        });

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
                .catch(() => alert(`Không thể ${type} bình luận do chưa đăng nhập.`));
        }
    </script>
@endpush
