<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
        // return [
        //     'id' => $this?->id,
        //     'total' => $this?->total,
        //     'quantity' => $this?->quantity,
        //     'note' => $this?->note,
        //     'restaurant' => $this?->restaurant,
        //     'food' => $this?->food,
        //     'transaction_id' => $this?->transaction_id,
        // ];
    }
}
