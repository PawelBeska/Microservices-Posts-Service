<?php

namespace App\Interfaces\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function getPaginated(int $perPage = 15): LengthAwarePaginator;

    public function getAll(): Collection;
}
