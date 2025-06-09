<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Representante;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\Representante\RepresntanteResource;
use Illuminate\Support\Facades\Storage;
class RepresentanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        $representantes = Representante::orderBy('id', 'desc')
            
            ->with(['payments' => function ($query) {
                $query->where('status_deuda', 'DEUDA')->select('id', 'parent_id', 'status_deuda');
            }])
            ->get();

        return response()->json([
            'code' => 200,
            'status' => 'Listar todos los Usuarios con pagos en deuda',
            'representantes' => $representantes
            // "representantes" => RepresntanteResource::make($representantes)
        ], 200);
    }

    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $representante = Representante::findOrFail($id);

        return response()->json([
            // "user" => $representante,
            // "representante" => RepresntanteResource::make($representante)
            "representante" => $representante
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $representante_is_valid = Representante::where("id", "<>", $id)->where("email", $request->email)->first();
        $role_new = null;
        if($representante_is_valid){
            return response()->json([
                "message"=>403,
                "message_text"=> 'el usuario con este email ya existe'
            ]);
        }

        if($request->hasFile('imagen')){
            $path = Storage::putFile("parents", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }
        
        $representante = Representante::findOrFail($id);
        
        $representante->update($request->all());

        if($request->role_id && $request->role_id != $representante->roles()->first()->id){
            // error_log($representante->roles()->first()->id);
            $role_old = Role::findOrFail($representante->roles()->first()->id);
            $representante->removeRole($role_old);
            // error_log($request->role_id);
            $role_new = Role::findOrFail($request->role_id);
            $representante->assignRole($role_new);
        }
        
        
        return response()->json([
            "message" => 200,
            "representante" => $representante->{$role_new}
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userDestroy(Representante $representante)
    {
        // $this->authorize('delete', Representante::class);
        
        try {
            DB::beginTransaction();

            $representante->delete();

            DB::commit();
            return response()->json([
                'code' => 200,
                'status' => 'Usuario delete',
            ], 200);

        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Borrado fallido. Conflicto',
            ], 409);

        }
    }

    protected function userInput(): array
    {
        return [
            "name" => request("name"),
            "email" => request("email"),
            "rolename" => request("rolename"),
        ];
    }

    public function recientes()
    {
        // $this->authorize('recientes', Representante::class);

        $representantes = Representante::orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'representantes' => $representantes
        ], 200);
    }

    public function search(Request $request){
        return Representante::search($request->buscar);
    }

    public function showNdoc($n_doc)
    {
       
        $data_patient = [];
       
        
        $representante = Representante::where('n_doc', $n_doc)
        ->orderBy('id', 'desc')
        ->get();
        // $patient = Patient::where('n_doc', $n_doc)
        // ->orderBy('id', 'desc')
        // ->get();
        
        //     return response()->json([
        //         'code' => 200,
        //         'status' => 'Listar patient by n_doc',
        //         "user" => PatientCollection::make($representante) ,
        //         "patient" => PatientCollection::make($patient) ,
        //     ], 200);
    }

     public function updateStatus(Request $request, $id)
    {
        $representante = Representante::findOrfail($id);
        $representante->status = $request->status;
        $representante->update();
        return $representante;
    }
}
