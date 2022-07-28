<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'model' => $this->model,
            'license_plate' => $this->license_plate,
            'manufacturing_year' => $this->manufacturing_year,
            'owners' => $this->owners->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email
                ];
            })
        ];

    }
}
