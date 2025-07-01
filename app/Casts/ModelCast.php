<?php

namespace App\Casts;

use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Uncastable;
use Spatie\LaravelData\Exceptions\CannotCastEnum;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use Throwable;

class ModelCast implements Cast
{
    public function __construct(
        protected ?string $type = null
    ) {
    }

    public function cast(DataProperty $property, mixed $value, mixed $properties, CreationContext $context): Model|Uncastable
    {
        $type = $this->type ?? $property->type->findAcceptedTypeForBaseType(Model::class);

        if ($type === null) {
            return Uncastable::create();
        }

        /** @var Model $type */
        try {
            return $type::query()->findOrFail($value);
        } catch (Throwable) {
            throw CannotCastEnum::create($type, $value);
        }
    }
}
