<?php

namespace Tests\Feature\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexPosts(): void
    {
        Post::factory()->count(5)->create();

        $this
            ->actingAs($this->user)
            ->getJson(route('posts.index'))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    [

                    ],
                ],
                'code'
            ]);
    }

    public function testShowPosts(): void
    {
        $post = Post::factory()->create();

        $this
            ->actingAs($this->user)
            ->getJson(route('posts.show', ['post' => $post->id]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [

                ],
                'code'
            ]);
    }

    public function testStorePost(): void
    {
        $postData = [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
        ];

        $this
            ->actingAs($this->user)
            ->postJson(route('posts.store'), $postData)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [

                ],
                'code'
            ]);
    }

    public function testUpdatePost(): void
    {
        $post = Post::factory()->create();
        $updateData = [
            'title' => 'Updated Post Title',
            'content' => 'Updated content for the post.',
        ];

        $this
            ->actingAs($this->user)
            ->putJson(route('posts.update', ['post' => $post->id]), $updateData)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    
                ],
                'code'
            ]);
    }

    public function testDeletePost(): void
    {
        $post = Post::factory()->create();

        $this
            ->actingAs($this->user)
            ->deleteJson(route('posts.destroy', ['post' => $post->id]))
            ->assertNoContent();

        $this->assertDatabaseMissing(Post::class, [
            'id' => $post->id,
        ]);
    }
}
