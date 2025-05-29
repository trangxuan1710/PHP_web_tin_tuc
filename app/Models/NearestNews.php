<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class NearestNews extends Pivot
{
    use HasFactory;

    protected $table = 'nearest_news';

    // Bảng trung gian không có khóa chính tự tăng
    public $incrementing = false;

    // Khóa chính tổng hợp
    protected $primaryKey = ['clientId', 'newsId'];

    protected $fillable = [
        'clientId',
        'newsId',
    ];

    protected $cast = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsToMany(Clients::class, 'clientId');
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'newsId');
    }
}
