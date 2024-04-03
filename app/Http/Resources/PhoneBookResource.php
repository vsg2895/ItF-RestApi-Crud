<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhoneBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->first_name,
            'name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'country_code' => $this->country_code,
            'timezone_name' => $this->timezone_name,
        ];
    }
}
