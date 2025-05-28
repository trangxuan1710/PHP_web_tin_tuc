<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $primaryKey = 'id';

    public $keyType = 'int';    

    public $incrementing = true;

    protected $fillable = [
        'clientId',
        'replierId',
        'newsURL',
        'content',
        'isRead',
    ];

    protected $casts = [
        'isRead' => 'boolean',
        'clientId' => 'integer',
        'replierId' => 'integer',
        'created_at' => 'datetime',
    ];
    public $timestamps = false;

    public function client()
    {
        return $this->belongsTo(Clients::class, 'clientId');
    }
    public function replier()
    {
        return $this->belongsTo(Clients::class, 'replierId');
    }

    public function getReplierNameAttribute(): ?string
    {
        // Kiểm tra xem mối quan hệ 'replier' có tồn tại không
        // (tức là replierId có giá trị và tìm thấy người dùng tương ứng)
        if ($this->relationLoaded('replier') && $this->replier) {
            return $this->replier->fullName;
        }

        // Nếu mối quan hệ chưa được tải hoặc không tìm thấy replier,
        // thử tải eager load mối quan hệ và lấy tên
        if ($this->replier) { // Eloquent sẽ tự động tải mối quan hệ nếu chưa có
            return $this->replier->fullName;
        }

        return null; // Trả về null nếu không có replier hoặc không tìm thấy tên
    }

}
