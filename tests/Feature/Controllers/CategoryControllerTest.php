<?php

namespace Tests\Feature\Controllers;

use App\Events\CategoryCreated;
use App\Events\CategoryDeleted;
use App\Events\CategoryUpdated;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testIndexCategories(): void
    {
        $parent = Category::factory()->create();
        Category::factory()->withParent($parent)->create();

        $this
            ->actingAs($this->user)
            ->getJson(route('categories.index'))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'slug',
                        'parent_id',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'code'
            ]);
    }

    public function testShowCategory(): void
    {
        $category = Category::factory()->create();

        $this
            ->actingAs($this->user)
            ->getJson(route('categories.show', ['category' => $category->id]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'slug',
                    'parent_id',
                    'created_at',
                    'updated_at',
                ],
                'code'
            ]);
    }

    public function testStoreCategory(): void
    {
        Event::fake();

        $data = [
            'name' => [
                'pl' => $this->faker->word
            ],
            'description' => [
                'pl' => $this->faker->sentence
            ],
        ];

        $this
            ->actingAs($this->user)
            ->postJson(route('categories.store'), $data)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'slug',
                    'parent_id',
                    'created_at',
                    'updated_at',
                ],
                'code'
            ]);

        Event::assertDispatched(CategoryCreated::class);

        $this->assertDatabaseHas(Category::class, [
            'name->pl' => $data['name']['pl'],
            'description->pl' => $data['description']['pl'],
        ]);
    }

    public function testUpdateCategory(): void
    {
        Event::fake();

        $category = Category::factory()->create();

        $data = [
            'name' => [
                'pl' => $this->faker->word
            ],
            'description' => [
                'pl' => $this->faker->sentence
            ],
        ];

        $this
            ->actingAs($this->user)
            ->putJson(route('categories.update', ['category' => $category->id]), $data)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'slug',
                    'parent_id',
                    'created_at',
                    'updated_at',
                ],
                'code'
            ]);

        Event::assertDispatched(CategoryUpdated::class);

        $this->assertDatabaseHas(Category::class, [
            'id' => $category->id,
            'name->pl' => $data['name']['pl'],
            'description->pl' => $data['description']['pl'],
        ]);
    }

    public function testDestroyCategory(): void
    {
        Event::fake();

        $category = Category::factory()->create();

        $this
            ->actingAs($this->user)
            ->deleteJson(route('categories.destroy', ['category' => $category->id]))
            ->assertOk()
            ->assertJsonStructure([
                'code'
            ]);

        Event::assertDispatched(CategoryDeleted::class);

        $this->assertSoftDeleted(Category::class, [
            'id' => $category->id,
        ]);
    }
}
