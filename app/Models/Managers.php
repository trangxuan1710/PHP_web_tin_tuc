<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Managers extends Model
{
    use HasFactory;
    protected $table = 'managers';
    protected $primaryKey = 'id';
    public $keyType = 'int';
    public $incrementing = true;

    public $timestamps = true;
    protected $fillable = [
        'fullName',
        'email',
        'password',
        'role', // Thêm 'role' vào đây

    ];
    protected $hidden = [
        'password',
    ];
    protected $casts = [
//        'password' => 'hashed',
        'isActive' => 'boolean',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}

