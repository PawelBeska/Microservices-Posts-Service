<?php

namespace App\Models\ElasticSearch;

use PDPhilip\Elasticsearch\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'elasticsearch';

    
}
