<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traemos todos los servicios de la base de datos
        $services = \App\Models\Service::all();
        
        // Se los enviamos a una vista (que crearemos ahora)
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        // 1. Validamos que no nos manden datos vacíos o erróneos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1', // RF A8 (importante para sumar tiempos)
            'price' => 'required|numeric|min:0', // RF C3
            'category' => 'required|string|max:100', // RF C2
        ]);

        // 2. Creamos el servicio usando el Modelo
        \App\Models\Service::create($validated);

        // 3. Nos devolvemos a la lista con un mensaje de éxito
        return redirect()->route('services.index')
                         ->with('success', '¡Servicio creado correctamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
{
    return view('services.edit', compact('service'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Service $service)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string',
        'price' => 'required|numeric|min:0',
        'duration_minutes' => 'required|integer|min:1',
        'description' => 'nullable|string|max:500',
    ]);

    $service->update($request->all());

    return redirect()->route('services.index')
        ->with('success', 'Servicio actualizado correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
