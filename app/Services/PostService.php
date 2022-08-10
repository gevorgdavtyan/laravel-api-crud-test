<?php

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class PostService
{

    /**
     * @var PostRepository
     */
    protected PostRepository $postRep;

    /**
     *
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRep = $postRepository;
    }

    /**
     * @param $id
     * @return PostResource
     */
    public function getOne($id): PostResource
    {
        $post = $this->postRep->find($id);
        return new PostResource($post);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getAll(): AnonymousResourceCollection
    {
        return PostResource::collection($this->postRep->getAll());
    }

    /**
     * @param array $params
     * @return PostResource
     */
    public function create(array $params): PostResource
    {
        $validator = Validator::make($params, [
            'title' => 'required|max:70',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return new PostResource($this->postRep->save($params));
    }

    /**
     * @param $post
     * @param $params
     * @return PostResource
     */
    public function update($post, $params): PostResource
    {
        $validator = Validator::make($params, [
            'title' => 'required|max:70',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return new PostResource($this->postRep->updateOwnPost($post, $params));
    }

    /**
     * @param $post
     * @return bool|null
     */
    public function delete($post): ?bool
    {
        return $this->postRep->deleteOwnPost($post);
    }

}
