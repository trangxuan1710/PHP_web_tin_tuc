<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            News::create([
                'title' => "Bản tin số $i",
                'views' => rand(50, 200),
                'userId' => 1, // nếu chưa có userId thì bạn có thể để null
                'date' => now()->subDays($i),
                'tag' => 'Tin nóng',
                'content' => "Đây là nội dung của bản tin số $i. Đây chỉ là mô phỏng dữ liệu.",
                'thumbNailUrl' => "https://via.placeholder.com/600x300?text=Tin+$i",
                'isHot' => $i % 2 == 0,
                'labelId' => 1, // bạn có thể điều chỉnh theo dữ liệu thật
            ]);
        }
    }
}
