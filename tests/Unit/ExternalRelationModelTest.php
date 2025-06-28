<?php

namespace Tests\Unit;

use App\Enums\ServiceEnum;
use App\Models\External;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;


class ExternalRelationModelTest extends TestCase
{
    use RefreshDatabase;

    public function testExternalRelation(): void
    {
        $post = Post::factory()
            ->create();

        Http::fake([
                '*' => Http::response([
                    'data' => [
                        [
                            'id' => External::query()->first()->external_id,
                        ]
                    ]
                ])
            ]
        );

        DB::enableQueryLog();
        $post->loadMissing('user');

        $this->assertCount(1, DB::getQueryLog());
        $this->assertNotNull($post->user);
    }

    public function testExternalRelationForMany(): void
    {
        Post::factory(100)
            ->create();

        Http::fake([
                '*' => Http::response([
                    'data' =>
                        External::query()->get()->map(function ($model) {
                            return [
                                'id' => $model->external_id,
                            ];
                        })->toArray(),

                ])
            ]
        );

        $result = Benchmark::measure(function () {
            return Post::query()
                ->with('user')
                ->get();
        }, 3);

        $this->assertTrue($result < 100, 'Average time should be less than 100ms');

        DB::enableQueryLog();

        $posts = Post::query()
            ->with('user')
            ->get();


        $this->assertCount(2, DB::getQueryLog());

        $this->assertNotNull($posts->first()->user);
    }

    public function testExternalRelationForManyRecordsAndOneRelation(): void
    {
        Service::factory()
            ->withService(ServiceEnum::USERS)
            ->create();

        $external = External::factory()
            ->withService(ServiceEnum::USERS)
            ->create();

        Post::factory(1000)
            ->withUser($external)
            ->create();

        Http::fake([
                '*' => Http::response([
                    'data' =>
                        External::query()->get()->map(function ($model) {
                            return [
                                'id' => $model->external_id,
                            ];
                        })->toArray(),

                ])
            ]
        );

        $result = Benchmark::measure(function () {
            return Post::query()
                ->with('user')
                ->get();
        }, 3);

        $this->assertTrue($result < 100, 'Average time should be less than 100ms');

        DB::enableQueryLog();

        $posts = Post::query()
            ->with('user')
            ->get();


        $this->assertCount(2, DB::getQueryLog());

        $this->assertNotNull($posts->first()->user);
    }
}
