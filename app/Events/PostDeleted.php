<?php

namespace App\Events;

use App\Interfaces\Events\DeleteElasticsearchEventInterface;
use App\Models\Post;
use Illuminate\Foundation\Events\Dispatchable;

class PostDeleted implements DeleteElasticsearchEventInterface
{
    use Dispatchable;

    public function __construct(private readonly Post $record)
    {
    }

    public function getRecord(): Post
    {
        return $this->record;
    }
}
