<?php

namespace App\Providers;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\PostRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class RepositoryServiceProvider extends SupportServiceProvider
{
    public array $bindings = [
        CategoryRepositoryInterface::class => CategoryRepository::class,
        PostRepositoryInterface::class => PostRepository::class,
    ];
}
