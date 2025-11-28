<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-rose-600 leading-tight">
            {{ __('Agenda de Citas') }} 🗓️
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between mb-4 px-4 sm:px-0">
                <h3 class="text-gray-700 font-bold text-lg">Historial y Próximas Citas</h3>
                <a href="{{ route('appointments.create') }}" class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-2 px-4 rounded-full shadow-lg transition">
                    + Agendar Nueva
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-rose-50">
                        <tr>
                            <th class="px-6 py-3">Fecha / Hora</th>
                            <th class="px-6 py-3">Cliente</th>
                            <th class="px-6 py-3">Servicios</th>
                            <th class="px-6 py-3">Total / Duración</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $cita)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($cita->date)->format('d/m/Y') }} <br>
                                    <span class="text-rose-500 font-bold">
                                        {{ \Carbon\Carbon::parse($cita->start_time)->format('g:i A') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $cita->client->name }} {{ $cita->client->last_name }} <br>
                                    <span class="text-xs text-gray-400">{{ $cita->client->phone }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @foreach($cita->services as $service)
                                        <span class="bg-purple-100 text-purple-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded border border-purple-400">
                                            {{ $service->name }}
                                        </span><br>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    ${{ number_format($cita->total_price, 0) }} <br>
                                    <span class="text-xs">⏱ {{ $cita->total_duration_minutes }} min</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($cita->status == 'confirmada')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Confirmada</span>
                                    @elseif($cita->status == 'cancelada')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Cancelada</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ ucfirst($cita->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
    <div class="flex items-center gap-4">
        <a href="{{ route('appointments.edit', $cita) }}" class="text-blue-500 hover:text-blue-700 font-bold text-xs uppercase">
            Editar
        </a>

        @if($cita->status != 'cancelada')
            <form action="{{ route('appointments.cancel', $cita) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas cancelar esta cita?');">
                @csrf
                @method('PUT')
                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase">
                    Cancelar
                </button>
            </form>
        @endif
    </div>
</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">No hay citas registradas aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>