<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method total()
 * @method count()
 * @method perPage()
 * @method currentPage()
 * @method lastPage()
 */
class PaginationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'total' => $this->total(),
            'count' => $this->count(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'total_pages' => $this->lastPage(),
        ];
    }
}
