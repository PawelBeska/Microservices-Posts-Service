<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Posts\SavePostAction;
use App\Data\Posts\SavePostData;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PostsController extends Controller
{

    public function store(SavePostData $data): JsonResponse
    {
        $post = SavePostAction::run($data);

        return $this->successResponse(
            $post
        );
    }
}
