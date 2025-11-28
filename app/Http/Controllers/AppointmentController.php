<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Librería para sumar horas y minutos

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traemos las citas ordenadas por fecha y hora más reciente (RF D1)
        $appointments = Appointment::with(['client', 'services']) // Eager Loading para optimizar
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)

    {
        // Traemos clientes y servicios activos para mostrarlos en el formulario
        $clients = \App\Models\Client::all();
        $services = \App\Models\Service::where('is_active', true)->get();

        $selectedClient = $request->client_id;

        return view('appointments.create', compact('clients', 'services', 'selectedClient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        // 1. Validación básica de formulario
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date|after_or_equal:today', // No agendar en el pasado
            'start_time' => 'required',
            'services' => 'required|array|min:1', // Al menos 1 servicio (RF A3)
            'services.*' => 'exists:services,id',
        ]);

        // 2. Cálculos Matemáticos (RF A8 y D3)
        $services = Service::whereIn('id', $request->services)->get();
        
        $totalDuration = 0;
        $totalPrice = 0;
        $pivotData = []; // Para guardar en la tabla intermedia

        foreach ($services as $service) {
            $totalDuration += $service->duration_minutes;
            $totalPrice += $service->price;
            
            // Preparamos los datos para la tabla pivote (RF A3)
            $pivotData[$service->id] = [
                'price_at_booking' => $service->price // Guardamos precio histórico (RF C3)
            ];
        }

        // 3. Calcular Hora de Finalización (RF A8)
        // Usamos Carbon para manejar horas
        $start = Carbon::parse($request->date . ' ' . $request->start_time);
        $end = $start->copy()->addMinutes($totalDuration);

        // 4. Validar Disponibilidad / Choque de horarios (RF A5, A6)
        // Buscamos si hay ALGUNA cita ese día que se cruce con este horario
        $overlap = Appointment::where('date', $request->date)
            ->where('status', '!=', 'cancelada') // Ignoramos las canceladas
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_time', [$start->format('H:i'), $end->format('H:i')])
                      ->orWhereBetween('end_time', [$start->format('H:i'), $end->format('H:i')])
                      ->orWhere(function ($q) use ($start, $end) {
                          $q->where('start_time', '<', $start->format('H:i'))
                            ->where('end_time', '>', $end->format('H:i'));
                      });
            })
            ->exists(); // Devuelve true si encuentra choque

        if ($overlap) {
            return back()
                ->withInput()
                ->withErrors(['start_time' => '¡Conflicto! Ya existe una cita agendada en ese rango de horario (' . $start->format('H:i') . ' - ' . $end->format('H:i') . ').']);
        }

        // 5. Guardar la Cita (RF A4: Guardamos el usuario logueado)
        $appointment = Appointment::create([
            'user_id' => Auth::id(), // El administrador/empleado actual
            'client_id' => $request->client_id,
            'date' => $request->date,
            'start_time' => $start->format('H:i:s'),
            'end_time' => $end->format('H:i:s'),
            'total_duration_minutes' => $totalDuration,
            'total_price' => $totalPrice,
            'status' => 'confirmada', // Estado inicial
            'notes' => $request->notes,
        ]);

        // 6. Guardar la relación Muchos a Muchos (Tabla Pivote)
        $appointment->services()->attach($pivotData);

        // 7. Éxito
        return redirect()->route('appointments.index')
            ->with('success', '¡Cita agendada exitosamente! Duración total: ' . $totalDuration . ' min.');
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
    // Muestra el formulario de edición (RF A9)
    public function edit(Appointment $appointment)
    {
        $clients = \App\Models\Client::all();
        $services = \App\Models\Service::where('is_active', true)->get();
        
        // Obtenemos los IDs de los servicios actuales para marcarlos en el checkbox
        $currentServices = $appointment->services->pluck('id')->toArray();

        return view('appointments.edit', compact('appointment', 'clients', 'services', 'currentServices'));
    }

    // Guarda los cambios de la cita (RF A9)
    public function update(\Illuminate\Http\Request $request, Appointment $appointment)
    {
        // 1. Validamos igual que en el Store
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'services' => 'required|array|min:1',
        ]);

        // 2. Recalculamos Totales
        $services = \App\Models\Service::whereIn('id', $request->services)->get();
        $totalDuration = $services->sum('duration_minutes');
        $totalPrice = $services->sum('price');
        
        // 3. Recalculamos Hora Final
        $start = Carbon::parse($request->date . ' ' . $request->start_time);
        $end = $start->copy()->addMinutes($totalDuration);

        // 4. Validar Choque (¡OJO! Excluyendo la cita actual para que no choque consigo misma)
        $overlap = Appointment::where('date', $request->date)
            ->where('id', '!=', $appointment->id) // <--- ESTO ES CLAVE
            ->where('status', '!=', 'cancelada')
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_time', [$start->format('H:i'), $end->format('H:i')])
                      ->orWhereBetween('end_time', [$start->format('H:i'), $end->format('H:i')]);
            })
            ->exists();

        if ($overlap) {
            return back()->withInput()->withErrors(['start_time' => '¡Conflicto! El nuevo horario choca con otra cita.']);
        }

        // 5. Actualizamos
      // 5. Actualizamos la cita
$appointment->update([
    'client_id' => $request->client_id,
    'date' => $request->date,
    'start_time' => $start->format('H:i:s'),
    'end_time' => $end->format('H:i:s'),
    'total_duration_minutes' => $totalDuration,
    'total_price' => $totalPrice,
    'notes' => $request->notes,
]);

// === NUEVO: generar datos pivot correctos ===
$pivotData = [];
foreach ($services as $service) {
    $pivotData[$service->id] = [
        'price_at_booking' => $service->price
    ];
}

// === NUEVO: sincronizar garantizando price_at_booking ===
$appointment->services()->sync($pivotData);

return redirect()->route('appointments.index')->with('success', '¡Cita reprogramada correctamente!');

    }

    // Función personalizada para cancelar sin borrar (Soft Delete manual)
    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelada']);
        return back()->with('success', 'La cita ha sido cancelada.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
