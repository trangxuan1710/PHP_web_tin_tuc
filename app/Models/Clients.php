<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Thay vì Model thông thường


class Clients extends Authenticatable
{
    use HasFactory;

    protected $table = 'clients';
    protected $primaryKey = 'id';
    public $keyType = 'int';
    public $incrementing = true;

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
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'isMute' => 'boolean',
        'isActive' => 'boolean',
    ];

    public function sentNotifications()
    {
        return $this->hasMany(Notifications::class, 'replierId');
    }

    public function receivedNotifications()
    {
        return $this->hasMany(Notifications::class, 'clientId');
    }

    public function savedNews()
    {
        return $this->belongsToMany(News::class, 'save_news', 'clientId', 'newsId')
            ->using(SaveNews::class)
            ->withTimestamps();
    }

    public function nearestNews()
    {
        return $this->belongsToMany(News::class, 'nearest_news', 'clientId', 'newsId')
        ->using(NearestNews::class);
    }
}
