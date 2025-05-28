<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Resources\Proveedor\ProveedorResource;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Proveedor::orderBy('id', 'DESC')
        
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'Listar todos los proveedores',
            'proveedores' => $proveedores,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pais_is_valid = Proveedor::where("user_id", $request->user_id)->first();
        $request->request->add(["ciudades"=>json_encode($request->ciudades)]);

        $proveedor = Proveedor::create($request->all());

        return response()->json([
            "message"=>200,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        
        return response()->json([
            "proveedor" => $proveedor,
            
        ]);
    }

    //se obtiene el bip del usuario
    public function showbyUser($user_id)
    {
        $proveedor = Proveedor::where("user_id", $user_id)->first();
        $user = User::where("id", $user_id)->first();

        // if (!$proveedor) {
        //     return response()->json([
        //         "message" => "Proveedor not found",
        //     ], 404);
        // }
    
        return response()->json([
            "user" => $user,
            // "user_id" => $proveedor->user_id ,
            "proveedor" => $proveedor ,
            // "proveedor" => ProveedorResource::make($proveedor),
        ]);

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $proveedor_is_valid = Proveedor::where("id", "<>", $id)->first();

        $request->request->add(["ciudades"=>json_encode($request->ciudades)]);
        
        $proveedor = Proveedor::findOrFail($id);

        $proveedor->update($request->all());
        
        // error_log($slider);

        return response()->json([
            "message"=>200,
            "proveedor"=>$proveedor,
            "ciudades"=>json_decode($proveedor-> ciudades),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        
        $proveedor->delete();
        return response()->json([
            "message"=>200
        ]);
    }


    public function updateStatusClient(Request $request, $id)
    {
        $proveedor = Proveedor::findOrfail($id);
        $proveedor->status = $request->status;
        $proveedor->update();
        return $proveedor;
        
    }

    public function updateStatusAdmin(Request $request, $id)
    {
        $proveedor = Proveedor::findOrfail($id);
        $proveedor->status = $request->status;
        $proveedor->update();
        return $proveedor;
        
    }

    public function search(Request $request){
        return Proveedor::search($request->buscar);
    }
}
