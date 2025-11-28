<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catálogo de Servicios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-end mb-4 px-4 sm:px-0">
                <a href="{{ route('services.create') }}" class="bg-pink-300 hover:bg-pink-400 text-white font-bold py-2 px-4 rounded-full shadow-lg transition duration-300">
                    + Nuevo Servicio
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($services->isEmpty())
                        <p class="text-center text-gray-500 py-10">No hay servicios registrados aún.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($services as $service)
                                <div class="border border-pink-100 rounded-xl p-6 hover:shadow-md transition bg-pink-50">
                                    <div class="flex justify-between items-start">
                                        <h3 class="text-lg font-bold text-pink-600">{{ $service->name }}</h3>
                                        <span class="bg-white text-pink-500 text-xs font-bold px-2 py-1 rounded border border-pink-200">
                                            ${{ number_format($service->price, 0) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 mt-2 text-sm">{{ $service->description }}</p>
                                    <div class="mt-4 flex justify-between items-center text-sm text-gray-500">
                                        <span>⏱ {{ $service->duration_minutes }} min</span>
                                        <span>📂 {{ $service->category }}</span>
                                    </div>
                                    
                                    <div class="mt-4 flex gap-2 border-t border-pink-200 pt-3">
                                        <a href="{{ route('services.edit', $service) }}" class="text-indigo-500 hover:text-indigo-700 font-medium text-sm">Editar</a>
                                        </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>