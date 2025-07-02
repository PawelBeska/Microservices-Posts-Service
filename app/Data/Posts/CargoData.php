<?php

namespace App\Data\Posts;

use Spatie\LaravelData\Data;

class CargoData extends Data
{
    public function __construct(
        public string $name,
        public int $quantity,
        public int $length,
        public int $width,
        public int $height,
        public int $weight,
    ) {
    }

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'length' => ['required', 'integer', 'min:1'],
            'width' => ['required', 'integer', 'min:1'],
            'height' => ['required', 'integer', 'min:1'],
            'weight' => ['required', 'integer', 'min:1'],
        ];
    }

}
