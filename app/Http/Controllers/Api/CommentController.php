<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Services\CommentService;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    /**
     * @var CommentService
     */
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return JsonResponse
     */
    public function store(Request $request, Post $post): JsonResponse
    {
        try {
            $result = $this->commentService->create($post, $request->all());
        } catch (Exception $exception) {
            return $this->sendError('Validation Error.', ['error' => $exception->getMessage()], 422);
        }

        return $this->sendResponse($result, 'Comment created successfully.');
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function showPostComments(Post $post): JsonResponse
    {
        try {
            $result = $this->commentService->getPostCommentsWithChildren($post);
        } catch (Exception $exception) {
            return $this->sendError('Post not found.', ['error' => $exception->getMessage()]);
        }

        return $this->sendResponse($result, 'Comment retrieved successfully.');
    }

}
