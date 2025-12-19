<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingrediente;

class IngredienteSeeder extends Seeder
{
    public function run()
    {
        $ingredientes = [
            'Harina', 'Azúcar', 'Sal', 'Pimienta', 'Aceite de oliva',
            'Mantequilla', 'Huevos', 'Leche', 'Queso', 'Tomate',
            'Cebolla', 'Ajo', 'Pollo', 'Carne de res', 'Pescado',
            'Arroz', 'Pasta', 'Pan', 'Lechuga', 'Zanahoria',
            'Papa', 'Limón', 'Cilantro', 'Perejil', 'Albahaca',
            'Orégano', 'Comino', 'Pimentón', 'Chile', 'Vinagre',
            'Crema de leche', 'Yogurt', 'Chocolate', 'Vainilla', 'Canela'
        ];

        foreach ($ingredientes as $nombre) {
            Ingrediente::create(['nombre' => $nombre]);
        }
    }
}