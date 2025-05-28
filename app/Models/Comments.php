<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $table = 'comments';

    public $timestamps = false;

    const CREATED_AT = 'date';
    const UPDATED_AT = null;

    protected $fillable = [
        'clientId',
        'content',
        'date',
        'like_count',
        'commentId',
        'newsId',
    ];

    protected $casts = [
        'date' => 'datetime',
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
