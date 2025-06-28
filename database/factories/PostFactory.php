<?php

namespace Database\Factories;

use App\Enums\ServiceEnum;
use App\Models\External;
use App\Models\Post;
use App\Models\Service;
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
        ];
    }

    public function withService(ServiceEnum $service): static
    {
        return $this->state(fn(array $attributes) => [
            'service_id' => Service::query()->firstWhere('service', $service) ?? Service::factory()->withService($service),
        ]);
    }

    public function withUser(External $user): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
        ]);
    }
}
