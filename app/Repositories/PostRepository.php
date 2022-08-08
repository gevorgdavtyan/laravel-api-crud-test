<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class PostRepository
{
    /**
     * @var Post $post
     */
    protected Post $post;

    /**
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Returns Post or thrown exception
     *
     * @param int $id
     * @return Post
     */
    public function find(int $id): Post
    {
        return Post::query()->findOrFail($id);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return Post::all();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function save(array $params): mixed
    {
        $post = new $this->post;
        $post->title = $params['title'];
        $post->description = $params['description'];
        $post->user_id = Auth::user()->id;
        $post->save();

        return $post->fresh();
    }

    /**
     * @param Post $post
     * @param array $params
     * @return Post|null
     */
    public function updateOwnPost(Post $post, array $params): ?Post
    {
        if (!$this->isOwnPost($post)) {
            throw new ModelNotFoundException('Post not found.');
        }

        $post->title = $params['title'];
        $post->description = $params['description'];
        $post->save();

        return $post->fresh();
    }

    /**
     * @param $post
     * @return bool
     */
    private function isOwnPost($post): bool
    {
        return $post->user_id == Auth::user()->id;
    }

    /**
     * @param Post $post
     * @return bool|null
     */
    public function deleteOwnPost(Post $post): ?bool
    {
        if (!$this->isOwnPost($post)) {
            throw new ModelNotFoundException('Post not found.');
        }

        return $post->delete();
    }

}
