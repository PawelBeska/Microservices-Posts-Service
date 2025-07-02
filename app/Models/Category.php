<?php

namespace App\Models;

use App\Events\CategoryCreated;
use App\Events\CategoryDeleted;
use App\Events\CategoryUpdated;
use App\Interfaces\Models\HasTranslatableSlugInterface;
use App\Traits\HasTranslations;
use Carbon\Carbon;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string|null $image
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Category|null $parent
 * @property-read Collection<int, Category> $children
 * @property-read string|null $image_url
 * @method static CategoryFactory factory($count = 1)
 */
class Category extends Model implements HasTranslatableSlugInterface
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;

    public array $translatable = [
        'name',
        'slug',
        'description'
    ];

    protected $guarded = ['id'];

    protected $dispatchesEvents = [
        'deleted' => CategoryDeleted::class,
        'created' => CategoryCreated::class,
        'updated' => CategoryUpdated::class,
    ];


    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    public function getFieldNameForSlug(): string
    {
        return 'name';
    }
}
