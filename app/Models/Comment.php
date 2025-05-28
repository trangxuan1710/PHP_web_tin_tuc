<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
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
        return $this->belongsTo(News::class,  'newsId');
    }
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'commentId');
    }

    // Quan hệ phản hồi
//    public function replies()
//    {
//        return $this->hasMany(Comment::class, 'commentId');
//    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'commentId')->orderBy('date', 'asc');
    }



}
