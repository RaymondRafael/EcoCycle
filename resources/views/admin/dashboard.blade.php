<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="bg-gray-900 p-2 rounded-xl">
                <i class="fa-solid fa-user-shield text-white"></i>
            </div>
            {{ __('Admin Control Panel') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gray-900 rounded-3xl p-8 shadow-xl mb-8 flex flex-col md:flex-row justify-between items-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-green-500 rounded-full blur-3xl -mr-20 -mt-20 opacity-20"></div>
                <div class="relative z-10 text-white">
                    <h3 class="text-2xl font-bold mb-1">Selamat Datang, Administrator EcoCycle! 🌍</h3>
                    <p class="text-gray-400">Berikut adalah ringkasan sistem pengelolaan sampah hari ini.</p>
                </div>
                <div class="relative z-10 mt-4 md:mt-0">
                    <span class="bg-green-500/20 text-green-400 border border-green-500/30 px-4 py-2 rounded-full font-bold text-sm flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div> Sistem Aktif
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-6">
                    <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shrink-0">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-1">Total Pengguna (User)</p>
                        <h4 class="text-3xl font-black text-gray-900">{{ $totalUsers }} <span class="text-base text-gray-400 font-medium">Akun</span></h4>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-6">
                    <div class="w-16 h-16 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center text-2xl shrink-0">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-1">Menunggu Konfirmasi</p>
                        <h4 class="text-3xl font-black text-gray-900">{{ $pendingPickups }} <span class="text-base text-gray-400 font-medium">Permintaan</span></h4>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-6">
                    <div class="w-16 h-16 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-2xl shrink-0">
                        <i class="fa-solid fa-truck-ramp-box"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-1">Total Penjemputan</p>
                        <h4 class="text-3xl font-black text-gray-900">{{ $totalPickups }} <span class="text-base text-gray-400 font-medium">Selesai</span></h4>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Permintaan Terbaru</h3>
                        <a href="#" class="text-sm font-bold text-blue-600 hover:text-blue-700">Lihat Semua</a>
                    </div>
                    <div class="text-center py-8">
                        <i class="fa-solid fa-inbox text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">Belum ada data penjemputan baru yang perlu diproses.</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Menu Administrator</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="p-4 border border-gray-200 rounded-xl hover:border-green-500 hover:bg-green-50 transition text-left group">
                            <i class="fa-solid fa-truck text-green-600 text-xl mb-2 group-hover:scale-110 transition"></i>
                            <h4 class="font-bold text-gray-900">Kelola Penjemputan</h4>
                            <p class="text-xs text-gray-500 mt-1">Assign ke Mitra/Driver</p>
                        </button>
                        <button class="p-4 border border-gray-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition text-left group">
                            <i class="fa-solid fa-users-gear text-blue-600 text-xl mb-2 group-hover:scale-110 transition"></i>
                            <h4 class="font-bold text-gray-900">Kelola Pengguna</h4>
                            <p class="text-xs text-gray-500 mt-1">Lihat data & blokir akun</p>
                        </button>
                        <button class="p-4 border border-gray-200 rounded-xl hover:border-yellow-500 hover:bg-yellow-50 transition text-left group">
                            <i class="fa-solid fa-money-bill-transfer text-yellow-600 text-xl mb-2 group-hover:scale-110 transition"></i>
                            <h4 class="font-bold text-gray-900">Pencairan Saldo</h4>
                            <p class="text-xs text-gray-500 mt-1">Proses penarikan poin user</p>
                        </button>
                        <button class="p-4 border border-gray-200 rounded-xl hover:border-purple-500 hover:bg-purple-50 transition text-left group">
                            <i class="fa-solid fa-tags text-purple-600 text-xl mb-2 group-hover:scale-110 transition"></i>
                            <h4 class="font-bold text-gray-900">Katalog Harga</h4>
                            <p class="text-xs text-gray-500 mt-1">Update nilai tukar sampah</p>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>