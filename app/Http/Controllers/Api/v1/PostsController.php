<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Posts\SavePostAction;
use App\Data\Posts\SavePostData;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRequest;
use App\Http\Resources\Posts\PostCollection;
use App\Http\Resources\Posts\PostResource;
use App\Interfaces\Repositories\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostsController extends Controller
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
    ) {
    }

    public function index(IndexRequest $request): JsonResponse
    {
        $posts = $this->postRepository->getPaginated(
            $request->perPage()
        );

        return $this->successResponse(
            PostCollection::make($posts),
        );
    }

    public function show(Post $post): JsonResponse
    {
        return $this->successResponse(
            PostResource::make($post),
        );
    }

    public function store(SavePostData $data): JsonResponse
    {
        $post = SavePostAction::run($data);

        return $this->successResponse(
            PostResource::make($post),
        );
    }

    public function update(SavePostData $data, Post $post): JsonResponse
    {
        $post = SavePostAction::run($data, $post);

        return $this->successResponse(
            PostResource::make($post),
        );
    }

    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return $this->codeResponse();
    }
}
