<?php

namespace Database\Factories;

use App\Enums\PostServiceTypeEnum;
use App\Enums\ServiceEnum;
use App\Models\Category;
use App\Models\External;
use App\Models\Post;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Post
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => External::factory()
                ->withService(ServiceEnum::USERS),
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'category_id' => Category::factory(),
            'pickup_country' => $this->faker->countryCode,
            'pickup_city' => $this->faker->city,
            'pickup_postal_code' => $this->faker->postcode,
            'pickup_address' => $this->faker->address,
            'pickup_location' => Point::make(
                $this->faker->latitude,
                $this->faker->longitude,
            ),
            'delivery_country' => $this->faker->countryCode,
            'delivery_city' => $this->faker->city,
            'delivery_postal_code' => $this->faker->postcode,
            'delivery_address' => $this->faker->address,
            'delivery_location' => Point::make(
                $this->faker->latitude,
                $this->faker->longitude,
            ),
            'pickup_date_from' => $this->faker->dateTimeBetween('now', '+1 month'),
            'pickup_date_to' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'delivery_date_from' => $this->faker->dateTimeBetween('now', '+1 month'),
            'delivery_date_to' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'cargo' => [
                [
                    'name' => $this->faker->word,
                    'quantity' => $this->faker->numberBetween(1, 10),
                    'length' => $this->faker->numberBetween(1, 200),
                    'weight' => $this->faker->numberBetween(1, 1000),
                    'width' => $this->faker->numberBetween(1, 100),
                    'height' => $this->faker->numberBetween(1, 100),

                ]
            ],
            'service_type' => $this->faker->randomElement(PostServiceTypeEnum::cases()),
            'pickup_floor' => $this->faker->optional()->numberBetween(0, 20),
            'pickup_elevator' => $this->faker->boolean,
            'delivery_floor' => $this->faker->optional()->numberBetween(0, 20),
            'delivery_elevator' => $this->faker->boolean,
            'as_company' => $this->faker->boolean,
            'company_country' => $this->faker->optional()->countryCode,
        ];
    }

    public function withUser(External $user): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
        ]);
    }
}
