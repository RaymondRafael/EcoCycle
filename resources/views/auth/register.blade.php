<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - EcoCycle</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased text-gray-900 bg-white">

    <div class="flex min-h-screen flex-row-reverse">
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-green-50 to-green-100 border-l border-green-200 relative overflow-hidden items-center justify-center">
            <div class="absolute -top-[20%] -right-[10%] w-[70%] h-[70%] rounded-full bg-gradient-to-br from-green-200/50 to-emerald-100/50 blur-3xl opacity-70"></div>
            
            <div class="relative z-10 p-12 text-center">
                <div class="relative w-64 h-64 mx-auto mb-10 flex items-center justify-center group">
                    <div class="absolute inset-0 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-60 animate-pulse"></div>
                    <div class="absolute inset-4 bg-emerald-200 rounded-full mix-blend-multiply filter blur-lg opacity-60 animate-pulse" style="animation-delay: 1s;"></div>
                    
                    <div class="relative bg-white/90 backdrop-blur p-10 rounded-full shadow-2xl border border-white transform group-hover:-rotate-90 transition duration-700 ease-in-out">
                        <i class="fa-solid fa-recycle text-7xl text-transparent bg-clip-text bg-gradient-to-br from-green-500 to-emerald-600"></i>
                    </div>

                    <div class="absolute -top-2 right-4 bg-white p-4 rounded-full shadow-xl border border-green-50 animate-bounce" style="animation-duration: 3s;">
                        <i class="fa-solid fa-leaf text-green-500 text-xl"></i>
                    </div>
                    
                    <div class="absolute bottom-4 left-4 bg-white p-4 rounded-full shadow-xl border border-yellow-50 animate-bounce" style="animation-duration: 4s;">
                        <i class="fa-solid fa-coins text-yellow-400 text-xl"></i>
                    </div>
                </div>

                <h1 class="text-4xl font-black text-gray-900 mb-4">Bergabung Bersama Kami</h1>
                <p class="text-gray-600 text-lg max-w-md mx-auto">
                    Jadilah bagian dari 500+ pahlawan lingkungan yang telah berkontribusi mengurangi emisi karbon di Indonesia.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-white relative shadow-[10px_0_30px_rgba(0,0,0,0.05)] z-20">
            
            <a href="{{ url('/') }}" class="absolute top-8 right-8 text-gray-400 hover:text-green-600 transition flex items-center gap-2 font-medium">
                Kembali <i class="fa-solid fa-arrow-right"></i>
            </a>

            <div class="w-full max-w-md">
                <div class="mb-10">
                    <div class="inline-block bg-green-100 p-2.5 rounded-xl mb-4 shadow-sm">
                        <i class="fa-solid fa-recycle text-green-600 text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h2>
                    <p class="text-gray-500">Lengkapi data di bawah ini untuk bergabung.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-regular fa-user text-gray-400"></i>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition" placeholder="John Doe">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition" placeholder="contoh@email.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="new-password" class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition" placeholder="Minimal 8 karakter">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-circle-check text-gray-400"></i>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:bg-white transition" placeholder="Ulangi kata sandi">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition transform hover:-translate-y-0.5 duration-200 mt-4">
                        Daftar Akun
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-gray-600">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="font-bold text-green-600 hover:text-green-500 transition">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>