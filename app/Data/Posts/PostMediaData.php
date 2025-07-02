<?php

namespace App\Data\Posts;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class PostMediaData extends Data
{
    public function __construct(
        public ?int $id = null,
        public ?UploadedFile $file,
        public ?int $order = 0,
        public ?bool $delete = false
    ) {
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'id' => [
                Rule::requiredIf(data_get($context, 'delete'))
            ],
            'file' => [
                Rule::requiredIf(!data_get($context, 'delete')),
                'file',
                'image',
                'max:2048'
            ],
            'delete' => [
                'boolean'
            ],
            'order' => [
                'nullable',
                'integer',
                'min:0',
                Rule::requiredIf(data_get($context, 'delete'))
            ]
        ];
    }
}
