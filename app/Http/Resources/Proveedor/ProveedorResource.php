<?php

namespace App\Http\Resources\Proveedor;

use Illuminate\Http\Resources\Json\JsonResource;

class ProveedorResource extends JsonResource
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
            "nombre_empresa" =>$this->resource->nombre_empresa,
            "ruc" =>$this->resource->ruc,
            "email" =>$this->resource->email,
            "web_site" =>$this->resource->web_site,
            "nombre_contacto_principal" =>$this->resource->nombre_contacto_principal,
            "email_contacto_principal" =>$this->resource->email_contacto_principal,
            "phone_contacto_principal" =>$this->resource->phone_contacto_principal,
            "nombre_razon_social" =>$this->resource->nombre_razon_social,
            "direccion" =>$this->resource->direccion,
            "telefonos" =>$this->resource->telefonos,
            "nombre_representante_legal" =>$this->resource->nombre_representante_legal,
            "cedula_representante_legal" =>$this->resource->cedula_representante_legal,
            "telefono_representante_legal" =>$this->resource->telefono_representante_legal,
            "cuenta_bancaria" =>$this->resource->cuenta_bancaria,
            "banco" =>$this->resource->banco,
            "swift_bic" =>$this->resource->swift_bic,
            "documentos_de_solvencia_financiera" =>$this->resource->documentos_de_solvencia_financiera,
            "descripcion_prod_serv" =>$this->resource->descripcion_prod_serv,
            "categoria_prod_serv" =>$this->resource->categoria_prod_serv,
            "certificaciones" =>$this->resource->certificaciones,
            "credenciales" =>$this->resource->credenciales,
            "aviso_operacion" =>$this->resource->aviso_operacion,
            "paz_salvos_dgi_y_css" =>$this->resource->paz_salvos_dgi_y_css,
            "documento_incorporacion_empresa_rp" =>$this->resource->documento_incorporacion_empresa_rp,
            "referencias_comerciales" =>$this->resource->referencias_comerciales,
            "referencias_bancarias" =>$this->resource->referencias_bancarias,
            "informes_auditorias" =>$this->resource->informes_auditorias,
            "otros" =>$this->resource->otros,
            
            // "ciudades"=>json_decode($this->resource-> ciudades),
            // "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
        ];
    }
}
