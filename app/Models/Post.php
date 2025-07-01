<?php

namespace App\Models;

use App\Enums\ServiceEnum;
use App\External\Models\Relations\ExternalRelation;
use App\External\Traits\HasExternalRelations;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static PostFactory factory(int $count = 1)
 */
class Post extends Model
{
    use HasExternalRelations;
    use HasFactory;

    protected $guarded = ['id'];


    public function user(): ExternalRelation
    {
        return $this->external(ServiceEnum::USERS, 'user_id', 'users');
    }
}
