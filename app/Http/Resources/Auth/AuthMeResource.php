<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthMeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->resource = (object) $this->resource;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'role_id' => $this->role_id,
        ];
    }
}
