<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'sku' => $this->sku,
                'category' => [
                    'id' => $this->category->id,
                    'name' => $this->category->name
                ],
                'stock' => $this->stock,
                'price' => $this->price,
            ]
        ];
    }
}
