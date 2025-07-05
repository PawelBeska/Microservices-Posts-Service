<?php

namespace App\Models\ElasticSearch;

use PDPhilip\Elasticsearch\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'elasticsearch';


    public function saveFromModel(Category $category): self
    {
    }

}
