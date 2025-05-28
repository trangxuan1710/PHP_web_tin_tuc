<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clients;
use App\Models\News;
use App\Models\Comment;
use Illuminate\Support\Carbon;

class CommentTestSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 1 client
        $client = Clients::create(['name' => 'dii']);

        // Tạo 1 bài viết
        $news = News::create(['title' => 'Bài viết test', 'content' => 'Nội dung bài viết demo']);

        // Tạo bình luận gốc
        $comment1 = Comment::create([
            'clientId' => $client->id,
            'content' => 'Bình luận đầu tiên',
            'date' => Carbon::now(),
            'like_count' => 0,
            'commentId' => null,
        ]);
        $comment1->news()->attach($news->id);

        $comment2 = Comment::create([
            'clientId' => $client->id,
            'content' => 'Bình luận thứ hai',
            'date' => Carbon::now()->addSeconds(10),
            'like_count' => 0,
            'commentId' => null,
        ]);
        $comment2->news()->attach($news->id);

        // Phản hồi cho comment1
        $reply1 = Comment::create([
            'clientId' => $client->id,
            'content' => '@dii Đây là phản hồi đầu tiên',
            'date' => Carbon::now()->addSeconds(20),
            'like_count' => 0,
            'dislike_count' => 0,
            'commentId' => $comment1->id,
        ]);
        $reply1->news()->attach($news->id);

        // Phản hồi cho phản hồi (reply1)
        $reply2 = Comment::create([
            'clientId' => $client->id,
            'content' => '@dii Phản hồi của phản hồi!',
            'date' => Carbon::now()->addSeconds(30),
            'like_count' => 0,
            'dislike_count' => 0,
            'commentId' => $reply1->id,
        ]);
        $reply2->news()->attach($news->id);

        echo "✔️ Dữ liệu test đã được chèn!\n";
    }


}
