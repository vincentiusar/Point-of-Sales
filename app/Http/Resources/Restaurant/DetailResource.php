<?php

namespace App\Http\Resources\Restaurant;

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
            'id' => $this->id,
            'admin' => $this->admin ? 
                [
                    "id" => $this?->admin?->id,
                    "name" => $this?->admin?->name,
                    "username" => $this?->admin?->username,
                    "role_id" => $this?->admin?->role_id,
                    "restaurant_id" => $this?->admin?->restaurant_id
                ] 
                    : 
                null,
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
        ];
    }
}
