<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $service_id
 * @property string $external_id
 * @property Service $service
 * @method static PostFactory factory(int $count = 1)
 */
class External extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];


    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
