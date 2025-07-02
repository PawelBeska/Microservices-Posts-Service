<?php

namespace App\Actions\Posts;

use App\Data\Posts\PostMediaData;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class SavePostMediaAction
{
    use AsAction;

    public function handle(Post $post, PostMediaData $data): PostMedia
    {
        $path = $data->file->storePublicly(
            'posts/'.$post->id,
        );

        return $post->media()->create([
            'path' => $path,
            'disk' => Storage::getDefaultDriver(),
            'order' => $data->order,
        ]);
    }
}
