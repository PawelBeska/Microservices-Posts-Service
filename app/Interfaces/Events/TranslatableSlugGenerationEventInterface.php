<?php

namespace App\Interfaces\Events;

use Illuminate\Database\Eloquent\Model;

interface TranslatableSlugGenerationEventInterface
{
    public function getRecord(): Model;
}
