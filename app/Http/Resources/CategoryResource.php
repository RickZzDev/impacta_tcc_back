<?php

namespace App\Http\Resources;

use App\Helpers\Util;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'maxValue' => $this->maxValue,
            'created_at' => $this->created_at->format('d/m/Y'),
            'debits' => $this->debits,
            'debitsSum' => Util::debitsSum($this->debits)
        ];
    }
}
