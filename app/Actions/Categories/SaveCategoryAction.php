<?php

namespace App\Actions\Categories;

use App\Data\Categories\SaveCategoryData;
use App\Models\Category;
use Lorisleiva\Actions\Concerns\AsAction;

class SaveCategoryAction
{
    use AsAction;

    public function handle(SaveCategoryData $data, Category $category = new Category()): Category
    {
        $category->fill($data->toArray())
            ->save();

        return $category;
    }
}
