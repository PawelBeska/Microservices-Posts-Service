<?php

namespace App\Interfaces\Events;

use Illuminate\Database\Eloquent\Model;

interface DeleteElasticsearchEventInterface
{
    public function getRecord(): Model;
}
