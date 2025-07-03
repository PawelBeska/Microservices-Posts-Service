<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int $post_id
 * @property int $order
 * @property string $disk
 * @property string $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * * @property-read string $url
 */
class PostMedia extends Model
{
    protected $guarded = ['id'];

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}
