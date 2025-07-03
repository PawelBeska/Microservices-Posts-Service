<?php

namespace App\Http\Resources\PostMedia;

use App\Models\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PostMedia
 *
 */
class PostMediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'post_id' => $this->post_id,
            'order' => $this->order,
            'disk' => $this->disk,
            'path' => $this->path,
            'url' => $this->url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
