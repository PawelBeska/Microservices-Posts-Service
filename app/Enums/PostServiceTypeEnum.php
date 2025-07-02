<?php

namespace App\Enums;

enum PostServiceTypeEnum: string
{

    case ONLY_DELIVERY = 'only_delivery';

    case DELIVERY_WITH_HELP = 'delivery_with_help';

    case DELIVERY_WITH_ADDITIONAL_HELP = 'delivery_with_additional_help';

    case FULL_SERVICE = 'full_service';

    public static function all(): array
    {
        return [
            self::ONLY_DELIVERY->value,
            self::DELIVERY_WITH_HELP->value,
            self::DELIVERY_WITH_ADDITIONAL_HELP->value,
            self::FULL_SERVICE->value,
        ];
    }

}
