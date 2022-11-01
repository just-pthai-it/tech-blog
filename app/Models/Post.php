<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'mode',
        'view_count',
        'like_count',
        'share_count',
        'trending_point',
        'user_id',
        'created_at',
        'update_at',
        'deleted_at',
    ];

    public function user () : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
