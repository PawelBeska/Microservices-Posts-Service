<?php

namespace App\Models;

use App\Data\Posts\CargoData;
use App\Enums\PostServiceTypeEnum;
use App\Enums\ServiceEnum;
use App\Events\PostCreated;
use App\Events\PostDeleted;
use App\Events\PostUpdated;
use App\External\Models\Relations\ExternalRelation;
use App\External\Traits\HasExternalRelations;
use Carbon\Carbon;
use Clickbar\Magellan\Data\Geometries\Point;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection as SupportCollection;
use Spatie\LaravelData\DataCollection;

/**
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property string $title
 * @property string|null $content
 * @property string $pickup_country
 * @property string $pickup_city
 * @property string|null $pickup_postal_code
 * @property string|null $pickup_address
 * @property Point $pickup_location
 * @property string $delivery_country
 * @property string $delivery_city
 * @property string|null $delivery_postal_code
 * @property string|null $delivery_address
 * @property Point $delivery_location
 * @property Carbon|null $pickup_date_from
 * @property Carbon|null $pickup_date_to
 * @property Carbon|null $delivery_date_from
 * @property Carbon|null $delivery_date_to
 * @property SupportCollection $cargo
 * @property PostServiceTypeEnum $service_type
 * @property int|null $pickup_floor
 * @property int|null $delivery_elevator
 * @property int|null $delivery_floor
 * @property int|null $pickup_elevator
 * @property bool $as_company
 * @property string|null $company_country
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static PostFactory factory(int $count = 1)
 *
 */
class Post extends Model
{
    use HasExternalRelations;
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'service_type' => PostServiceTypeEnum::class,
        'pickup_location' => Point::class,
        'delivery_location' => Point::class,
        'cargo' => DataCollection::class.':'.CargoData::class,
    ];

    protected $dispatchesEvents = [
        'deleted' => PostDeleted::class,
        'created' => PostCreated::class,
        'updated' => PostUpdated::class,
    ];

    public function user(): ExternalRelation
    {
        return $this->external(ServiceEnum::USERS, 'user_id', 'users');
    }

    public function media(): HasMany
    {
        return $this->hasMany(PostMedia::class);
    }
}
