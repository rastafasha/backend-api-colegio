<?php

namespace App\Http\Controllers;

use App\Models\Tasabcv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class TasaBcvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasabcvs = Tasabcv::orderBy('created_at', 'DESC')
        ->get();


        return response()->json([
            'code' => 200,
            'status' => 'Listar todos los Pagos',
            'tasabcvs' => $tasabcvs,
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
        // Sanitize 'precio_dia' to replace comma with dot for decimal
        if ($request->has('precio_dia')) {
            $precioDia = str_replace(',', '.', $request->input('precio_dia'));
            $request->merge(['precio_dia' => $precioDia]);
        }

        if($request->hasFile('imagen')){
            $path = Storage::putFile("tasabcvs", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }


        $tasabcv = Tasabcv::create($request->all());

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
        $tasabcv = Tasabcv::findOrFail($id);

        return response()->json([
            "tasabcv" => $tasabcv,
            
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
        $slider_is_valid = Tasabcv::where("id", "<>", $id)->first();
        
        $tasabcv = Tasabcv::findOrFail($id);

        if($request->hasFile('imagen')){
            if($tasabcv->avatar){
                Storage::delete($tasabcv->avatar);
            }
            $path = Storage::putFile("tasabcvs", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

       
        $tasabcv->update($request->all());
        
        // error_log($slider);

        return response()->json([
            "message"=>200,
            "tasabcv"=>$tasabcv,
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
        $tasabcv = Tasabcv::findOrFail($id);
        if($tasabcv->image){
            Storage::delete($tasabcv->image);
        }
        $tasabcv->delete();
        return response()->json([
            "message"=>200
        ]);
    }
}
