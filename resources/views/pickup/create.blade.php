<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="bg-green-100 p-2 rounded-xl">
                <i class="fa-solid fa-truck-fast text-green-600"></i>
            </div>
            {{ __('Jadwalkan Penjemputan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="w-full lg:w-7/12">
                    <div class="bg-white rounded-3xl p-8 shadow-xl shadow-gray-200/40 border border-gray-100 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-green-50 rounded-full blur-3xl -mr-20 -mt-20 opacity-60"></div>
                        
                        <div class="relative z-10">
                            <div class="mb-8">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Pilih Waktu Penjemputan</h3>
                                <p class="text-gray-500">Tentukan kapan mitra kami harus datang mengambil sampah anorganikmu.</p>
                            </div>

                            <form action="{{ route('pickup.store') }}" method="POST" class="space-y-6">
                                @csrf

                                <div>
                                    <label for="pickup_date" class="block font-bold text-gray-700 mb-2">
                                        Tanggal & Jam <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fa-regular fa-calendar-check text-green-500 text-lg"></i>
                                        </div>
                                        <input type="datetime-local" id="pickup_date" name="pickup_date" value="{{ old('pickup_date') }}" required
                                            class="block w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 focus:ring-4 focus:ring-green-500/20 focus:border-green-500 focus:bg-white transition font-medium"
                                        >
                                    </div>
                                    <x-input-error :messages="$errors->get('pickup_date')" class="mt-2 text-red-600" />
                                </div>

                                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex gap-4">
                                    <div class="text-blue-500 mt-0.5">
                                        <i class="fa-solid fa-circle-info text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-blue-900">Perhatian Sebelum Meminta Jemputan:</h4>
                                        <ul class="text-sm text-blue-800 mt-1 space-y-1 list-disc list-inside">
                                            <li>Pastikan sampah sudah dipilah sesuai kategorinya.</li>
                                            <li>Sampah dalam keadaan kering dan bersih (tidak ada sisa makanan/cairan).</li>
                                            <li>Mitra akan menimbang sampah di lokasi untuk menentukan poin.</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-100 flex items-center justify-between gap-4">
                                    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 font-bold px-4 py-3 transition">
                                        Batal
                                    </a>
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-8 py-4 rounded-2xl transition transform hover:-translate-y-1 shadow-lg shadow-green-600/30 flex items-center gap-2">
                                        <i class="fa-solid fa-paper-plane"></i> Ajukan Penjemputan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-5/12 space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Kategori Sampah Diterima</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
                            <div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-bottle-water text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Plastik</h4>
                                <p class="text-xs text-gray-500 mt-1">Botol, Gelas, Kemasan, Kresek</p>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
                            <div class="bg-yellow-100 text-yellow-600 w-12 h-12 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-box-open text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Kertas</h4>
                                <p class="text-xs text-gray-500 mt-1">Kardus, Buku, Koran, HVS</p>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
                            <div class="bg-gray-100 text-gray-600 w-12 h-12 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-can-food text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Logam</h4>
                                <p class="text-xs text-gray-500 mt-1">Kaleng minuman, Paku, Panci</p>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
                            <div class="bg-teal-100 text-teal-600 w-12 h-12 rounded-full flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-wine-glass text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Kaca</h4>
                                <p class="text-xs text-gray-500 mt-1">Botol kaca utuh (tidak pecah)</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>