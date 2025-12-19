<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nombre' => 'Desayunos', 'descripcion' => 'Recetas para empezar el día con energía'],
            ['nombre' => 'Ensaladas', 'descripcion' => 'Platos frescos y saludables'],
            ['nombre' => 'Sopas', 'descripcion' => 'Caldos y cremas reconfortantes'],
            ['nombre' => 'Platos Principales', 'descripcion' => 'Comidas completas y sustanciosas'],
            ['nombre' => 'Postres', 'descripcion' => 'Dulces delicias para terminar'],
            ['nombre' => 'Bebidas', 'descripcion' => 'Refrescos y cócteles'],
            ['nombre' => 'Vegetarianas', 'descripcion' => 'Sin carne, llenas de sabor'],
            ['nombre' => 'Pastas', 'descripcion' => 'Platos italianos tradicionales'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}