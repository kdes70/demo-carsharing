<?php

namespace App\Http\Resources;

use App\Domains\Car\Car;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{

    public function toArray($request): ?array
    {
        $model = $this->resource;

        if (empty($model) || !($model instanceof Car)) {
            return null;
        }

        $data = [
            'id' => $model->id,
            'year' => $model->year,
            'type' => $model->type,
            'transmission' => $model->transmission,
            'status' => $model->status,
            'description' => htmlspecialchars($model->description, ENT_QUOTES),
        ];

        if ($model->relationLoaded('carModel')) {
            $data['carModel'] = new CarModelResource($model->carModel);
        }

        return $data;
    }

}
