<?php

namespace App\Http\Resources\SettingGeneral;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingGResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" =>$this->resource->id,
            "user_id" =>$this->resource->user_id,
            "direccion" =>$this->resource->direccion,
            "telefono" =>$this->resource->telefono,
            "telefonoActivo" =>$this->resource->telefonoActivo,
            "telPresidencia" =>$this->resource->telPresidencia,
            "telPresActivo" =>$this->resource->telPresActivo,
            "telSecretaria" =>$this->resource->telSecretaria,
            "telSecActivo" =>$this->resource->telSecActivo,
            "telTesoreria" =>$this->resource->telTesoreria,
            "telTesActivo" =>$this->resource->telTesActivo,

            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
        ];
    }
}
