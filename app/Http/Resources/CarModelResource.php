<?php

namespace App\Http\Resources;

use App\Domains\Car\CarModel;
use Illuminate\Http\Resources\Json\JsonResource;

class CarModelResource extends JsonResource
{

    public function toArray($request): ?array
    {
        $model = $this->resource;

        if (empty($model) || !($model instanceof CarModel)) {
            return null;
        }

        $data = [
            'id' => $model->id,
            'name' => $model->name,
            'code' => $model->code,
        ];

        if ($model->relationLoaded('make')) {
            $data['make'] = new MakeResource($model->make);
        }

        return $data;
    }

}
