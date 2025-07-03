<?php

namespace App\Http\Resources\Posts;

use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\PostMedia\PostMediaResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Post
 *
 */
class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->externalUser->external_id,
            'user' => $this->whenLoaded('user', fn() => $this->user),
            'category_id' => $this->category_id,
            'category' => $this->whenLoaded('category', fn() => CategoryResource::make($this->category)),
            'media' => $this->whenLoaded('media', fn() => PostMediaResource::collection($this->media)),
            'title' => $this->title,
            'content' => $this->content,
            'pickup_country' => $this->pickup_country,
            'pickup_city' => $this->pickup_city,
            'pickup_postal_code' => $this->pickup_postal_code,
            'pickup_address' => $this->pickup_address,
            'pickup_location' => $this->pickup_location,
            'delivery_country' => $this->delivery_country,
            'delivery_city' => $this->delivery_city,
            'delivery_postal_code' => $this->delivery_postal_code,
            'delivery_address' => $this->delivery_address,
            'delivery_location' => $this->delivery_location,
            'pickup_date_from' => $this->pickup_date_from,
            'pickup_date_to' => $this->pickup_date_to,
            'delivery_date_from' => $this->delivery_date_from,
            'delivery_date_to' => $this->delivery_date_to,
            'cargo' => $this->cargo,
            'service_type' => $this->service_type->value,
            'pickup_floor' => $this->pickup_floor,
            'delivery_elevator' => $this->delivery_elevator,
            'delivery_floor' => $this->delivery_floor,
            'pickup_elevator' => $this->pickup_elevator,
            'as_company' => $this->as_company,
            'company_country' => $this->company_country,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
