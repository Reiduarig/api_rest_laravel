<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
       
        //validar datos recibidos del usuario
        $validate = Validator::make($request->all(),[
            'name' => 'required|alpha',
            'surname' => 'required|alpha',
            'email' => 'required|email|unique:users',
            'password' => 'required|alpha|min:6',
        ]
        );

        if($validate->fails()){
            
            $data = array(
                'ok' => false,
                'code'=> 422,
                'message'=>'Usuario no registrado',
                'errors' => $validate->errors()
            );

        }else{

            //recoger datos del usuario por post
            $name = $request->input('name');
            $surname = $request->input('surname');
            $email = $request->input('email');
            $password = $request->input('password');

            //cifrar password
            $hashed = bcrypt($password);

            //crear el usuario
            $user = new User();
            $user->name = $name;
            $user->surname = $surname;
            $user->email = $email;
            $user->password = $hashed;

             /*var_dump($user);
            die();*/

            //guardar el usuario
            $user->save();

            $data = array(
                'ok' => true,
                'code'=> 201,
                'message'=>'Usuario registrado',
                'user' => $user
            );
        }
        
        return response()->json($data, $data['code']);  
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){

        $validate = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|alpha|min:6',
        ]);

        if($validate->fails()){
            
            $data = array(
                'ok' => false,
                'code'=> 422,
                'message'=>'Error en los datos recibidos',
                'errors' => $validate->errors()
            );
           
           
        }

        if(!$token = auth()->attempt($validate->validated())){
           
            $data = array(
                'ok' => false,
                'code'=> 401,
                'message'=>'Usuario no autorizado',
                'errors' => $validate->errors(),
            );
        }


        $data = array(
            'ok' => true,
            'code'=> 200,
            'message'=>'Usuario logueado',
            'token' => $token
        );

        return $this->createNewToken($token);
    } 
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        
        auth()->logout();

        return response()->json(['message' => 'Usuario deslogueado correctamente']);

    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
