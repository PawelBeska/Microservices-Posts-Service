<?php

namespace App\Interfaces\Events;

use Illuminate\Database\Eloquent\Model;

interface SaveElasticsearchEventInterface
{
    public function getRecord(): Model;
}
