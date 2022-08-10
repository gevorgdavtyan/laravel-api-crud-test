<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @class Comment
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string $comment
 * @property int|null $parent_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static query
 * @method static where
 * @method static insert
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'parent_id',
    ];

    /**
     * Get the user associated with the comment.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get the post associated with the comment.
     */
    public function post(): HasOne
    {
        return $this->hasOne(Post::class, 'id', 'post_id');
    }

    /**
     * Get the parent comment associated with the comment.
     */
    public function parent(): HasOne
    {
        return $this->hasOne(Comment::class, 'id', 'parent_id');
    }

}
