<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {


        $newsData = [
            [
                'title' => 'Mỹ - Trung Quốc hoãn áp thuế 90 ngày',
                'managerId' => 1, // Thay bằng ID manager có thật trong DB của bạn
                'date' => Carbon::now()->subDays(5),
                'tag' => 'kinh_te,chinh_tri', // Thay thế category bằng tag
                'content' => 'Sau cuộc đàm phán cuối tuần trước, Mỹ và Trung Quốc thống nhất tạm hoãn một phần thuế đối ứng trong 90 ngày, đồng thời giảm đáng kể tổng thuế nhập khẩu. Đây là một tin tức quan trọng ảnh hưởng đến nền kinh tế toàn cầu.', // Thay thế description
                'status' => 'published',
                'thumbNailUrl' => 'https://via.placeholder.com/180x120?text=US-China', // Thay thế image_url
                'isHot' => true,
                'labelId' => 1, // Thay bằng ID label có thật trong DB của bạn
            ],
            [
                'title' => 'Công nghệ AI đang thay đổi thế giới như thế nào?',
                'managerId' => 2,
                'date' => Carbon::now()->subDays(2),
                'tag' => 'cong_nghe,khoa_hoc',
                'content' => 'Trí tuệ nhân tạo đang tạo ra những bước đột phá đáng kinh ngạc trong nhiều lĩnh vực, từ y tế đến giao thông vận tải, mang lại nhiều tiện ích và thách thức mới.',
                'status' => 'published',
                'thumbNailUrl' => 'https://via.placeholder.com/180x120?text=AI-Tech',
                'isHot' => false,
                'labelId' => 2,
            ],
            [
                'title' => 'Tình hình chính trị thế giới tuần qua',
                'managerId' => 1,
                'date' => Carbon::now()->subHours(10),
                'tag' => 'chinh_tri,the_gioi',
                'content' => 'Điểm lại những sự kiện chính trị nổi bật trên toàn cầu, phân tích các diễn biến đáng chú ý và dự báo xu hướng tương lai.',
                'status' => 'published',
                'thumbNailUrl' => 'https://via.placeholder.com/180x120?text=Politics',
                'isHot' => true,
                'labelId' => 1,
            ],
            [
                'title' => 'Thị trường chứng khoán phục hồi mạnh mẽ',
                'managerId' => 3,
                'date' => Carbon::now()->subDays(1),
                'tag' => 'kinh_doanh,tai_chinh',
                'content' => 'Các chỉ số chính của thị trường chứng khoán toàn cầu đồng loạt tăng điểm, cho thấy tín hiệu lạc quan về sự phục hồi của nền kinh tế sau một giai đoạn khó khăn.',
                'status' => 'published',
                'thumbNailUrl' => 'https://via.placeholder.com/180x120?text=Stocks',
                'isHot' => false,
                'labelId' => 1,
            ],
            [
                'title' => 'Giải pháp cho vấn đề ô nhiễm không khí đô thị',
                'managerId' => 2,
                'date' => Carbon::now()->subWeeks(1),
                'tag' => 'xa_hoi,moi_truong',
                'content' => 'Một nghiên cứu mới đề xuất các biện pháp hiệu quả nhằm giảm thiểu ô nhiễm không khí tại các thành phố lớn, bao gồm các chính sách và công nghệ mới.',
                'status' => 'published',
                'thumbNailUrl' => 'https://via.placeholder.com/180x120?text=Pollution',
                'isHot' => false,
                'labelId' => 3,
            ],
        ];

        foreach ($newsData as $data) {
            News::create($data);
        }
    }
}
