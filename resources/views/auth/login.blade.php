<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - EcoCycle</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased text-gray-900 bg-white">

    <div class="flex min-h-screen">
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-green-700 to-green-900 relative overflow-hidden items-center justify-center">
            <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdib3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnPmNpcmNsZSBjeD0iMyIgY3k9IjMiIHI9IjMiIGZpbGw9IiNmZmZmZmYiLz48L2c+PC9nPjwvc3ZnPg==')]"></div>
            
            <div class="relative z-10 p-12 text-center">
                <div class="inline-block bg-white/20 p-4 rounded-2xl backdrop-blur-sm mb-6 border border-white/30 shadow-2xl">
                    <i class="fa-solid fa-recycle text-white text-6xl"></i>
                </div>
                <h1 class="text-5xl font-black text-white mb-4 tracking-tight">Selamat Datang Kembali</h1>
                <p class="text-green-100 text-lg max-w-md mx-auto leading-relaxed">
                    Setiap sampah yang kamu kumpulkan adalah langkah nyata menuju lingkungan yang lebih bersih.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-gray-50 relative">
            
            <a href="{{ url('/') }}" class="absolute top-8 left-8 text-gray-400 hover:text-green-600 transition flex items-center gap-2 font-medium">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>

            <div class="w-full max-w-md">
                <div class="lg:hidden text-center mb-10">
                    <div class="inline-block bg-green-100 p-3 rounded-xl mb-3 shadow-sm">
                        <i class="fa-solid fa-recycle text-green-600 text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-black text-gray-900">Eco<span class="text-green-600">Cycle</span></h2>
                </div>

                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Masuk ke Akunmu</h2>
                    <p class="text-gray-500">Mulai tukarkan sampahmu dengan saldo digital.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm" placeholder="contoh@email.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-medium text-green-600 hover:text-green-500 transition">
                                    Lupa sandi?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm" placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <label for="remember_me" class="ml-2 text-sm text-gray-600">Ingat Saya</label>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition transform hover:-translate-y-0.5 duration-200">
                        Masuk Sekarang <i class="fa-solid fa-arrow-right ml-2 mt-0.5"></i>
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-green-600 hover:text-green-500 transition">Daftar Gratis</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>