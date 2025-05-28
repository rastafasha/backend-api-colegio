<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Patient\Patient;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
// use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\Patient\PatientCollection;

class AdminUserController extends Controller
{
    // /**
    //  * Create a new AuthController instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('jwt.verify');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
        $roles = Role::get();
        $users = User::orderBy('id', 'desc')
        ->with('roles')
            ->get();

            return response()->json([
                'code' => 200,
                'status' => 'Listar todos los Usuarios',
                "users" => UserCollection::make($users)
            ], 200);
    }

    public function config()
    {
        
        $roles = Role::get();
        return response()->json([
            "roles" => $roles,

        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userShow($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            // "user" => $user,
            "user" => UserResource::make($user)
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userUpdate(Request $request, string $id)
    {
        $user_is_valid = User::where("id", "<>", $id)->where("email", $request->email)->first();
        $role_new = null;
        if($user_is_valid){
            return response()->json([
                "message"=>403,
                "message_text"=> 'el usuario con este email ya existe'
            ]);
        }
        
        $user = User::findOrFail($id);
        
        $user->update($request->all());

        if($request->role_id && $request->role_id != $user->roles()->first()->id){
            // error_log($user->roles()->first()->id);
            $role_old = Role::findOrFail($user->roles()->first()->id);
            $user->removeRole($role_old);
            // error_log($request->role_id);
            $role_new = Role::findOrFail($request->role_id);
            $user->assignRole($role_new);
        }
        
        
        return response()->json([
            "message" => 200,
            "user" => $user->{$role_new}
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userDestroy(User $user)
    {
        // $this->authorize('delete', User::class);
        
        try {
            DB::beginTransaction();

            $user->delete();

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
        // $this->authorize('recientes', User::class);

        $users = User::orderBy('created_at', 'DESC')
        ->get();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'users' => $users
        ], 200);
    }

    public function search(Request $request){
        return User::search($request->buscar);
    }

    public function showNdoc($n_doc)
    {
       
        $data_patient = [];
       
        
        $user = User::where('n_doc', $n_doc)
        ->orderBy('id', 'desc')
        ->get();
        // $patient = Patient::where('n_doc', $n_doc)
        // ->orderBy('id', 'desc')
        // ->get();
        
        //     return response()->json([
        //         'code' => 200,
        //         'status' => 'Listar patient by n_doc',
        //         "user" => PatientCollection::make($user) ,
        //         "patient" => PatientCollection::make($patient) ,
        //     ], 200);
    }

    
}
