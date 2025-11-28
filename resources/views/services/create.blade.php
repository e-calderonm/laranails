<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-rose-600 leading-tight">
            {{ __('Crear Nuevo Servicio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border-2 border-rose-100">
                <div class="p-8">
                    
                    <form method="POST" action="{{ route('services.store') }}" class="space-y-6">
                        @csrf <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Nombre del Servicio</label>
                            <input type="text" name="name" id="name" required
                                class="mt-1 block w-full rounded-xl border-rose-200 focus:border-rose-500 focus:ring-rose-500 shadow-sm"
                                placeholder="Ej: Manicura Semipermanente">
                        </div>

                        <div>
    <label for="category" class="block font-medium text-sm text-gray-700">Categoría</label>
    <select name="category" id="category" class="mt-1 block w-full rounded-xl border-rose-200 focus:border-rose-500 focus:ring-rose-500 shadow-sm">
        <option value="UÑAS">UÑAS</option>
        <option value="CEJAS, PESTAÑAS Y OTROS">CEJAS, PESTAÑAS Y OTROS</option>
        <option value="DEPILACIÓN">DEPILACIÓN</option>
    </select>
</div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block font-medium text-sm text-gray-700">Precio ($)</label>
                                <input type="number" name="price" id="price" required min="0" step="0.01"
                                    class="mt-1 block w-full rounded-xl border-rose-200 focus:border-rose-500 focus:ring-rose-500 shadow-sm"
                                    placeholder="0.00">
                            </div>

                            <div>
                                <label for="duration_minutes" class="block font-medium text-sm text-gray-700">Duración (min)</label>
                                <input type="number" name="duration_minutes" id="duration_minutes" required min="1"
                                    class="mt-1 block w-full rounded-xl border-rose-200 focus:border-rose-500 focus:ring-rose-500 shadow-sm"
                                    placeholder="60">
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block font-medium text-sm text-gray-700">Descripción (Opcional)</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full rounded-xl border-rose-200 focus:border-rose-500 focus:ring-rose-500 shadow-sm"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-4">
                            <a href="{{ route('services.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 px-6 rounded-xl shadow-md transition transform hover:scale-105">
                                Guardar Servicio
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>