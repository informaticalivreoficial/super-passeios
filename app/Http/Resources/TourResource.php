<?php

namespace App\Http\Resources;

use App\Enums\TourTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TourResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'uuid'           => $this->uuid,
            'slug'           => $this->slug,
            'title'          => $this->title,
            'description'    => $this->content,
            'price'          => $this->price,
            'duration'       => $this->duration,
            'boarding_place' => $this->boarding_place,
            'tour_type'      => $this->whenNotNull($this->tour_type?->value),
            'tour_type_label' => $this->whenNotNull($this->tour_type?->label()),
            'cover_url'      => $this->cover(),
            'images'         => $this->whenLoaded('images', fn() =>
                $this->images
                    ->filter(fn($img) => !empty($img->path))
                    ->map(fn($img) => Storage::url($img->path))
                    ->values()
                    ->toArray()
            ),
            'company' => $this->whenLoaded('company', fn() => [
                'name' => $this->company->alias_name ?? $this->company->social_name,
                'city' => $this->company->city,
                'state' => $this->company->state,
            ]),
            'vessel' => $this->when($this->vessel, fn() => [
                'name'     => $this->vessel->name,
                'capacity' => $this->vessel->capacity,
            ]),
        ];
    }
}
