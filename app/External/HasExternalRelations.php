<?php

namespace App\External;

use App\Enums\ServiceEnum;

trait HasExternalRelations
{


    public function external(ServiceEnum $serviceEnum, string $localKey, string $table): ExternalRelation
    {
        return new ExternalRelation(
            $this->newQuery(),
            $this,
            $serviceEnum,
            $localKey,
            $table
        );
    }

}
