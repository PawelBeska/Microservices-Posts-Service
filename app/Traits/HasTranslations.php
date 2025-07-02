<?php

namespace App\Traits;

use Spatie\Translatable\HasTranslations as BaseHasTranslations;

trait HasTranslations
{
    use BaseHasTranslations;

    public function setAttribute($key, $value)
    {
        if ($value === null) {
            $this->attributes[$key] = null;

            return;
        }

        if ($this->isTranslatableAttribute($key) && is_array($value)) {
            return $this->setTranslations($key, array_filter($value, static fn(?string $v) => $v !== null));
        }

        if (!$this->isTranslatableAttribute($key) || is_array($value)) {
            return parent::setAttribute($key, $value);
        }

        return $this->setTranslation($key, $this->getLocale(), $value);
    }
}
