<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

class ProductoController extends Controller
{
    public function index(){
        
        $productos = Producto::all();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'productos' => $productos
        ]);
    }

    public function getProducto(Request $request, $id){
        
        $producto = Producto::find($id);

        if(!$producto){
            return response()->json([
                'ok' => false,
                'code' => 200,
                'message' => 'No existe el producto',
                'producto' => null
            ]);
        }

        return response()->json([
            'ok' => true,
            'code' => 200,
            'producto' => $producto
        ]);
    }

    public function destroy($id){
        $producto_deleted = Producto::find($id);
        
        $producto_deleted->delete();

        return response()->json([
            'ok' => true,
            'code' => 200,
            'message' => 'El producto ha sido eliminado'
        ]);
    }
}
