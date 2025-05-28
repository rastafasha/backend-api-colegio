<?php

namespace App\Http\Resources\Representante;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RepresntanteCollection extends ResourceCollection
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
            "data"=> RepresntanteResource::collection($this->collection)
        ];
    }
}
