<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        
        <div class="bg-gradient-to-r from-green-700 to-green-900 pb-24 pt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-black text-white tracking-tight">
                            Halo, {{ Auth::user()->name }}!
                        </h2>
                        <p class="text-green-200 mt-1">Siap menyelamatkan bumi hari ini?</p>
                    </div>
                    <div class="hidden sm:flex items-center gap-3 bg-white/20 px-4 py-2 rounded-full backdrop-blur-sm border border-white/20 shadow-lg">
                        <div class="bg-yellow-400 p-1.5 rounded-full text-yellow-900">
                            <i class="fa-solid fa-medal"></i>
                        </div>
                        <span class="text-white font-bold text-sm">Level: Pemula</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="md:col-span-2 bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-green-50 rounded-full blur-3xl -mr-20 -mt-20 opacity-60"></div>
                    
                    <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <div>
                            <p class="text-gray-500 font-medium mb-1">Total Saldo Aktif</p>
                            <h3 class="text-4xl sm:text-5xl font-black text-gray-900 mb-2">Rp 0<span class="text-xl text-gray-400 font-medium">,00</span></h3>
                            <p class="text-sm text-green-600 font-bold bg-green-50 inline-block px-3 py-1 rounded-full border border-green-100">
                                <i class="fa-solid fa-arrow-trend-up"></i> +Rp 0 bulan ini
                            </p>
                        </div>
                        <div class="w-full sm:w-auto flex flex-col gap-3">
                            <a href="{{ route('pickup.create') }}" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg shadow-green-600/30 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-truck-fast"></i> Jemput Sampah
                            </a>
                            <button class="w-full bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-6 py-3 rounded-xl font-bold transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-money-bill-transfer text-green-600"></i> Tarik Saldo
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-emerald-800 to-green-900 rounded-3xl p-8 shadow-xl relative overflow-hidden text-white flex flex-col justify-center">
                    <div class="absolute -bottom-10 -right-10 text-9xl text-white opacity-5 transform -rotate-12">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <p class="text-green-200 font-medium mb-4 relative z-10">Dampak Lingkunganmu</p>
                    <div class="flex items-end gap-3 relative z-10">
                        <h3 class="text-5xl font-black">0</h3>
                        <span class="text-xl text-green-300 font-medium mb-1">Kg</span>
                    </div>
                    <p class="text-sm text-green-100 mt-2 relative z-10">Sampah berhasil didaur ulang</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <a href="{{ route('history.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-green-300 hover:shadow-md transition text-center group">
                    <div class="w-14 h-14 mx-auto bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-history"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Riwayat</h4>
                </a>
                <a href="#" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-green-300 hover:shadow-md transition text-center group">
                    <div class="w-14 h-14 mx-auto bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Alamat Saya</h4>
                </a>
                <a href="#" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-green-300 hover:shadow-md transition text-center group">
                    <div class="w-14 h-14 mx-auto bg-yellow-50 text-yellow-600 rounded-full flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-gift"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Tukar Poin</h4>
                </a>
                <a href="#" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-green-300 hover:shadow-md transition text-center group">
                    <div class="w-14 h-14 mx-auto bg-red-50 text-red-600 rounded-full flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <h4 class="font-bold text-gray-900">Bantuan</h4>
                </a>
            </div>

            <div class="bg-white rounded-3xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Aktivitas Terakhir</h3>
                    <a href="#" class="text-sm font-bold text-green-600 hover:text-green-700">Lihat Semua</a>
                </div>
                
                <div class="text-center py-12 px-4">
                    <div class="w-24 h-24 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-box-open text-4xl text-gray-300"></i>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 mb-2">Belum ada aktivitas</h4>
                    <p class="text-gray-500 max-w-sm mx-auto">Mulai kumpulkan sampah anorganikmu dan jadwalkan penjemputan pertamamu sekarang!</p>
                    <button class="mt-6 bg-green-100 text-green-700 hover:bg-green-200 px-6 py-2.5 rounded-full font-bold transition">
                        Pelajari Cara Kerja
                    </button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>