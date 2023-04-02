<?php

namespace App\Http\Resources\Table;

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
        return [
            'id' => $this?->id,
            'restaurant' => [
                'id' => $this?->restaurant?->id,
                'name' => $this?->restaurant?->name,
                'description' => $this?->restaurant?->description,
                'address' => $this?->restaurant?->address
            ],
            'status' => $this?->status,
            'session_id' => $this?->session_id,
            'table_number' => $this?->table_number,
        ];
    }
}
