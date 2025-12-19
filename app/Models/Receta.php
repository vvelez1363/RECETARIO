<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'categoria_id', 
        'nombre', 
        'descripcion', 
        'instrucciones', 
        'tiempo_preparacion', 
        'porciones', 
        'dificultad', 
        'imagen'
    ];

    /**
     * Relación con el usuario creador
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con la categoría
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Relación muchos a muchos con ingredientes
     */
    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'ingrediente_receta')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}