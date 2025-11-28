<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-rose-600 leading-tight">
            {{ __('Nueva Cita') }} 📅
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border-2 border-rose-100 p-8">

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 text-red-600 p-4 rounded-xl text-sm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>⚠️ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('appointments.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block font-bold text-sm text-gray-700">Seleccionar Cliente</label>
                        <select name="client_id" required
                            class="mt-2 block w-full rounded-xl border-rose-200 focus:border-rose-500 focus:ring-rose-500 shadow-sm">
                            <option value="">-- Buscar Cliente --</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" @if(isset($selectedClient) && $selectedClient == $client->id) selected @endif>

                                    {{ $client->name }} {{ $client->last_name }} ({{ $client->phone }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-1">¿No aparece? <a href="{{ route('clients.create') }}"
                                class="text-rose-500 underline">Regístralo aquí</a></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-sm text-gray-700">Fecha</label>
                            <input type="date" name="date" required min="{{ date('Y-m-d') }}"
                                class="mt-2 block w-full rounded-xl border-rose-200 focus:border-rose-500 focus:ring-rose-500 shadow-sm">
                        </div>
                        <div>
                            <label class="block font-bold text-sm text-gray-700">Hora de Inicio</label>
                            <input type="time" name="start_time" required
                                class="mt-2 block w-full rounded-xl border-rose-200 focus:border-rose-500 focus:ring-rose-500 shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-sm text-gray-700 mb-3">Servicios a Realizar</label>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-60 overflow-y-auto border border-gray-100 p-2 rounded-xl">
                            @foreach($services as $service)
                                <label
                                    class="flex items-start gap-4 p-5 border border-rose-100 rounded-xl hover:bg-rose-50 cursor-pointer transition">
                                    <input type="checkbox" name="services[]" value="{{ $service->id }}"
                                        class="mt-1 rounded border-gray-300 text-rose-500 shadow-sm focus:ring-rose-500 h-5 w-5">

                                    <div class="text-sm leading-relaxed space-y-1">
                                        <span class="font-semibold text-gray-800 block text-base">
                                            {{ $service->name }}
                                        </span>

                                        <span class="text-gray-500 text-xs">
                                            ⏱ {{ $service->duration_minutes }} min |
                                            ${{ number_format($service->price, 0) }}
                                        </span>
                                    </div>
                                </label>

                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 mt-2">* Selecciona varios si es necesario. El sistema calculará
                            el total.</p>
                    </div>

                    <div>
                        <label class="block font-bold text-sm text-gray-700">Notas Adicionales</label>
                        <textarea name="notes" rows="2"
                            class="mt-2 block w-full rounded-xl border-rose-200 focus:border-rose-500 focus:ring-rose-500 shadow-sm"></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-rose-500 text-white font-bold py-3 px-6 rounded-xl hover:bg-rose-600 transition shadow-lg transform active:scale-95">
                            📅 Confirmar Cita
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>