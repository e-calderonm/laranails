<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-rose-600 leading-tight">
            {{ __('Panel Principal') }} 💅
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Tarjeta de bienvenida -->
            <div class="bg-white p-8 rounded-2xl shadow-md border border-rose-100 mb-8">
                <h3 class="text-2xl font-bold text-rose-600">¡Bienvenido a LaraNails! 💗</h3>
                <p class="text-gray-600 mt-2">
                    Gestiona tus clientes, servicios y citas desde un solo lugar.
                </p>
            </div>

            <!-- Cuadros de estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-rose-50 p-6 rounded-2xl shadow border border-rose-100">
                    <p class="text-gray-500 text-sm">Citas Proximas</p>
                    <h2 class="text-4xl font-bold text-rose-600 mt-1">
                        {{ \App\Models\Appointment::where('date', today())->count() }}
                    </h2>
                </div>

                <div class="bg-purple-50 p-6 rounded-2xl shadow border border-purple-100">
                    <p class="text-gray-500 text-sm">Servicios Activos</p>
                    <h2 class="text-4xl font-bold text-purple-600 mt-1">
                        {{ \App\Models\Service::where('is_active', true)->count() }}
                    </h2>
                </div>

                <div class="bg-blue-50 p-6 rounded-2xl shadow border border-blue-100">
                    <p class="text-gray-500 text-sm">Clientes Registrados</p>
                    <h2 class="text-4xl font-bold text-blue-600 mt-1">
                        {{ \App\Models\Client::count() }}
                    </h2>
                </div>

            </div>

            <!-- Accesos rápidos -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <a href="{{ route('appointments.index') }}" class="block bg-white p-6 rounded-2xl shadow hover:shadow-lg transition border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-700">Agenda de Citas</h3>
                    <p class="text-sm text-gray-500 mt-1">Ver o programar nuevas citas.</p>
                </a>

                <a href="{{ route('clients.index') }}" class="block bg-white p-6 rounded-2xl shadow hover:shadow-lg transition border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-700">Clientes</h3>
                    <p class="text-sm text-gray-500 mt-1">Administrar clientes registrados.</p>
                </a>

                <a href="{{ route('services.index') }}" class="block bg-white p-6 rounded-2xl shadow hover:shadow-lg transition border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-700">Servicios</h3>
                    <p class="text-sm text-gray-500 mt-1">Gestiona tus servicios y precios.</p>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>
