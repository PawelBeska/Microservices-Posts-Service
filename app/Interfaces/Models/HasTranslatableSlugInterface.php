<?php

namespace App\Interfaces\Models;

/**
 * @property string $slug
 */
interface HasTranslatableSlugInterface
{
    public function getFieldNameForSlug(): string;
}
