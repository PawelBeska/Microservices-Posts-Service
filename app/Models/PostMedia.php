<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $post_id
 * @property int $order
 * @property string $disk
 * @property string $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class PostMedia extends Model
{
    protected $guarded = ['id'];
}
