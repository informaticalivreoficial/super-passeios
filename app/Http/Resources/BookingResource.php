<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'uuid'              => $this->uuid,
            'status'            => $this->status?->value,
            'status_label'      => $this->status?->label(),
            'payment_status'    => $this->payment_status?->value,
            'payment_status_label' => $this->payment_status?->label(),
            'payment_method'    => $this->payment_method,
            'gateway'           => $this->gateway,
            'payment_id'        => $this->payment_id,
            'subtotal'          => $this->subtotal,
            'commission_amount' => $this->commission_amount,
            'company_amount'    => $this->company_amount,
            'total'             => $this->total,
            'adults'            => $this->adults,
            'children'          => $this->children,
            'children_free'     => $this->children_free,
            'total_people'      => $this->total_people,
            'customer_name'     => $this->customer_name,
            'customer_email'    => $this->customer_email,
            'customer_phone'    => $this->customer_phone,
            'paid_at'           => $this->paid_at?->toDateTimeString(),
            'expires_at'        => $this->expires_at?->toDateTimeString(),
            'cancelled_at'      => $this->cancelled_at?->toDateTimeString(),
            'cancelled_reason'  => $this->cancelled_reason,
            'created_at'        => $this->created_at?->toDateTimeString(),
            'tour' => $this->whenLoaded('tour', fn() => [
                'id'        => $this->tour->id,
                'uuid'      => $this->tour->uuid,
                'slug'      => $this->tour->slug,
                'title'     => $this->tour->title,
                'cover_url' => $this->tour->cover(),
            ]),
            'tour_date' => $this->whenLoaded('tourDate', fn() => [
                'id'         => $this->tourDate->id,
                'date'       => $this->tourDate->date?->format('Y-m-d'),
                'start_time' => $this->tourDate->start_time,
                'end_time'   => $this->tourDate->end_time,
            ]),
        ];
    }
}
