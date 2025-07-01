<?php

namespace App\Actions\Posts;

use App\Data\Posts\SavePostData;
use App\Models\Post;
use Lorisleiva\Actions\Concerns\AsAction;

class SavePostAction
{
    use AsAction;

    public function handle(SavePostData $data): Post
    {
        return Post::query()->create(
            $data->toArray()
        );
    }
}
