<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';

    public $timestamps = false;

    const UPDATED_AT = 'date';
    const CREATED_AT = null;

    protected $fillable = [
        'title',
        'userId',
        'date',
        'tag',
        'content',
        'thumbNailUrl',
        'isHot',
        'labelId',
    ];

    protected $casts = [
        'isHot' => 'boolean',
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'userId');
    }
    public function comments()
    {
        return $this->belongsToMany(Comments::class, 'comment_news', 'newsId', 'commentId');
    }
    public function label()
    {
        return $this->belongsTo(Labels::class, 'labelId');
    }
}
