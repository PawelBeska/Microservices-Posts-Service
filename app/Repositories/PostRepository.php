<?php

namespace App\Repositories;

use App\Interfaces\Repositories\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class PostRepository implements PostRepositoryInterface
{
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->getBaseQuery()->paginate($perPage);
    }

    public function getBaseQuery(): Builder|QueryBuilder
    {
        return QueryBuilder::for(Post::class)
            ->allowedIncludes(
                [
                    'category',
                    'media',
                    'user'
                ]
            );
    }


}
