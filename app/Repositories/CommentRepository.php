<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CommentRepository
{
    /**
     * @var Comment $comment
     */
    protected Comment $comment;

    /**
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Returns Comment or thrown exception
     *
     * @param int $id
     * @return Comment
     */
    public function find(int $id): Comment
    {
        return Comment::query()->findOrFail($id);
    }

    /**
     * @param $post
     * @param array $params
     * @return mixed
     */
    public function save($post, array $params): mixed
    {
        $comment = Auth::user()->comments()->save(new $this->comment([
            'comment' => $params['comment'],
            'post_id' => $post->id,
            'parent_id' => $params['parent_id'] ?? null,
        ]));

        return $comment->fresh();
    }

    /**
     * @param Post $post
     * @return Collection
     */
    public function getPostCommentsWithChildren(Post $post): Collection
    {
        return $post->commentsWithChildren()->get();
    }

}
