<?php

namespace App\Events;

use App\Interfaces\Events\SaveElasticsearchEventInterface;
use App\Models\Post;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostCreated implements SaveElasticsearchEventInterface
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(private readonly Post $record)
    {
    }

    public function getRecord(): Post
    {
        return $this->record;
    }
}
