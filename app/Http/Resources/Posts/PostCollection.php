<?php

namespace App\Http\Resources\Posts;

use App\Http\Resources\PaginationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => PostResource::collection($this->collection),
            'pagination' => new PaginationResource($this->resource),
        ];
    }
}
