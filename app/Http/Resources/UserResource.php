<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'cars' => $this->cars->map(function($item) {
                return [
                    'id' => $item->id,
                    'model' => $item->model,
                    'license_plate' => $item->license_plate,
                    'manufacturing_year' => $item->manufacturing_year
                ];
            })

        ];

    }
}
