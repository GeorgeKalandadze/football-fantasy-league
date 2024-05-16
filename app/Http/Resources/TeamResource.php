<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'name' => $this->name,
            'country' => new CountryResource($this->whenLoaded('country')),
            'division' => new DivisionResource($this->whenLoaded('division')),
            'players' => PlayerResource::collection($this->whenLoaded('players')),
        ];
    }
}
