<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "productos";

    protected $fillable = [
        'nombre', 'descripcion', 'marca', 'precio', 'precio_coste', 'stock', 'stock_min', 'imagen', 'fecha_caducidad', 'fecha_fabricacion', 'estado', 'iva'
    ];
}
