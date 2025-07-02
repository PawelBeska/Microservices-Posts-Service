<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Traits\Conditionable;

class IndexRequest extends FormRequest
{
    use Conditionable;

    public function rules(): array
    {
        return [
            'per_page' => ['nullable', 'integer'],
        ];
    }

    public function perPage(): int
    {
        return $this->when(
            $this->has('per_page'),
            fn() => $this->input('per_page') <= 100 ? $this->input('per_page') : 15,
            fn() => 15
        );
    }
}
