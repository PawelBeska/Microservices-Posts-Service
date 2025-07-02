<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Category::query()->paginate($perPage);
    }

    public function getAll(): Collection
    {
        return Category::query()
            ->with([
                'parent' => function (BelongsTo $query) {
                    $query->with('parent');
                }
            ])
            ->get();
    }
}
