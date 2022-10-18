<?php

namespace App\Http\Resources;

use App\Domains\Car\Make;
use Illuminate\Http\Resources\Json\JsonResource;

class MakeResource extends JsonResource
{

    public function toArray($request): ?array
    {
        $model = $this->resource;

        if (empty($model) || !($model instanceof Make)) {
            return null;
        }

        return [
            'id' => $model->id,
            'name' => $model->name,
            'logo' => $model->logo,
        ];
    }

}
