<?php

namespace App\Data\Categories;

use Spatie\LaravelData\Data;

class SaveCategoryData extends Data
{
    public function __construct(
        public array $name,
        public array $description,
        public ?string $image = null
    ) {
    }
}
