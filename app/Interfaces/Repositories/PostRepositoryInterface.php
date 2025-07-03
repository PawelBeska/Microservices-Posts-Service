<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

interface PostRepositoryInterface
{
    public function getPaginated(int $perPage = 15): LengthAwarePaginator;

    public function getBaseQuery(): Builder|QueryBuilder;
}
