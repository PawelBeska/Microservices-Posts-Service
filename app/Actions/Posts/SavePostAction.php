<?php

namespace App\Actions\Posts;

use App\Data\Posts\PostMediaData;
use App\Data\Posts\SavePostData;
use App\Models\Post;
use App\Models\PostMedia;
use Lorisleiva\Actions\Concerns\AsAction;

class SavePostAction
{
    use AsAction;

    public function handle(SavePostData $data, Post $post = new Post()): Post
    {
        $post->fill($data->except('images')->toArray())
            ->save();

        if ($data->images?->isNotEmpty()) {
            // Media to delete
            $idsToDelete = $data->images->whereNotNull('id')->where('delete', true)->pluck('id');
            $mediaToDelete = $post->media()->whereIn('id', $idsToDelete)->get();

            $mediaToDelete->each(function (PostMedia $media) {
                $media->delete();
            });

            // Media to reorder
            $data->images
                ->whereNotNull('id')
                ->where('delete', false)
                ->each(fn(PostMediaData $media) => $post->media()->where('id', $media->id)->update([
                    'order' => $media->order
                ]));

            // Media to create
            $data->images
                ->whereNull('id')
                ->each(fn(PostMediaData $data) => SavePostMediaAction::run($post, $data));
        }

        return $post;
    }
}
