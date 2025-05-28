<?php

namespace App\Http\Controllers;

use App\Models\Sliders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Slider\SliderCollection;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $sliders = Sliders::where(DB::raw("CONCAT(sliders.enlace,' ', IFNULL(sliders.target,''))"),
        "like","%".$search."%"
        )->orderBy("id", "desc")
        
        ->paginate(10);
        // ->get();
                    
        return response()->json([
            "total" =>$sliders->total(),
            "sliders" => SliderCollection::make($sliders),
            
        ]);          
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slider_is_valid = Sliders::where("user_id", $request->user_id)->first();

        // if($slider_is_valid){
        //     return response()->json([
        //         "message"=>403,
        //         "message_text"=> 'el slider ya existe'
        //     ]);
        // }

        if($request->hasFile('imagen')){
            $path = Storage::putFile("sliders", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        if($request->hasFile('imagenn')){
            $path = Storage::putFile("sliders", $request->file('imagenn'));
            $request->request->add(["imagemovil"=>$path]);
        }
        

        $slider = Sliders::create($request->all());

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
        $slider = Sliders::findOrFail($id);

        return response()->json([
            "slider" => $slider,
            
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

        
        $slider_is_valid = Sliders::where("id", "<>", $id)->first();
        
        $slider = Sliders::findOrFail($id);

        if($request->hasFile('imagen')){
            if($slider->avatar){
                Storage::delete($slider->avatar);
            }
            $path = Storage::putFile("sliders", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        if($request->hasFile('imagenn')){
            if($slider->imagemovil){
                Storage::delete($slider->imagemovil);
            }
            $path = Storage::putFile("sliders", $request->file('imagenn'));
            $request->request->add(["imagemovil"=>$path]);
        }
       
        $slider->update($request->all());
        
        // error_log($slider);

        return response()->json([
            "message"=>200,
            "slider"=>$slider,
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
        $slider = Sliders::findOrFail($id);
        if($slider->image){
            Storage::delete($slider->image);
        }
        $slider->delete();
        return response()->json([
            "message"=>200
        ]);
    }

    public function activos()
    {

        $sliders = Sliders::where('is_active', 1)
                ->get();

            return response()->json([
                'code' => 200,
                'status' => 'Listar sliders destacados',
                "sliders" => SliderCollection::make($sliders),
            ], 200);
    }
}
