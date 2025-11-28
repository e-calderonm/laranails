<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-rose-600 leading-tight">
            {{ __('Gestión de Clientes') }} 👩‍🦰
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 px-4 gap-4">
                
                <form method="GET" action="{{ route('clients.index') }}" class="w-full md:w-1/2 flex gap-2">
                    <input type="text" name="search" placeholder="Buscar por nombre o cédula..." 
                        class="w-full rounded-full border-rose-200 focus:border-rose-500 focus:ring-rose-500 shadow-sm"
                        value="{{ request('search') }}">
                    <button type="submit" class="bg-rose-400 text-white px-4 py-2 rounded-full hover:bg-rose-500 transition">
                        🔍
                    </button>
                    @if(request('search'))
                        <a href="{{ route('clients.index') }}" class="text-gray-500 text-sm flex items-center hover:underline">Limpiar</a>
                    @endif
                </form>

                <a href="{{ route('clients.create') }}" class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-2 px-6 rounded-full shadow-lg transition duration-300 w-full md:w-auto text-center">
                    + Nueva Cliente
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
                @forelse ($clients as $client)
                    <div class="bg-white rounded-2xl p-6 shadow-md border-l-4 border-rose-400 hover:shadow-lg transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $client->name }} {{ $client->last_name }}</h3>
                                @if($client->alias)
                                    <span class="text-xs font-semibold text-rose-500 bg-rose-50 px-2 py-1 rounded-full">
                                        "{{ $client->alias }}"
                                    </span>
                                @endif
                            </div>
                            <div class="text-right">
                                <a href="{{ route('clients.edit', $client) }}" class="text-gray-400 hover:text-rose-500">
                                    ✏️
                                </a>
                            </div>
                        </div>
                        
                        <div class="mt-4 space-y-2 text-sm text-gray-600">
                            <p class="flex items-center gap-2">
                                📞 <span>{{ $client->phone }}</span>
                            </p>
                            <p class="flex items-center gap-2">
                                📧 <span class="truncate">{{ $client->email }}</span>
                            </p>
                            @if($client->cedula)
                            <p class="flex items-center gap-2">
                                🆔 <span>{{ $client->cedula }}</span>
                            </p>
                            @endif
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('appointments.create', ['client_id' => $client->id]) }}"
                              class="block w-full text-center text-rose-500 font-bold text-sm hover:text-rose-700">
                              📅 Agendar Cita
                             </a>

                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-gray-500">
                        No se encontraron clientes. ¡Registra la primera!
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>