<?php

namespace App\Casts;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Uncastable;
use Spatie\LaravelData\Exceptions\CannotCastEnum;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use Throwable;

class CollectionCast implements Cast
{
    public function __construct(
        protected ?string $type = null
    ) {
    }

    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): Collection|Uncastable
    {
        if (!is_array($value)) {
            return Uncastable::create();
        }

        try {
            return collect($value);
        } catch (Throwable) {
            throw CannotCastEnum::create($this->type, $value);
        }
    }
}
