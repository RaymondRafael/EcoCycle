<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="{{ Auth::user()->role === 'b2b_user' ? 'bg-teal-100' : 'bg-green-100' }} p-2 rounded-xl">
                <i class="fa-solid {{ Auth::user()->role === 'b2b_user' ? 'fa-truck' : 'fa-truck-fast' }} {{ Auth::user()->role === 'b2b_user' ? 'text-teal-600' : 'text-green-600' }}"></i>
            </div>
            {{ Auth::user()->role === 'b2b_user' ? __('Jadwalkan Armada Logistik') : __('Jadwalkan Penjemputan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="w-full lg:w-7/12">
                    <div class="bg-white rounded-3xl p-8 shadow-xl shadow-gray-200/40 border border-gray-100 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-64 h-64 {{ Auth::user()->role === 'b2b_user' ? 'bg-teal-50' : 'bg-green-50' }} rounded-full blur-3xl -mr-20 -mt-20 opacity-60"></div>
                        
                        <div class="relative z-10">
                            <div class="mb-8">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Pilih Lokasi & Waktu</h3>
                                <p class="text-gray-500">
                                    {{ Auth::user()->role === 'b2b_user' ? 'Pilih titik cabang dan jadwal kedatangan armada untuk mengangkut limbah operasional bisnismu.' : 'Pilih alamat dan tentukan kapan mitra kami harus datang mengambil sampah anorganikmu.' }}
                                </p>
                            </div>

                            <form action="{{ route('pickup.store') }}" method="POST" class="space-y-6">
                                @csrf

                                <div>
                                    <div class="flex justify-between items-end mb-3">
                                        <label class="block font-bold text-gray-700">Pilih Lokasi Penjemputan <span class="text-red-500">*</span></label>
                                        <a href="{{ route('address.edit') }}" class="text-xs font-bold {{ Auth::user()->role === 'b2b_user' ? 'text-teal-600 hover:text-teal-800' : 'text-green-600 hover:text-green-800' }}"><i class="fa-solid fa-plus"></i> Tambah Baru</a>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @forelse($addresses as $address)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="address_id" value="{{ $address->id }}" class="peer sr-only" {{ $address->is_primary ? 'checked' : '' }} required>
                                                <div class="h-full p-4 rounded-2xl border-2 transition-all {{ Auth::user()->role === 'b2b_user' ? 'peer-checked:border-teal-500 peer-checked:bg-teal-50' : 'peer-checked:border-green-500 peer-checked:bg-green-50' }} border-gray-200 hover:border-gray-300 relative overflow-hidden">
                                                    
                                                    <div class="absolute top-4 right-4">
                                                        <i class="fa-solid fa-circle-check text-xl opacity-0 peer-checked:opacity-100 {{ Auth::user()->role === 'b2b_user' ? 'text-teal-600' : 'text-green-600' }} transition-opacity duration-300"></i>
                                                    </div>

                                                    <div class="flex items-center gap-2 mb-2 pr-8">
                                                        <span class="font-bold text-gray-900 truncate">{{ $address->label_name }}</span>
                                                        @if($address->is_primary)
                                                            <span class="text-[9px] uppercase tracking-widest font-bold px-2 py-0.5 rounded-md {{ Auth::user()->role === 'b2b_user' ? 'bg-teal-600 text-white' : 'bg-green-600 text-white' }} shrink-0">Utama</span>
                                                        @endif
                                                    </div>
                                                    <p class="text-xs text-gray-500 leading-relaxed line-clamp-2" title="{{ $address->full_address }}">
                                                        {{ $address->full_address }}
                                                    </p>
                                                    <p class="text-xs font-medium text-gray-700 mt-2">
                                                        <i class="fa-solid fa-phone mr-1 text-gray-400"></i> {{ $address->phone }}
                                                    </p>
                                                </div>
                                            </label>
                                        @empty
                                            <div class="col-span-1 md:col-span-2 bg-red-50 border border-red-200 rounded-2xl p-6 text-center">
                                                <div class="w-12 h-12 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">
                                                    <i class="fa-solid fa-map-location-dot"></i>
                                                </div>
                                                <h4 class="font-bold text-gray-900 mb-1">Belum Ada Lokasi Tersimpan</h4>
                                                <p class="text-sm text-gray-500 mb-4">Anda harus menyimpan minimal 1 alamat di Buku Alamat sebelum bisa melakukan penjemputan.</p>
                                                <a href="{{ route('address.edit') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-2.5 rounded-xl transition shadow-md text-sm">
                                                    Ke Buku Alamat Sekarang
                                                </a>
                                            </div>
                                        @endforelse
                                    </div>
                                    <x-input-error :messages="$errors->get('address_id')" class="mt-2 text-red-600" />
                                </div>

                                <hr class="border-gray-100">

                                <div>
                                    <label for="pickup_date" class="block font-bold text-gray-700 mb-2">
                                        Tanggal & Jam <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fa-regular fa-calendar-check {{ Auth::user()->role === 'b2b_user' ? 'text-teal-500' : 'text-green-500' }} text-lg"></i>
                                        </div>
                                        <input type="datetime-local" id="pickup_date" name="pickup_date" value="{{ old('pickup_date') }}" required
                                            class="block w-full pl-12 pr-4 py-4 bg-gray-50 border border-gray-200 rounded-2xl text-gray-900 focus:ring-4 {{ Auth::user()->role === 'b2b_user' ? 'focus:ring-teal-500/20 focus:border-teal-500' : 'focus:ring-green-500/20 focus:border-green-500' }} focus:bg-white transition font-medium"
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
                                            <li>{{ Auth::user()->role === 'b2b_user' ? 'Armada kami akan menimbang total limbah (minimal 10Kg) di lokasi.' : 'Mitra akan menimbang sampah di lokasi untuk menentukan poin.' }}</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-100 flex items-center justify-between gap-4">
                                    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 font-bold px-4 py-3 transition">
                                        Batal
                                    </a>
                                    <button type="submit" {{ $addresses->count() == 0 ? 'disabled' : '' }} class="{{ Auth::user()->role === 'b2b_user' ? 'bg-teal-600 hover:bg-teal-700 shadow-teal-600/30' : 'bg-green-600 hover:bg-green-700 shadow-green-600/30' }} disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold px-8 py-4 rounded-2xl transition transform hover:-translate-y-1 shadow-lg flex items-center gap-2">
                                        <i class="fa-solid fa-paper-plane"></i> 
                                        {{ Auth::user()->role === 'b2b_user' ? 'Jadwalkan Armada' : 'Ajukan Penjemputan' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-5/12 space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Estimasi Nilai Tukar Limbah</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($catalogs as $catalog)
                            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4">
                                <div class="bg-{{ $catalog->color_class }}-100 text-{{ $catalog->color_class }}-600 w-12 h-12 rounded-full flex items-center justify-center shrink-0">
                                    <i class="fa-solid {{ $catalog->icon_class }} text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $catalog->name }}</h4>
                                    <p class="text-[10px] text-gray-500 mt-1 leading-tight">{{ $catalog->description }}</p>
                                    
                                    <div class="mt-3 inline-block {{ Auth::user()->role === 'b2b_user' ? 'bg-teal-50 border-teal-200' : 'bg-green-50 border-green-200' }} border px-2 py-1 rounded-lg">
                                        <span class="text-xs font-black {{ Auth::user()->role === 'b2b_user' ? 'text-teal-700' : 'text-green-700' }}">
                                            {{ Auth::user()->role === 'b2b_user' ? number_format($catalog->price_b2b, 0, ',', '.') : number_format($catalog->price_b2c, 0, ',', '.') }} Pts / Kg
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-6 text-sm text-gray-500 border border-dashed border-gray-200 rounded-2xl bg-white">
                                Data katalog harga belum tersedia.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>