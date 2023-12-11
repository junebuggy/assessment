<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
{
    public $preserveKeys = true;
    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email_address' => $this->email_address,
            'phone_number' => $this->phone_number,
            'home_address' => $this->home_address,
        ];
    }
}
