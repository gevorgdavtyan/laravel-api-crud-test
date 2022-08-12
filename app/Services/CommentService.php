<?php

namespace App\Services;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class CommentService
{
    /**
     * @var CommentRepository
     */
    protected CommentRepository $commentRep;

    public function __construct(CommentRepository $commentRep)
    {
        $this->commentRep = $commentRep;
    }

    /**
     * @param $post
     * @param array $params
     * @return CommentResource
     */
    public function create($post, array $params)
    {
        $validator = Validator::make($params, [
            'comment' => 'required|max:255',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return new CommentResource($this->commentRep->save($post, $params));
    }

    /**
     * @param \App\Models\Post $post
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPostCommentsWithChildren(\App\Models\Post $post)
    {
        if (!$post) {
            throw new ModelNotFoundException('Post not found.');
        }

        return $this->commentRep->getPostCommentsWithChildren($post);
    }

}
