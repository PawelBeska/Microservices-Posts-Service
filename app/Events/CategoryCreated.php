<?php

namespace App\Events;

use App\Interfaces\Events\SaveElasticsearchEventInterface;
use App\Interfaces\Events\TranslatableSlugGenerationEventInterface;
use App\Models\Category;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategoryCreated implements SaveElasticsearchEventInterface, TranslatableSlugGenerationEventInterface
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(private readonly Category $record)
    {
    }

    public function getRecord(): Category
    {
        return $this->record;
    }
}
