<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EcoCycle') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 relative">
        
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[10%] -right-[10%] w-[50%] h-[50%] rounded-full bg-gradient-to-br from-green-100/50 to-emerald-50/50 blur-3xl opacity-60"></div>
            <div class="absolute top-[20%] -left-[10%] w-[40%] h-[40%] rounded-full bg-gradient-to-tr from-blue-50/50 to-teal-50/50 blur-3xl opacity-60"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            <div class="mb-4">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="bg-green-100 p-3 rounded-2xl shadow-sm border border-green-200 group-hover:scale-105 transition transform duration-300">
                        <i class="fa-solid fa-recycle text-green-600 text-3xl"></i>
                    </div>
                    <span class="font-black text-3xl text-gray-900 tracking-tight">Eco<span class="text-green-600">Cycle</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white shadow-xl border border-gray-100 overflow-hidden sm:rounded-3xl relative z-10">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>