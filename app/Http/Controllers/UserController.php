<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use JWTAuth;

class UserController extends Controller
{


   

    public function index(Request $request){

        if (Auth::check()){
            echo 'usuario logueado';
        }

        $usuarios = User::all();

        if(!$usuarios){
            return response()->json([
                'ok' => true,
                'message' => 'No existen usuarios',
                'users' => null
            ],200);
        }

        return response()->json([
            'ok' => true,
            'users' => $usuarios,
            'count' => count($usuarios)
        ],200);

    }

    public function getUser(Request $request, $id){
    

        $usuario = User::find($id);

        if(!$usuario){
            return response()->json([
                'ok' => true,
                'message' => 'No existe el usuario',
                'user' => null
            ],200);
        }

        return response()->json([
            'ok' => true,
            'user' => $usuario
        ],200);
    }

    public function update(Request $request, $id){


       $updatedData = $request->validate([
        'name' => 'required|alpha',
        'surname' => 'required|alpha',
        'email' => 'required|email|unique:users',
       ]);

       if($updatedData->fails()){
          
           return response()->json([
                'ok' => false,
                'code' => 400,
                'message' => 'El usuario no ha sido actualizado',
                'errors' => $updatedData->errors()
            ]);
       }
       

         $usuario_updated = User::find($id);

         $usuario_updated->name = $request->name;
         $usuario_updated->surname = $request->surname;
         $usuario_updated->email = $request->email;

         $usuario_updated->save();

         return  response()->json([
            'ok' => true,
            'code' => 200,
            'message' => 'El usuario ha sido actualizado',
            'user' => $updatedData
        ]);
       

    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
                
        $user->delete();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'message' => 'El usuario ha sido eliminado'
        ]);
        
    }
}
