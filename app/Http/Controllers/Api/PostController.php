<?php

namespace App\Http\Controllers\Api;

use App\Services\PostService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Post;
use InvalidArgumentException;

class PostController extends BaseController
{
    /**
     * @var PostService
     */
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->sendResponse($this->postService->getAll(), 'Posts retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $result = $this->postService->createNewPost($request->all());
        } catch (Exception $exception) {
            return $this->sendError('Validation Error.', ['error' => $exception->getMessage()], 422);
        }

        return $this->sendResponse($result, 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $result = $this->postService->getOne($id);
        } catch (Exception $exception) {
            return $this->sendError('Post not found.', ['error' => $exception->getMessage()]);
        }

        return $this->sendResponse($result, 'Post retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(Request $request, Post $post): JsonResponse
    {
        try {
            $result = $this->postService->updatePost($post, $request->all());
        } catch (InvalidArgumentException $exception) {
            return $this->sendError('Validation Error.', ['error' => $exception->getMessage()], 422);
        } catch (ModelNotFoundException $exception) {
            return $this->sendError('Post not found.', ['error' => $exception->getMessage()]);
        }

        return $this->sendResponse($result, 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        try {
            $this->postService->deletePost($post);
        } catch (Exception $exception) {
            return $this->sendError('Post not found.', ['error' => $exception->getMessage()]);
        }

        return $this->sendResponse([], 'Post deleted successfully.');
    }
}
