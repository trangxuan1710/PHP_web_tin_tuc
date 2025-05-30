<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Thay vì Model thông thường


class Clients extends Authenticatable
{
    use HasFactory;

    protected $table = 'clients';
    protected $primaryKey = 'id';
    public $keyType = 'int'; // Mặc định là 'int' nên không bắt buộc khai báo
    public $incrementing = true; // Mặc định là true cho 'int' primary key nên không bắt buộc

    public $timestamps = true; // có sử dụng create_at và update_at

    protected $fillable = [
        'fullName',
        'bio',
        'email',
        'password',
        'isMute',
        'avatarUrl',
        'isActive',
    ];

    protected $hidden = [
        'password',
        // 'remember_token', // Thường thì remember_token cũng được ẩn nếu bạn dùng tính năng "remember me"
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'isMute' => 'boolean',
        'isActive' => 'boolean',
    ];

    // Các relationships của bạn
    public function sentNotifications()
    {
        // Giả định Notifications model nằm trong App\Models
        return $this->hasMany(Notifications::class, 'replierId');
    }

    public function receivedNotifications()
    {
        // Giả định Notifications model nằm trong App\Models
        return $this->hasMany(Notifications::class, 'clientId');
    }

    public function saveNews()
    {
        return $this->belongsToMany(News::class, 'save_news', 'clientId', 'newsId')->withTimestamps();
    }

    public function nearestNews()
    {
        return $this->belongsToMany(News::class, 'nearest_news', 'clientId', 'newsId')->withTimestamps();
    }

}