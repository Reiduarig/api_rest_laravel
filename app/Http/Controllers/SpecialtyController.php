<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialty;
use Validator;

class SpecialtyController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    public function index() {
        $specialties = Specialty::all();
        
        return response()->json([
            'ok' => true,
            'code' => 200,
            'specialties' => $specialties
        ]);
    }

    public function create(Request $request){

        $validate = Validator::make($request->all(),[
            'name' => 'required|alpha',
            ]
        );

        if($validate->fails()){
            
            $data = array(
                'ok' => false,
                'code'=> 422,
                'message'=>'Especialidad no registrada',
                'errors' => $validate->errors()
            );

        }else{

            //recoger datos del usuario por post
            $name = $request->input('name');
            $description = $request->input('description');
            
            $especialidad = new Specialty();
            $especialidad->name = $name;
            $especialidad->description = $description;

            $especialidad->save();

            $data = array(
                'ok' => true,
                'code'=> 201,
                'message'=>'Especialidad creada',
                'specialty' => $especialidad
            );
        }
        
        return response()->json([$data, $data['code']]);
    
    }
    public function getSpecialty(Request $request, $id){

        $specialty = Specialty::find($id);

        if(!$specialty){
            return response()->json([
                'ok' => false,
                'code' => 400,
                'message' => 'No existe la especialidad',
                'specialty' => null
            ]);
        }

        return response()->json([
            'ok' => true,
            'code' => 200,
            'specialty' => $specialty
        ]);

    }
   
    public function update(Request $request){

        $validate = Validator::make($request->all(),[
            'name' => 'required|alpha',
            ]
        );

        if($validate->fails()){
            
            $data = array(
                'ok' => false,
                'code'=> 422,
                'message'=>'Especialidad no registrada',
                'errors' => $validate->errors()
            );

        }else{

            $specialty_updated = Specialty::find($id);

            $specialty_updated->name = $request->name;
            $specialty_updated->surname = $request->description;
   
            $specialty_updated->save();
   
            return  response()->json([
               'ok' => true,
               'code' => 200,
               'message' => 'La especialidad ha sido actualizada',
               'specialty' =>  $specialty_updated
           ]);
        }
    }    
    public function destroy(Request $request, $id){
        $specialty_deleted = Specialty::find($id);
        $specialty_deleted->delete();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'message' => 'Espec'
        ]);

    }

}
