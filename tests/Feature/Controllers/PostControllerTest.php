<?php

namespace Tests\Feature\Controllers;

use App\Enums\PostServiceTypeEnum;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexPosts(): void
    {
        Http::fake(
            [
                '*' => Http::response([

                    'data' => [
                        [
                            'id' => $this->externalUser->external_id,
                            'name' => $this->faker->name,
                            'email' => $this->faker->email,
                            'created_at' => $this->faker->date,
                            'updated_at' => $this->faker->date,
                        ]
                    ],
                    'code' => 200
                ])
            ]
        );

        Post::factory()
            ->withUser($this->externalUser)
            ->count(5)->create();


        $this
            ->actingAs($this->user)
            ->getJson(
                route(
                    'posts.index',
                    [
                        'include' => [
                            'user',
                            'category',
                            'media',
                        ]
                    ]
                )
            )
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'data' =>
                        [
                            [
                                'title',
                                'content',
                                'category_id',
                                'pickup_country',
                                'pickup_city',
                                'pickup_location',
                                'delivery_country',
                                'delivery_city',
                                'delivery_location',
                                'pickup_date_from',
                                'pickup_date_to',
                                'delivery_date_from',
                                'delivery_date_to',
                                'cargo',
                                'service_type',
                                'pickup_floor',
                                'delivery_elevator',
                                'delivery_floor',
                                'pickup_elevator',
                                'as_company',
                                'company_country',
                                'created_at',
                                'updated_at',

                            ],
                        ],
                    'pagination' => [
                        'total',
                        'count',
                        'per_page',
                        'current_page',
                        'total_pages'
                    ]
                ],
                'code'
            ]);
    }

    public function testShowPosts(): void
    {
        Http::fake(
            [
                '*' => Http::response([

                    'data' => [
                        [
                            'id' => $this->externalUser->external_id,
                            'name' => $this->faker->name,
                            'email' => $this->faker->email,
                            'created_at' => $this->faker->date,
                            'updated_at' => $this->faker->date,
                        ]
                    ],
                    'code' => 200
                ])
            ]
        );

        $post = Post::factory()->create();

        $this
            ->actingAs($this->user)
            ->getJson(route('posts.show', ['post' => $post->id]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'title',
                    'content',
                    'category_id',
                    'pickup_country',
                    'pickup_city',
                    'pickup_location',
                    'delivery_country',
                    'delivery_city',
                    'delivery_location',
                    'pickup_date_from',
                    'pickup_date_to',
                    'delivery_date_from',
                    'delivery_date_to',
                    'cargo',
                    'service_type',
                    'pickup_floor',
                    'delivery_elevator',
                    'delivery_floor',
                    'pickup_elevator',
                    'as_company',
                    'company_country',
                    'created_at',
                    'updated_at',
                ],
                'code'
            ]);
    }

    public function testStorePost(): void
    {
        $postData = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->text,
            'category_id' => Category::factory()->create()->id,
            'pickup_country' => $this->faker->countryCode,
            'pickup_city' => $this->faker->city,
            'pickup_location' => [
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude,
            ],
            'delivery_country' => $this->faker->countryCode,
            'delivery_city' => $this->faker->city,
            'delivery_location' => [
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude,
            ],
            'pickup_date_from' => now(),
            'pickup_date_to' => now()->addDays(2),
            'delivery_date_from' => now()->addDays(3),
            'delivery_date_to' => now()->addDays(4),
            'cargo' => [
                [
                    'name' => $this->faker->word,
                    'quantity' => $this->faker->numberBetween(1, 10),
                    'weight' => $this->faker->numberBetween(1, 100),
                    'length' => $this->faker->numberBetween(1, 200),
                    'width' => $this->faker->numberBetween(1, 200),
                    'height' => $this->faker->numberBetween(1, 200),
                ]
            ],
            'service_type' => $this->faker->randomElement(PostServiceTypeEnum::cases())->value,
            'pickup_floor' => $this->faker->numberBetween(0, 10),
            'pickup_elevator' => $this->faker->boolean,
            'delivery_floor' => $this->faker->numberBetween(0, 10),
            'delivery_elevator' => $this->faker->boolean,
            'as_company' => true,
            'company_country' => $this->faker->countryCode,
        ];

        $this
            ->actingAs($this->user)
            ->postJson(route('posts.store'), $postData)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'title',
                    'content',
                    'category_id',
                    'pickup_country',
                    'pickup_city',
                    'pickup_location',
                    'delivery_country',
                    'delivery_city',
                    'delivery_location',
                    'pickup_date_from',
                    'pickup_date_to',
                    'delivery_date_from',
                    'delivery_date_to',
                    'cargo',
                    'service_type',
                    'pickup_floor',
                    'delivery_elevator',
                    'delivery_floor',
                    'pickup_elevator',
                    'as_company',
                    'company_country',
                    'created_at',
                    'updated_at',
                ],
                'code'
            ]);

        $this->assertDatabaseHas(Post::class, [
                'title' => $postData['title'],
                'content' => $postData['content'],
                'category_id' => $postData['category_id'],
                'pickup_country' => $postData['pickup_country'],
                'pickup_city' => $postData['pickup_city'],
                'delivery_country' => $postData['delivery_country'],
                'delivery_city' => $postData['delivery_city'],
                'pickup_date_from' => $postData['pickup_date_from'],
                'pickup_date_to' => $postData['pickup_date_to'],
                'delivery_date_from' => $postData['delivery_date_from'],
                'delivery_date_to' => $postData['delivery_date_to'],
                'service_type' => $postData['service_type'],
                'pickup_floor' => $postData['pickup_floor'],
                'pickup_elevator' => $postData['pickup_elevator'],
                'delivery_floor' => $postData['delivery_floor'],
                'delivery_elevator' => $postData['delivery_elevator'],
                'as_company' => $postData['as_company'],
                'company_country' => $postData['company_country']
            ]
        );
    }

    public function testUpdatePost(): void
    {
        $post = Post::factory()->create();
        $postData = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->text,
            'category_id' => Category::factory()->create()->id,
            'pickup_country' => $this->faker->countryCode,
            'pickup_city' => $this->faker->city,
            'pickup_location' => [
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude,
            ],
            'delivery_country' => $this->faker->countryCode,
            'delivery_city' => $this->faker->city,
            'delivery_location' => [
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude,
            ],
            'pickup_date_from' => now(),
            'pickup_date_to' => now()->addDays(2),
            'delivery_date_from' => now()->addDays(3),
            'delivery_date_to' => now()->addDays(4),
            'cargo' => [
                [
                    'name' => $this->faker->word,
                    'quantity' => $this->faker->numberBetween(1, 10),
                    'weight' => $this->faker->numberBetween(1, 100),
                    'length' => $this->faker->numberBetween(1, 200),
                    'width' => $this->faker->numberBetween(1, 200),
                    'height' => $this->faker->numberBetween(1, 200),
                ]
            ],
            'service_type' => $this->faker->randomElement(PostServiceTypeEnum::cases())->value,
            'pickup_floor' => $this->faker->numberBetween(0, 10),
            'pickup_elevator' => $this->faker->boolean,
            'delivery_floor' => $this->faker->numberBetween(0, 10),
            'delivery_elevator' => $this->faker->boolean,
            'as_company' => true,
            'company_country' => $this->faker->countryCode,
        ];

        $this
            ->actingAs($this->user)
            ->putJson(route('posts.update', ['post' => $post->id]), $postData)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'title',
                    'content',
                    'category_id',
                    'pickup_country',
                    'pickup_city',
                    'pickup_location',
                    'delivery_country',
                    'delivery_city',
                    'delivery_location',
                    'pickup_date_from',
                    'pickup_date_to',
                    'delivery_date_from',
                    'delivery_date_to',
                    'cargo',
                    'service_type',
                    'pickup_floor',
                    'delivery_elevator',
                    'delivery_floor',
                    'pickup_elevator',
                    'as_company',
                    'company_country',
                    'created_at',
                    'updated_at',
                ],
                'code'
            ]);

        $this->assertDatabaseHas(Post::class, [
                'title' => $postData['title'],
                'content' => $postData['content'],
                'category_id' => $postData['category_id'],
                'pickup_country' => $postData['pickup_country'],
                'pickup_city' => $postData['pickup_city'],
                'delivery_country' => $postData['delivery_country'],
                'delivery_city' => $postData['delivery_city'],
                'pickup_date_from' => $postData['pickup_date_from'],
                'pickup_date_to' => $postData['pickup_date_to'],
                'delivery_date_from' => $postData['delivery_date_from'],
                'delivery_date_to' => $postData['delivery_date_to'],
                'service_type' => $postData['service_type'],
                'pickup_floor' => $postData['pickup_floor'],
                'pickup_elevator' => $postData['pickup_elevator'],
                'delivery_floor' => $postData['delivery_floor'],
                'delivery_elevator' => $postData['delivery_elevator'],
                'as_company' => $postData['as_company'],
                'company_country' => $postData['company_country']
            ]
        );
    }

    public function testDeletePost(): void
    {
        $post = Post::factory()->create();

        $this
            ->actingAs($this->user)
            ->deleteJson(route('posts.destroy', ['post' => $post->id]))
            ->assertOk();

        $this->assertModelMissing($post);
    }
}
