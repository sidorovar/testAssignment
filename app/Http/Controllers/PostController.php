<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequestCreate;
use App\Services\PostService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
class PostController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var PostService
     */
    private $postService;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $posts = $this->postService->getAllPosts();

        return response()->json($posts);
    }

    /**
     * @param PostRequestCreate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequestCreate $request): JsonResponse
    {
        try {
            $this->postService->createPost($request);

            return response()->json(null, Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $post = $this->postService->getPostById($request->get('id'));

        if (!$post) {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        }

        return response()->json($post);
    }

    /**
     * @param int $postId
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $postId, Request $request): JsonResponse
    {
        $result = $this->postService->deletePostById($postId);

        return response()->json($result, $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
