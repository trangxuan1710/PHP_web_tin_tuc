<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Clients extends Model
{
    use HasFactory, Notifiable;

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
}
