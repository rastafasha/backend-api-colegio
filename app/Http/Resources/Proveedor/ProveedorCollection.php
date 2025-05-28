<?php

namespace App\Http\Resources\Proveedor;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProveedorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "data"=> ProveedorResource::collection($this->collection)
        ];
    }
}
