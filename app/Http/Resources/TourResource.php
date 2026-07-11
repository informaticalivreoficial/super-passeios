<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'slug'        => $this->slug,
            'title'       => $this->title,
            'description' => $this->content,
            'cover_url'   => $this->cover(), // ajuste pro método real do seu model
            'company'     => [
                'name' => $this->company->alias_name ?? $this->company->social_name,
                'city' => $this->company->city,
            ],
            'vessel' => $this->when($this->vessel, fn() => [
                'name'     => $this->vessel->name,
                'capacity' => $this->vessel->capacity,
            ]),
        ];
    }
}
