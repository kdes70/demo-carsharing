<?php

namespace App\Http\Resources;

use App\Domains\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request): ?array
    {
        $model = $this->resource;

        if (empty($model) || !($model instanceof User)) {
            return null;
        }

        $data = [
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email,
        ];

        if ($model->relationLoaded('rent')) {
            $data['rent'] = new RentalsResource($model->car);
        }

        return $data;
    }

}
