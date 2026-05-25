<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="{{ Auth::user()->role === 'b2b_user' ? 'bg-teal-100 text-teal-600' : 'bg-green-100 text-green-600' }} p-2 rounded-xl">
                <i class="fa-solid fa-address-book"></i>
            </div>
            Buku Alamat {{ Auth::user()->role === 'b2b_user' ? 'Bisnis' : 'Personal' }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="w-full lg:w-5/12">
                    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 relative overflow-hidden group">
                        <div class="mb-6 border-b border-gray-100 pb-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Tambah Lokasi Baru</h3>
                            <p class="text-xs text-gray-500">Simpan alamat untuk mempermudah penjemputan.</p>
                        </div>

                        <form action="{{ route('address.store') }}" method="POST" class="space-y-5">
                            @csrf
                            
                            <div>
                                <label for="label_name" class="block text-sm font-bold text-gray-700 mb-2">Nama Label Alamat <span class="text-red-500">*</span></label>
                                <input type="text" id="label_name" name="label_name" required class="block w-full py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:ring-2 {{ Auth::user()->role === 'b2b_user' ? 'focus:ring-teal-500' : 'focus:ring-green-500' }} transition" placeholder="Misal: Rumah Mertua / Gudang Cabang A">
                            </div>

                            @if(Auth::user()->role === 'b2b_user')
                                <div>
                                    <label for="pic_name" class="block text-sm font-bold text-gray-700 mb-2">Nama PIC (Penanggung Jawab) <span class="text-red-500">*</span></label>
                                    <input type="text" id="pic_name" name="pic_name" required class="block w-full py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:ring-2 focus:ring-teal-500 transition" placeholder="Nama karyawan di lokasi ini">
                                </div>
                            @endif

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">No. HP Lokasi <span class="text-red-500">*</span></label>
                                    <input type="text" id="phone" name="phone" required class="block w-full py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:ring-2 {{ Auth::user()->role === 'b2b_user' ? 'focus:ring-teal-500' : 'focus:ring-green-500' }} transition" placeholder="0812...">
                                </div>
                                <div>
                                    <label for="city" class="block text-sm font-bold text-gray-700 mb-2">Kota <span class="text-red-500">*</span></label>
                                    <input type="text" id="city" name="city" required class="block w-full py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:ring-2 {{ Auth::user()->role === 'b2b_user' ? 'focus:ring-teal-500' : 'focus:ring-green-500' }} transition" placeholder="Misal: Bandung">
                                </div>
                            </div>

                            <div>
                                <label for="full_address" class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea id="full_address" name="full_address" rows="3" required class="block w-full p-4 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:ring-2 {{ Auth::user()->role === 'b2b_user' ? 'focus:ring-teal-500' : 'focus:ring-green-500' }} transition" placeholder="Nama jalan, patokan..."></textarea>
                            </div>

                            <button type="submit" class="w-full {{ Auth::user()->role === 'b2b_user' ? 'bg-teal-600 hover:bg-teal-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-bold py-3.5 rounded-xl transition shadow-md flex items-center justify-center gap-2">
                                <i class="fa-solid fa-plus"></i> Tambah Alamat
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full lg:w-7/12 space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 px-2">Daftar Lokasi Tersimpan</h3>
                    
                    @forelse($addresses as $address)
                        <div class="bg-white p-5 rounded-2xl border {{ $address->is_primary ? (Auth::user()->role === 'b2b_user' ? 'border-teal-500 ring-2 ring-teal-500/20' : 'border-green-500 ring-2 ring-green-500/20') : 'border-gray-200' }} shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 transition-all">
                            
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="font-bold text-gray-900 text-lg">{{ $address->label_name }}</h4>
                                    @if($address->is_primary)
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md {{ Auth::user()->role === 'b2b_user' ? 'bg-teal-100 text-teal-700' : 'bg-green-100 text-green-700' }}">Utama</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 font-medium mb-1">{{ Auth::user()->role === 'b2b_user' ? $address->pic_name.' - ' : '' }}{{ $address->phone }}</p>
                                <p class="text-xs text-gray-500 leading-relaxed">{{ $address->full_address }}, Kota {{ $address->city }}</p>
                            </div>

                            @if(!$address->is_primary)
                                <form action="{{ route('address.setPrimary', $address->id) }}" method="POST" class="shrink-0">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-xs font-bold text-gray-500 border border-gray-300 hover:bg-gray-50 px-3 py-1.5 rounded-lg transition">
                                        Jadikan Utama
                                    </button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <div class="bg-white p-8 rounded-2xl border-2 border-dashed border-gray-200 text-center">
                            <i class="fa-regular fa-map text-4xl text-gray-300 mb-3 block"></i>
                            <p class="text-gray-500 font-medium">Belum ada alamat yang tersimpan.<br>Silakan tambahkan lokasi dari panel di samping.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>