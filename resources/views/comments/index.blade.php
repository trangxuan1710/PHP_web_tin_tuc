@extends('layouts.app')

@section('content')
        <div x-data="commentApp({{ $newsId }})" class="max-w-3xl mx-auto mt-8 p-4 border rounded">
            <template x-for="comment in comments" :key="comment.id">
                <div class="p-2 border-b">
                    <strong x-text="comment.client.name"></strong>: <span x-text="comment.content"></span>
                    <div class="space-x-2 mt-1">
                        <button @click="like(comment.id)">👍 <span x-text="comment.like_count"></span></button>
                        <button @click="dislike(comment.id)">👎 <span x-text="comment.dislike_count"></span></button>
                        <button @click="report(comment.id)">🚩 <span x-text="comment.report_count"></span></button>
                        <button @click="startReply(comment.id)">Phản hồi</button>
                    </div>

                    <div class="ml-6 mt-2" x-show="comment.replies.length">
                        <template x-for="reply in comment.replies" :key="reply.id">
                            <div>
                                <strong x-text="reply.client.name"></strong>: <span x-text="reply.content"></span>
                                <div class="text-sm space-x-2 mt-1">
                                    <button @click="like(reply.id)">👍 <span x-text="reply.like_count"></span></button>
                                    <button @click="dislike(reply.id)">👎 <span x-text="reply.dislike_count"></span></button>
                                    <button @click="report(reply.id)">🚩 <span x-text="reply.report_count"></span></button>
                                    <button @click="startReply(reply.id)">Phản hồi</button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <form method="POST" action="{{ route('comments.store') }}" class="mt-4">
                @csrf
                <input type="hidden" name="commentId" :value="replyTo">
                <input type="hidden" name="newsId" value="{{ $newsId }}">
                <textarea name="content" class="w-full border p-2 rounded" required placeholder="Viết bình luận..."></textarea>
                <button class="btn btn-primary mt-2">Gửi</button>
            </form>
        </div>


@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/comments.css') }}">
@endpush

@push('scripts')
    <script>

        function commentApp(newsId) {
            return {
                comments: window.__COMMENTS,
                replyTo: null,
                startReply(id) {
                    this.replyTo = id;
                },
                like(id) {
                    fetch(`/comments/${id}/like`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} })
                        .then(res => res.json())
                        .then(data => this.updateCount(id, 'like_count', data.like_count));
                },
                dislike(id) {
                    fetch(`/comments/${id}/dislike`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} })
                        .then(res => res.json())
                        .then(data => this.updateCount(id, 'dislike_count', data.dislike_count));
                },
                report(id) {
                    fetch(`/comments/${id}/report`, { method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} })
                        .then(res => res.json())
                        .then(data => this.updateCount(id, 'report_count', data.report_count));
                },
                updateCount(id, field, value) {
                    for (let comment of this.comments) {
                        if (comment.id === id) {
                            comment[field] = value;
                            return;
                        }
                        for (let reply of comment.replies) {
                            if (reply.id === id) {
                                reply[field] = value;
                                return;
                            }
                        }
                    }
                }
            }
        }

    </script>
@endpush

<script>
    window.__COMMENTS = @json($comments);
</script>
