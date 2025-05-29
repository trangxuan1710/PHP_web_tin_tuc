<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SaveNews extends Pivot
{
    use HasFactory;

    protected $table = 'save_news';

    // Bảng trung gian không có khóa chính tự tăng
    public $incrementing = false;

    // Khóa chính tổng hợp
    protected $primaryKey = ['clientId', 'newsId'];

    // Bảng trung gian này không có các cột timestamp
    public $timestamps = true;

    protected $fillable = [
        'clientId',
        'newsId',
    ];

    protected $cast = [
        'created_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'clientId');
    }

    public function news()
    {
        return $this->belongsTo(News::class, 'newsId');
    }
}
