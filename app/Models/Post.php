<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @class Post
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User[]|Collection $user
 * @property comments[]|Collection $comments
 * @property comments[]|Collection $commentsWithChildren
 * @method static query
 * @method static where
 * @method static insert
 */
class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    /**
     * Get the user associated with the post.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get the comments associated with the post.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    /**
     * Get the comments with children associated with the post.
     */
    public function commentsWithChildren(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id')
            ->with('children')
            ->whereNull('parent_id');
    }

}
