<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // RF B4: Listar y Buscar Clientes
    public function index(Request $request)
    {
        $query = $request->input('search');

        if ($query) {
            // Buscamos por nombre, apellido o cédula
            $clients = Client::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('last_name', 'LIKE', "%{$query}%")
                            ->orWhere('cedula', 'LIKE', "%{$query}%")
                            ->get();
        } else {
            $clients = Client::all();
        }

        return view('clients.index', compact('clients'));
    }

    // RF B1: Formulario de creación
    public function create()
    {
        return view('clients.create');
    }

    // RF B1: Guardar Cliente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email', // El correo debe ser único
            'phone' => 'required|string|max:20',
            'alias' => 'nullable|string|max:50',
            'cedula' => 'nullable|string|max:20|unique:clients,cedula',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')
                         ->with('success', '¡Cliente registrada correctamente!');
    }

    // RF B3: Editar Cliente
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    // RF B3: Actualizar Cliente
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $client->id, // Ignoramos el email propio al editar
            'phone' => 'required|string|max:20',
            'alias' => 'nullable|string|max:50',
            'cedula' => 'nullable|string|max:20|unique:clients,cedula,' . $client->id,
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
                         ->with('success', '¡Datos actualizados!');
    }
}