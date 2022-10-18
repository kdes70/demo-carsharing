<?php

namespace App\Http\Resources;

use App\Domains\Rentals;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalsResource extends JsonResource
{

    public function toArray($request): ?array
    {
        $model = $this->resource;

        if (empty($model) || !($model instanceof Rentals)) {
            return null;
        }

        $data = [
            'id' => $model->id,
            'comment' => $model->comment,
            'status' => $model->status,
            'rent_start' => $model->rent_start,
            'rent_end' => $model->rent_end,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
            'car_id' => $model->id,
        ];

        if ($model->relationLoaded('car')) {
            $data['car'] = new CarResource($model->car);
        }

        return $data;
    }

}
