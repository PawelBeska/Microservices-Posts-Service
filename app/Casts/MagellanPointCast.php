<?php

namespace App\Casts;

use Clickbar\Magellan\Data\Geometries\Point;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Uncastable;
use Spatie\LaravelData\Exceptions\CannotCastEnum;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use Throwable;

class MagellanPointCast implements Cast
{
    public function __construct(
        protected ?string $type = null
    ) {
    }

    /**
     * @throws CannotCastEnum
     */
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): Point|Uncastable
    {
        if (!$value) {
            return Uncastable::create();
        }

        [$lat, $long] = [
            data_get($value, 'latitude'),
            data_get($value, 'longitude')
        ];

        $type = $property->type->findAcceptedTypeForBaseType(Point::class);

        if ($type === null || !$lat || !$long) {
            return Uncastable::create();
        }

        try {
            return Point::makeGeodetic($lat, $long);
        } catch (Throwable) {
            throw CannotCastEnum::create($type, $value);
        }
    }
}
