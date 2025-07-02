<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'parent_id' => null,
            'name' => ['pl' => $this->faker->word()],
            'slug' => ['pl' => $this->faker->slug()],
            'description' => ['pl' => $this->faker->sentence()],
            'image' => $this->faker->filePath(),
        ];
    }

    public function withParent(Category $parent): static
    {
        return $this->state(fn(array $attributes) => [
            'parent_id' => $parent->id,
        ]);
    }
}
