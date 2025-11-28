<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LaraNails - Gestión de Belleza</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-rose-50">
    
    <div class="relative flex justify-between items-center p-6 lg:p-8 max-w-7xl mx-auto">
        <div class="text-2xl font-bold text-rose-600 tracking-wider">
            LARANAILS 💅
        </div>

        <div>
            @if (Route::has('login'))
                <div class="">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-rose-600 hover:text-rose-500 focus:outline focus:outline-2 focus:rounded-sm focus:outline-rose-500">Mi Panel</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-rose-400 hover:bg-rose-500 text-white font-bold py-2 px-6 rounded-full shadow-lg transition transform hover:scale-105">
                            Ingresar al Sistema
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12 flex flex-col items-center text-center">
        
        <h1 class="text-4xl md:text-6xl font-extrabold text-gray-800 mb-6">
            Gestión Inteligente para <br>
            <span class="text-rose-500">Tu Salón de Belleza</span>
        </h1>

        <p class="text-lg text-gray-600 max-w-2xl mb-10">
            Agenda citas, gestiona tus servicios y controla tu negocio desde cualquier dispositivo. 
            Diseñado para iPhone y móviles.
        </p>

        <div class="bg-white p-8 rounded-3xl shadow-xl border-2 border-rose-100 mb-10 transform rotate-1 hover:rotate-0 transition duration-500">
            <img src="/logo.png" alt="LaraNails Logo" class="h-25 w-22 mx-auto transform rotate-1 hover:rotate-0 transition duration-500">

            <p class="mt-4 font-semibold text-gray-500">Agenda tu cita hoy</p>
        </div>

        <div class="text-center text-sm text-gray-400 mt-12">
            &copy; {{ date('Y') }} LaraNails. Sistema de Gestión de Belleza.
        </div>
    </div>
</body>
</html>