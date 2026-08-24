<?php

namespace App\Http\Resources;

use App\Enums\TourDateStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourDateResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'date'           => $this->date?->format('Y-m-d'),
            'start_time'     => $this->start_time,
            'end_time'       => $this->end_time,
            'price'          => $this->price,
            'half_price'     => $this->half_price,
            'available_slots' => $this->available_slots,
            'remaining_slots' => $this->remaining_available,
            'status'         => $this->status?->value,
            'status_label'   => $this->status?->label(),
            'is_sold_out'    => $this->is_sold_out,
        ];
    }
}
