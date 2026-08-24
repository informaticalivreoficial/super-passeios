<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CustomerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'email'        => $this->email,
            'phone'        => $this->phone,
            'cell_phone'   => $this->cell_phone,
            'whatsapp'     => $this->whatsapp,
            'cpf'          => $this->cpf,
            'gender'       => $this->gender,
            'birthday'     => $this->birthday,
            'avatar_url'   => $this->getUrlAvatarAttribute(),
            'zipcode'      => $this->zipcode,
            'street'       => $this->street,
            'number'       => $this->number,
            'complement'   => $this->complement,
            'neighborhood' => $this->neighborhood,
            'state'        => $this->state,
            'city'         => $this->city,
            'status'       => $this->status,
        ];
    }
}
