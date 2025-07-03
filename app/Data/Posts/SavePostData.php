<?php

namespace App\Data\Posts;

use App\Casts\MagellanPointCast;
use App\Enums\PostServiceTypeEnum;
use App\Models\External;
use Carbon\Carbon;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\Enum;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class SavePostData extends Data
{
    #[Computed]
    public int $userId;

    public function __construct(
        public string $title,
        public int $category_id,
        #[DataCollectionOf(CargoData::class)]
        public Collection $cargo,
        public PostServiceTypeEnum $serviceType,
        public string $pickupCountry,
        public string $pickupCity,
        #[WithCast(MagellanPointCast::class)]
        public Point $pickupLocation,
        public string $deliveryCountry,
        public string $deliveryCity,
        #[WithCast(MagellanPointCast::class)]
        public Point $deliveryLocation,
        #[DataCollectionOf(PostMediaData::class)]
        public ?Collection $images = null,
        public ?string $pickupPostalCode = null,
        public ?string $pickupAddress = null,
        public ?string $deliveryPostalCode = null,
        public ?string $deliveryAddress = null,
        #[WithCast(DateTimeInterfaceCast::class, 'Y-m-d\TH:i:s.u\Z')]
        public ?Carbon $pickupDateFrom = null,
        #[WithCast(DateTimeInterfaceCast::class, 'Y-m-d\TH:i:s.u\Z')]
        public ?Carbon $pickupDateTo = null,
        #[WithCast(DateTimeInterfaceCast::class, 'Y-m-d\TH:i:s.u\Z')]
        public ?Carbon $deliveryDateFrom = null,
        #[WithCast(DateTimeInterfaceCast::class, 'Y-m-d\TH:i:s.u\Z')]
        public ?Carbon $deliveryDateTo = null,
        public ?int $pickupFloor = null,
        public ?bool $pickupElevator = null,
        public ?int $deliveryFloor = null,
        public ?bool $deliveryElevator = null,
        public bool $asCompany = false,
        public ?string $content = null,
        public ?string $companyCountry = null,
    ) {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $this->userId = External::resolveOrCreate($user->id, $user->service);
    }

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['nullable', 'string', 'max:1000'],
            #!TODO add validation to ensure category is last item
            'category_id' => ['required', 'exists:categories,id'],
            #!TODO validate pickup country
            'pickup_country' => ['required', 'string', 'max:2'],
            'pickup_city' => ['required', 'string', 'max:255'],
            'pickup_postal_code' => ['nullable', 'string', 'max:20'],
            'pickup_address' => ['nullable', 'string', 'max:255'],
            'pickup_location' => ['required', 'array'],
            'pickup_location.latitude' => ['required', 'numeric'],
            'pickup_location.longitude' => ['required', 'numeric'],
            #!TODO validate delivery country
            'delivery_country' => ['required', 'string', 'max:2'],
            'delivery_city' => ['required', 'string', 'max:255'],
            'delivery_postal_code' => ['nullable', 'string', 'max:20'],
            'delivery_address' => ['nullable', 'string', 'max:255'],
            'delivery_location' => ['required', 'array'],
            'delivery_location.latitude' => ['required', 'numeric'],
            'delivery_location.longitude' => ['required', 'numeric'],
            'pickup_date_from' => ['nullable'],
            'pickup_date_to' => ['nullable'],
            'delivery_date_from' => ['nullable'],
            'delivery_date_to' => ['nullable'],
            'cargo' => ['required', 'array', 'max:100'],
            'service_type' => ['required', 'string', new Enum(PostServiceTypeEnum::class)],
            'pickup_floor' => ['nullable', 'integer', 'min:0'],
            'pickup_elevator' => ['nullable', 'boolean'],
            'delivery_floor' => ['nullable', 'integer', 'min:0'],
            'delivery_elevator' => ['nullable', 'boolean'],
            'as_company' => ['required', 'boolean'],
            #!TODO validate company country
            'company_country' => ['nullable', 'string', 'max:2'],
            'images' => ['nullable', 'array', 'max:10'],
        ];
    }
}
