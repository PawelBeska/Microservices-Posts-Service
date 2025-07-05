<?php

namespace App\Interfaces\Models;

use PDPhilip\Elasticsearch\Eloquent\Model;

interface HasElasticSearchIndexInterface
{

    public function elasticSearchModel(): Model;
}
