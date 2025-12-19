<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Categoria;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RecetaController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Receta::with(['categoria', 'user', 'ingredientes']);

        // Búsqueda por nombre
        if ($request->filled('search')) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        // Filtro por dificultad
        if ($request->filled('dificultad')) {
            $query->where('dificultad', $request->dificultad);
        }

        // Filtro por ingrediente
        if ($request->filled('ingrediente')) {
            $query->whereHas('ingredientes', function($q) use ($request) {
                $q->where('ingredientes.id', $request->ingrediente);
            });
        }

        // Ordenamiento
        $ordenamiento = $request->get('orden', 'reciente');
        switch ($ordenamiento) {
            case 'antiguo':
                $query->oldest();
                break;
            case 'nombre':
                $query->orderBy('nombre');
                break;
            case 'tiempo':
                $query->orderBy('tiempo_preparacion');
                break;
            default:
                $query->latest();
                break;
        }

        $recetas = $query->paginate(12)->withQueryString();

        return Inertia::render('Recetas/Index', [
            'recetas' => $recetas,
            'categorias' => Categoria::all(),
            'ingredientes' => Ingrediente::orderBy('nombre')->get(),
            'filtros' => [
                'search' => $request->search,
                'categoria' => $request->categoria,
                'dificultad' => $request->dificultad,
                'ingrediente' => $request->ingrediente,
                'orden' => $ordenamiento,
            ]
        ]);
    }

    public function show(Receta $receta)
    {
        $receta->load(['categoria', 'user', 'ingredientes']);

        return Inertia::render('Recetas/Show', [
            'receta' => $receta
        ]);
    }

    public function exportarPdf(Receta $receta)
    {
        $receta->load(['categoria', 'user', 'ingredientes']);

        $pdf = Pdf::loadView('pdf.receta', ['receta' => $receta]);
        
        return $pdf->download('receta-' . $receta->id . '.pdf');
    }

    public function compartir(Receta $receta)
    {
        $receta->load(['categoria', 'user', 'ingredientes']);
        
        $url = route('recetas.show', $receta->id);
        
        return response()->json([
            'url' => $url,
            'titulo' => $receta->nombre,
            'descripcion' => $receta->descripcion
        ]);
    }

    public function create()
    {
        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all();

        return Inertia::render('Recetas/Create', [
            'categorias' => $categorias,
            'ingredientes' => $ingredientes
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'instrucciones' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'tiempo_preparacion' => 'required|integer|min:1',
            'porciones' => 'required|integer|min:1',
            'dificultad' => 'required|in:fácil,media,difícil',
            'imagen' => 'nullable|image|max:2048',
            'ingredientes' => 'required|array|min:1',
            'ingredientes.*.id' => 'required|exists:ingredientes,id',
            'ingredientes.*.cantidad' => 'required|string'
        ]);

        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('recetas', 'public');
        }

        $receta = Receta::create([
            'user_id' => Auth::id(),
            'categoria_id' => $validated['categoria_id'],
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'instrucciones' => $validated['instrucciones'],
            'tiempo_preparacion' => $validated['tiempo_preparacion'],
            'porciones' => $validated['porciones'],
            'dificultad' => $validated['dificultad'],
            'imagen' => $imagenPath
        ]);

        foreach ($validated['ingredientes'] as $ingrediente) {
            $receta->ingredientes()->attach($ingrediente['id'], [
                'cantidad' => $ingrediente['cantidad']
            ]);
        }

        return redirect()->route('recetas.index')
            ->with('success', 'Receta creada exitosamente');
    }

    public function edit(Receta $receta)
    {
        $this->authorize('update', $receta);

        $receta->load('ingredientes');
        $categorias = Categoria::all();
        $ingredientes = Ingrediente::all();

        return Inertia::render('Recetas/Edit', [
            'receta' => $receta,
            'categorias' => $categorias,
            'ingredientes' => $ingredientes
        ]);
    }

    public function update(Request $request, Receta $receta)
    {
        $this->authorize('update', $receta);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'instrucciones' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'tiempo_preparacion' => 'required|integer|min:1',
            'porciones' => 'required|integer|min:1',
            'dificultad' => 'required|in:fácil,media,difícil',
            'imagen' => 'nullable|image|max:2048',
            'ingredientes' => 'required|array|min:1',
            'ingredientes.*.id' => 'required|exists:ingredientes,id',
            'ingredientes.*.cantidad' => 'required|string'
        ]);

        if ($request->hasFile('imagen')) {
            if ($receta->imagen) {
                Storage::disk('public')->delete($receta->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('recetas', 'public');
        }

        $receta->update($validated);

        $receta->ingredientes()->detach();
        foreach ($validated['ingredientes'] as $ingrediente) {
            $receta->ingredientes()->attach($ingrediente['id'], [
                'cantidad' => $ingrediente['cantidad']
            ]);
        }

        return redirect()->route('recetas.show', $receta)
            ->with('success', 'Receta actualizada exitosamente');
    }

    public function destroy(Receta $receta)
    {
        $this->authorize('delete', $receta);

        if ($receta->imagen) {
            Storage::disk('public')->delete($receta->imagen);
        }

        $receta->delete();

        return redirect()->route('recetas.index')
            ->with('success', 'Receta eliminada exitosamente');
    }
}