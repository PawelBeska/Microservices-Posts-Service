<?php

namespace App\Interfaces\Events;

use App\Interfaces\Models\HasElasticSearchIndexInterface;
use Illuminate\Database\Eloquent\Model;

interface SaveElasticsearchEventInterface
{
    public function getRecord(): Model|HasElasticSearchIndexInterface;
}
