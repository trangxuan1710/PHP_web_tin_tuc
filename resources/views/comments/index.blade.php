@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto mt-8 p-4 border rounded" x-data="commentApp({{ $newsId }})">
        <template x-for="comment in comments" :key="comment.id">
            <div class="p-2 border-b">
                <strong x-text="comment.client.name"></strong>: <span x-text="comment.content"></span>
                <button class="reply-btn" @click="startReply(comment.id)">Phản hồi</button>

                <div class="ml-6" x-show="comment.replies.length">
                    <template x-for="reply in comment.replies" :key="reply.id">
                        <div class="mt-1">
                            <strong x-text="reply.client.name"></strong>: <span x-text="reply.content"></span>
                            <button class="reply-btn" @click="startReply(reply.id)">Phản hồi</button>
                        </div>
                    </template>
                </div>
            </div>
        </template>

        <!-- Form -->
        <form method="POST" action="{{ route('comments.store') }}" class="mt-4">
            @csrf
            <input type="hidden" name="commentId" :value="replyTo">
            <input type="hidden" name="newsId" value="{{ $newsId }}">
            <textarea name="content" class="w-full border p-2 rounded" placeholder="Viết bình luận..." required></textarea>
            <button class="btn-send">Gửi</button>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/comments.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/comments.js') }}"></script>
@endpush

<script>
    window.__COMMENTS = @json($comments);
</script>
