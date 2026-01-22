<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'status'   => $this->status,
            'total'    => $this->total_amount,
            'customer' => [
                'id'   => $this->customer->id,
                'name' => $this->customer->name,
            ],
            'items' => $this->items->map(fn ($item) => [
                'product_id' => $item->product_id,
                'price'      => $item->price,
                'quantity'   => $item->quantity,
            ]),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
