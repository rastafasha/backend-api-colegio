<?php

namespace App\Http\Resources\Appointment\Payment;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            "referencia" =>$this->resource->referencia,
            "metodo" =>$this->resource->metodo,
            "bank_name" =>$this->resource->bank_name,
            "bank_destino" =>$this->resource->bank_destino,
            "monto" =>$this->resource->monto,
            "nombre" =>$this->resource->nombre,
            "email" =>$this->resource->email,
            "parent_id" =>$this->resource->parent_id,
            "student_id" =>$this->resource->student_id,
            "student" =>$this->resource->student ? 
                [
                    "id" =>$this->resource->student->id,
                    "email" =>$this->resource->student->email,
                    "full_name" =>$this->resource->student->name.' '.$this->resource->student->surname,
                    // "avatar"=> $this->resource->student->avatar ? env("APP_URL")."storage/".$this->resource->student->avatar : null,
                    "avatar"=> $this->resource->student->avatar ? env("APP_URL").$this->resource->student->avatar : null,
                    
                ]: NULL,

            "status" =>$this->resource->status,
            "fecha" =>$this->resource->fecha,
            "avatar"=> $this->resource->avatar ? env("APP_URL")."storage/".$this->resource->avatar : null,
            // "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,
            
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
        ];
    }
}
