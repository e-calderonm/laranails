<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-rose-600 leading-tight">
            Editar Cliente: {{ $client->name }} ✏️
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border-2 border-rose-100 p-8">
                
                <form method="POST" action="{{ route('clients.update', $client) }}" class="space-y-4">
                    @csrf
                    @method('PUT') <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Nombre *</label>
                            <input type="text" name="name" value="{{ $client->name }}" required class="mt-1 block w-full rounded-xl border-rose-200 focus:border-rose-500 shadow-sm">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Apellido *</label>
                            <input type="text" name="last_name" value="{{ $client->last_name }}" required class="mt-1 block w-full rounded-xl border-rose-200 focus:border-rose-500 shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Alias / Apodo</label>
                        <input type="text" name="alias" value="{{ $client->alias }}" class="mt-1 block w-full rounded-xl border-rose-200 focus:border-rose-500 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Teléfono *</label>
                        <input type="text" name="phone" value="{{ $client->phone }}" required class="mt-1 block w-full rounded-xl border-rose-200 focus:border-rose-500 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Correo Electrónico *</label>
                        <input type="email" name="email" value="{{ $client->email }}" required class="mt-1 block w-full rounded-xl border-rose-200 focus:border-rose-500 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Cédula</label>
                        <input type="text" name="cedula" value="{{ $client->cedula }}" class="mt-1 block w-full rounded-xl border-rose-200 focus:border-rose-500 shadow-sm">
                    </div>

                    <div class="pt-4 flex justify-between items-center">
                        <a href="{{ route('clients.index') }}" class="text-gray-500 underline text-sm">Cancelar</a>
                        <button type="submit" class="bg-rose-500 text-white font-bold py-2 px-6 rounded-xl hover:bg-rose-600 transition shadow-md">
                            Actualizar Datos
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
