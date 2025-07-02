<?php

namespace App\Events;

use App\Interfaces\Events\DeleteElasticsearchEventInterface;
use App\Models\Category;
use Illuminate\Foundation\Events\Dispatchable;

class CategoryDeleted implements DeleteElasticsearchEventInterface
{
    use Dispatchable;

    public function __construct(private readonly Category $record)
    {
    }

    public function getRecord(): Category
    {
        return $this->record;
    }
}
