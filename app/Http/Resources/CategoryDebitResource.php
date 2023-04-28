<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDebitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'maxValue' => $this->maxValue,
            'created_at' => $this->created_at->format('d/m/Y'),
            'debits' => $this->debits,
            'debitsSum' => $this->debitsSum($this->debits)
        ];
    }

    private function debitsSum($debits)
    {
        $sum = 0;

        foreach ($debits as $debit) {
            $sum += $debit->value;
        }

        return number_format($sum, 2, ',', '.');
    }
}
