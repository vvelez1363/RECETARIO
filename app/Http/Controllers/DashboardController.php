<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Categoria;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                // Aquí es donde realmente contamos los registros de tu DB
                'totalRecetas' => Receta::count(),
                'totalCategorias' => Categoria::count(),
            ]
        ]);
    }
}