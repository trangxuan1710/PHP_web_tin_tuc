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
    ];

    protected $casts = [
        // No specific casts needed for this table based on the schema
    ];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'clientId');
    }

    public function comment()
    {
        return $this->belongsTo(Comments::class, 'commentId');
    }
}
