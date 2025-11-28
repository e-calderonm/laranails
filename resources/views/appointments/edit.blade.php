<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-rose-600 leading-tight">
            Editar Cita #{{ $appointment->id }} ✏️
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border-2 border-rose-100 p-8">
                
                <form method="POST" action="{{ route('appointments.update', $appointment) }}" class="space-y-6">
                    @csrf
                    @method('PUT') <div>
                        <label class="block font-bold text-sm text-gray-700">Cliente</label>
                        <select name="client_id" class="mt-2 block w-full rounded-xl border-rose-200">
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $appointment->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }} {{ $client->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-sm text-gray-700">Fecha</label>
                            <input type="date" name="date" value="{{ $appointment->date }}" required
                                class="mt-2 block w-full rounded-xl border-rose-200 shadow-sm">
                        </div>
                        <div>
                            <label class="block font-bold text-sm text-gray-700">Hora Inicio</label>
                            <input type="time" name="start_time" value="{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}" required
                                class="mt-2 block w-full rounded-xl border-rose-200 shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-sm text-gray-700 mb-3">Servicios</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-60 overflow-y-auto border border-gray-100 p-2 rounded-xl">
                            @foreach($services as $service)
                                <label class="flex items-center space-x-3 p-3 border border-rose-50 rounded-lg hover:bg-rose-50 cursor-pointer">
                                    <input type="checkbox" name="services[]" value="{{ $service->id }}" 
                                        {{ in_array($service->id, $currentServices) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-rose-500 h-5 w-5">
                                    <div class="text-sm">
                                        <span class="font-bold text-gray-700 block">{{ $service->name }}</span>
                                        <span class="text-gray-500 text-xs">${{ number_format($service->price, 0) }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-sm text-gray-700">Notas</label>
                        <textarea name="notes" rows="2" class="mt-2 block w-full rounded-xl border-rose-200">{{ $appointment->notes }}</textarea>
                    </div>

                    <div class="pt-4 flex justify-between">
                        <a href="{{ route('appointments.index') }}" class="text-gray-500 underline pt-2">Volver</a>
                        <button type="submit" class="bg-rose-500 text-white font-bold py-3 px-6 rounded-xl hover:bg-rose-600 transition">
                            Guardar Cambios
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>