<?php

namespace App\Providers;

use Illuminate\Database\Grammar;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Grammar::macro('typePostServiceTypeEnum', fn() => 'post_service_type_enum');
    }
}
