<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';

    public $timestamps = false;
    protected $primaryKey = 'id';
    public $keyType = 'int';
    public $incrementing = true;
    const UPDATED_AT = 'date';
    const CREATED_AT = null;

    protected $fillable = [
        'title',
        'managerId',
        'views',
        'userId',
        'date',
        'tag',
        'content',
        'status',
        'thumbNailUrl',
        'isHot',
        'labelId',
    ];

    protected $casts = [
        'isHot' => 'boolean',
        'date' => 'datetime',
    ];

    public function manager()
    {
        return $this->belongsTo(Managers::class, 'managerId');
    }
    public function comments()
    {
        return $this->belongsToMany(Comments::class, 'comment_news', 'newsId', 'commentId');
    }
    public function label()
    {
        return $this->belongsTo(Label::class, 'labelId');
    }
    public function incrementViews()
    {
        $this->increment('views');
    }
    public function savedByClients()
    {
        return $this->belongsToMany(Clients::class, 'saved_news', 'news_id', 'client_id')->withTimestamps();
    }


}
