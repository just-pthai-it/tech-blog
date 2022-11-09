<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'password',
        'email',
        'email_verified_at',
        'birth',
        'gender',
        'bio',
        'work',
        'education',
        'coding_skills',
        'role',
        'follower_count',
        'following_count',
        'trending_point',
        'github_email',
        'facebook_email',
        'google_email',
        'created_at',
        'update_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts () : BelongsToMany
    {
        return $this->belongsToMany(Post::class)
                    ->withPivot(['is_like', 'is_share', 'is_save', 'search_count']);
    }
}
