<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $primaryKey = 'id';
    public $keyType = 'int';
    public $incrementing = true;

    public $timestamps = true; // có sử dụng create_at và update_at


    protected $fillable = [
        'fullName',
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
        'password' => 'hashed',
        'isMute' => 'boolean',
        'isActive' => 'boolean',
    ];
}
