<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'reason',
        'content',
        'clientId',
        'commentId',
        'create_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',

    ];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'clientId');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'commentId');
    }
}
