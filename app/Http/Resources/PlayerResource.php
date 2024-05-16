<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'age' => $this->age,
            'market_price' => $this->market_price,
            'country' => new CountryResource($this->whenLoaded('country')),
            'position' => new PositionResource($this->whenLoaded('position')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
