<?php

namespace App\Http\Controllers;

use App\Models\Configuracions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasFile('imagen')){
            $path = Storage::putFile("configuracions", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }


        $configuracion = Configuracions::create($request->all());

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
        $configuracion = Configuracions::findOrFail($id);

        return response()->json([
            "configuracion" => $configuracion,
            
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
         $configuracion = Configuracions::findOrFail($id);

        if($request->hasFile('imagen')){
            if($configuracion->avatar){
                Storage::delete($configuracion->avatar);
            }
            $path = Storage::putFile("configuracions", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

       
        $configuracion->update($request->all());
        
        // error_log($configuracion);

        return response()->json([
            "message"=>200,
            "configuracion"=>$configuracion,
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
        $configuracion = Configuracions::findOrFail($id);
        if($configuracion->image){
            Storage::delete($configuracion->image);
        }
        $configuracion->delete();
        return response()->json([
            "message"=>200
        ]);
    }
}
