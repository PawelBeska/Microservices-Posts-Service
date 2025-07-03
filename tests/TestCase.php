<?php

namespace Tests;

use App\Enums\ServiceEnum;
use App\Models\External;
use App\Models\Service;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;

    protected Authenticatable|User $user;
    protected External $externalUser;

    public function setUp(): void
    {
        parent::setUp();

        Service::factory()
            ->withService(ServiceEnum::USERS)
            ->create();

        $this->user = User::make(
            [
                'id' => $this->faker->uuid,
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'permissions' => [],
                'roles' => [],
                'service' => [
                    'name' => 'microservice',
                    'host' => 'localhost',
                    'port' => 8000,
                    'service' => ServiceEnum::USERS->value
                ]

            ]
        );

        $this->externalUser = External::factory()
            ->withService(ServiceEnum::USERS)
            ->create();
    }
}
