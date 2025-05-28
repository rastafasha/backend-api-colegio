<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Configuracions;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SettingGeneral\SettingGResource;
use App\Http\Resources\SettingGeneral\SettingGCollection;

class SettingGController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Configuracions::orderBy('created_at', 'DESC')
        ->get();


        return response()->json([
            'code' => 200,
            'status' => 'Listar configuraciones',
            "settings" => SettingGCollection::make($settings),
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function settingStore(Request $request)
    {
        if($request->hasFile('imagen')){
            $path = Storage::putFile("settings", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }

        $setting = Configuracions::create($request->all());
        
        
        return response()->json([
            "message"=>200,
        ]);
        
        // return Configuracions::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function settingshow($id)
    {
        $setting = Configuracions::findOrFail($id);

        return response()->json([
            "setting" => $setting,
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function settingupdate(Request $request, $id)
    {
        $user_is_valid = User::where("email", $request->email)->first();

        $setting = Configuracions::findOrFail($id);

        if($request->hasFile('imagen')){
            if($setting->avatar){
                Storage::delete($setting->avatar);
            }
            $path = Storage::putFile("settings", $request->file('imagen'));
            $request->request->add(["avatar"=>$path]);
        }
        
        
       
        $setting->update($request->all());
        
        
        return response()->json([
            "message"=>200,
            "setting"=>$setting,
            // "assesstments"=>$patient->pa_assessments ? json_decode($patient->pa_assessments) : [],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function settingdestroy($id)
    {
        $setting = Configuracions::findOrFail($id);
        $setting->delete();
        return response()->json([
            "message" => 200,
        ]);
    }
}
