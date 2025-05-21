<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labels extends Model
{
    use HasFactory;
    protected $table = 'labels';
    protected $primaryKey = 'id';
    public $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'type'
    ];

}
