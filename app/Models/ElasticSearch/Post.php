<?php

namespace App\Models\ElasticSearch;

use PDPhilip\Elasticsearch\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $connection = 'elasticsearch';

    public function fillFromModel(\App\Models\Post $post): self
    {
        return $this->fill(
            [
                'id' => $post->id,
                'user_id' => $post->externalUser->external_id,
                'category_id' => $post->category_id,
                'pickup_country' => $post->pickup_country,
                'pickup_city' => $post->pickup_city,
                'pickup_postal_code' => $post->pickup_postal_code,
                'pickup_address' => $post->pickup_address,
                'pickup_location' => $post->pickup_location,
                'delivery_country' => $post->delivery_country,
                'delivery_city' => $post->delivery_city,
                'delivery_postal_code' => $post->delivery_postal_code,
                'delivery_address' => $post->delivery_address,
                'pickup_date_from' => $post->pickup_date_from?->toIso8601String(),
                'pickup_date_to' => $post->pickup_date_to?->toIso8601String(),
                'delivery_date_from' => $post->delivery_date_from?->toIso8601String(),
                'delivery_date_to' => $post->delivery_date_to?->toIso8601String(),
                'cargo' => $post->cargo->toArray(),
                'service_type' => $post->service_type->value,
                'pickup_floor' => $post->pickup_floor,
                'pickup_elevator' => $post->pickup_elevator,
                'delivery_floor' => $post->delivery_floor,
                'delivery_elevator' => $post->delivery_elevator,
                'as_company' => $post->as_company,
                'company_country' => $post->company_country,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ]
        );
    }
}
