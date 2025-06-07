<?php

namespace App\Http\Controllers\Auth;

use App\Models\Representante;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ChangePasswordRequest;

;

class AuthController extends Controller
{
    // /**
    //  * Create a new AuthController instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
    // }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request()->only('email', 'password');

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized - Credenciales incorrectas'], 401);
        }

        $user = User::where('email', request('email'))->firstOrFail();

        $permissions = auth('api')->user()->getAllPermissions()->map(function($perm){
            return $perm->name;
        });
        return response()->json([
            'message' => "Inicio de sesión exitoso",
            'access_token' => $this->respondWithToken($token),
            'token_type' => 'Bearer',
            // 'user' => $user,
            'user'=>[
                "id"=>auth('api')->user()->id,
                "username"=>auth('api')->user()->username,
                "avatar"=>auth('api')->user()->avatar,
                // "rolename"=>auth('api')->user()->rolename,
                "roles"=>auth('api')->user()->getRoleNames(),
                "email"=>auth('api')->user()->email,
                "permissions"=>$permissions,

            ],
        ], 201);
        
    }

    public function loginguest(Request $request)
    {
        $credentials = request()->only('email', 'password');

        if (! $token = auth('parent-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized - Credenciales incorrectas'], 401);
        }

        $user = Representante::where('email', request('email'))->firstOrFail();

        $permissions = auth('parent-api')->user()->getAllPermissions()->map(function($perm){
            return $perm->name;
        });
        return response()->json([
            'message' => "Inicio de sesión exitoso",
            'access_token' => $this->respondWithTokenParent($token),
            'token_type' => 'Bearer',
            // 'user' => $user,
            'user'=>[
                "id"=>auth('parent-api')->user()->id,
                "name"=>auth('parent-api')->user()->name,
                "surname"=>auth('parent-api')->user()->surname,
                "avatar"=>auth('parent-api')->user()->avatar,
                // "rolename"=>auth('parent-api')->user()->rolename,
                "roles"=>auth('parent-api')->user()->getRoleNames(),
                "email"=>auth('parent-api')->user()->email,
                "permissions"=>$permissions,

            ],
        ], 201);
        
    }

    /**
     * Register a User
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {

       $data = $request->only('name', 'surname', 'email', 'password', 'n_doc');
    //    $data = $request->only('username',  'email', 'password', );

       $validator = Validator::make($data, [
           'name' => 'required|string|between:2,100',
           'surname' => 'required|string|between:2,100',
           'n_doc' => 'required',
           'email' => 'required|string|email|max:100|unique:users',
           'password' => 'required|string|min:5',
           'role' => Rule::in([User::GUEST]),
       ]);
       

       if($validator->fails()){
           return response()->json($validator->errors(), 422);
       }

       $user = User::create([
           'name' => $request->name,
            'surname' => $request->surname,
            'n_doc' => $request->n_doc,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'role' => User::GUEST,
       ]);

       $user->assignRole(User::GUEST);

       $token = JWTAuth::fromUser($user);

       return response()->json([
           'message' => 'User registered successfully',
           'user' => $user,
           'access_token' => $token,
           'token_type' => 'Bearer',
       ], 201);

    }
    /**
     * Register a user as a parent, padre, or representante.
     * This function saves the user in the representantes table with role GUEST,
     * representing a parent or legal representative.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerguest(Request $request) {

        $data = $request->only('name', 'surname', 'email', 'password', 'n_doc');
        // $data = $request->only('username',  'email', 'password', );

        $validator = Validator::make($data, [
            // 'username' => 'required|string|between:2,100',
            'name' => 'required|string|between:2,100',
            'surname' => 'required|string|between:2,100',
            'n_doc' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:5',
            'role' => Rule::in([Representante::GUEST]),
        ]);
        

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user = Representante::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'n_doc' => $request->n_doc,
            'password' => Hash::make($request->password),
            'role' => Representante::GUEST,
        ]);

        $user->assignRole(Representante::GUEST);

       $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }
    
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $permissions = auth('api')->user()->getAllPermissions()->map(function($perm){
            return $perm->name;
        });
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 180,
            // 'user'=>auth('api')->user(),
            'user'=>[
                "name"=>auth('api')->user()->name,
                "surname"=>auth('api')->user()->surname,
                "rolename"=>auth('api')->user()->rolename,
                "email"=>auth('api')->user()->email,
                "n_doc"=>auth('api')->user()->n_doc,
                // "permissions"=>$permissions,

            ],
        ]);
    }

    protected function respondWithTokenParent($token)
    {
        $permissions = auth('parent-api')->user()->getAllPermissions()->map(function($perm){
            return $perm->name;
        });
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('parent-api')->factory()->getTTL() * 180,
            // 'user'=>auth('client-api')->user(),
            'user'=>[
                // "avatar"=>auth('client-api')->user()->avatar,
                "name"=>auth('parent-api')->user()->name,
                "surname"=>auth('parent-api')->user()->surname,
                "rolename"=>auth('parent-api')->user()->rolename,
                "email"=>auth('parent-api')->user()->email,
                "n_doc"=>auth('parent-api')->user()->n_doc,
                // "permissions"=>$permissions,

            ],
        ]);
    }

    /**
     * Change password 
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if (is_null($user)) {
            return response()->json([
                'code' => 401,
                'status' => 'User not authenticated',
            ], 401);
        }

        if (!Hash::check($request->current_password, $user->password)) {

            return response()->json([
                'code' => 500,
                'status' => '¡La contraseña actual no coincide!',
                'user' => $user,
            ], 500);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'code' => 200,
            'status' => '¡Contraseña cambiada correctamente!',
            'user' => $user,
        ], 200);
    }

     
}