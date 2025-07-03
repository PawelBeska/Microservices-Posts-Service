<?php

use App\Enums\ServiceEnum;

return [
    'name' => env('MICROSERVICE_NAME', 'microservice'),
    'host' => env('MICROSERVICE_HOST', gethostbyname(gethostname())),
    'port' => env('MICROSERVICE_PORT', 80),
    'service' => env('MICROSERVICE_SERVICE', 'posts'),
    'service_enum' => ServiceEnum::class,
];
