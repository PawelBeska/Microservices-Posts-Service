<?php

namespace App\Data\Posts;

use App\Models\External;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class SavePostData extends Data
{
    #[Computed]
    public int $userId;

    public function __construct(
        public string $title,
        public string $content
    ) {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $this->userId = External::resolveOrCreate($user->id, $user->service);
    }
}
