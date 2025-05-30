<?php

// app/Models/CommentLike.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class CommentLike extends Model
{
    use HasFactory;

    protected $table = 'comment_like';
    protected $primaryKey = 'id';
    public $keyType = 'int';
    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'clientId',
        'commentId',
    ];

    /**
     * Lấy người dùng đã like.
     */
    public function client()
    {
        return $this->belongsTo(Clients::class, 'clientId');
    }

    /**
     * Lấy comment được like.
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'commentId');
    }
}