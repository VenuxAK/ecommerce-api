<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "role" => $this->role->type,
            "name" => $this->name,
            "username" => $this->username,
            "email" => $this->email,
            "phone_no" => $this->phone_no ?? NULL,
            "address" => $this->address ?? NULL,
        ];
    }
}
