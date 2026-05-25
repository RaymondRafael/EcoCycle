<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="bg-gray-900 p-2 rounded-xl">
                <i class="fa-solid fa-tags text-white"></i>
            </div>
            {{ __('Katalog Harga & Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-3xl p-6 shadow-xl shadow-gray-200/40 border border-gray-100">
                        <div class="mb-6 pb-4 border-b border-gray-100">
                            <h3 class="text-lg font-black text-gray-900">Tambah Kategori</h3>
                            <p class="text-sm text-gray-500 mt-1">Buat jenis sampah baru yang diterima sistem.</p>
                        </div>

                        <form action="{{ route('admin.catalogs.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Kategori</label>
                                <input type="text" name="name" required class="block w-full border-gray-200 rounded-xl text-sm focus:ring-gray-900 focus:border-gray-900" placeholder="Misal: Elektronik">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Singkat</label>
                                <input type="text" name="description" required class="block w-full border-gray-200 rounded-xl text-sm focus:ring-gray-900 focus:border-gray-900" placeholder="Misal: HP, Laptop, Kabel rusak">
                            </div>
                            
                            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Ikon (FontAwesome)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                            <i class="fa-brands fa-font-awesome"></i>
                                        </div>
                                        <input type="text" name="icon_class" required class="block w-full pl-9 border-gray-200 rounded-xl text-sm focus:ring-gray-900 focus:border-gray-900" placeholder="fa-plug">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Warna Tema</label>
                                    <select name="color_class" required class="block w-full border-gray-200 rounded-xl text-sm focus:ring-gray-900 focus:border-gray-900">
                                        <option value="blue">Biru (Blue)</option>
                                        <option value="yellow">Kuning (Yellow)</option>
                                        <option value="teal">Hijau Tosca (Teal)</option>
                                        <option value="gray">Abu-abu (Gray)</option>
                                        <option value="red">Merah (Red)</option>
                                        <option value="purple">Ungu (Purple)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Harga B2C</label>
                                    <input type="number" name="price_b2c" required class="block w-full border-gray-200 rounded-xl text-sm focus:ring-gray-900 focus:border-gray-900" placeholder="Rp">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Harga B2B</label>
                                    <input type="number" name="price_b2b" required class="block w-full border-gray-200 rounded-xl text-sm focus:ring-gray-900 focus:border-gray-900" placeholder="Rp">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white px-4 py-3 rounded-xl font-bold transition mt-4 shadow-md">
                                <i class="fa-solid fa-plus mr-1"></i> Simpan Kategori
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                            <h3 class="text-lg font-black text-gray-900">Daftar Nilai Tukar</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-900 text-white text-sm uppercase tracking-wider">
                                        <th class="p-4 font-bold">Kategori</th>
                                        <th class="p-4 font-bold text-center">Harga B2C (Personal)</th>
                                        <th class="p-4 font-bold text-center">Harga B2B (Grosir)</th>
                                        <th class="p-4 font-bold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($catalogs as $item)
                                        <tr class="hover:bg-gray-50 transition duration-150">
                                            
                                            <td class="p-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-full bg-{{ $item->color_class }}-100 text-{{ $item->color_class }}-600 flex items-center justify-center text-lg shrink-0">
                                                        <i class="fa-solid {{ $item->icon_class }}"></i>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-bold text-gray-900">{{ $item->name }}</h4>
                                                        <p class="text-[10px] text-gray-500 leading-tight mt-0.5 max-w-[120px]">{{ $item->description }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td colspan="2" class="p-0">
                                                <form action="{{ route('admin.catalogs.update', $item->id) }}" method="POST" class="flex items-center justify-center gap-3 py-4 w-full h-full">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div class="relative w-24 sm:w-28">
                                                        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none"><span class="text-gray-500 text-xs font-bold">Rp</span></div>
                                                        <input type="number" name="price_b2c" value="{{ $item->price_b2c }}" class="block w-full pl-7 pr-2 py-1.5 text-sm border-gray-200 rounded-lg focus:ring-green-500 focus:border-green-500 text-center font-bold text-gray-700" title="Harga B2C">
                                                    </div>
                                                    
                                                    <div class="relative w-24 sm:w-28">
                                                        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none"><span class="text-gray-500 text-xs font-bold">Rp</span></div>
                                                        <input type="number" name="price_b2b" value="{{ $item->price_b2b }}" class="block w-full pl-7 pr-2 py-1.5 text-sm border-gray-200 rounded-lg focus:ring-teal-500 focus:border-teal-500 text-center font-bold text-teal-700 bg-teal-50" title="Harga B2B">
                                                    </div>

                                                    <button type="submit" class="bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-sm" title="Simpan Perubahan Harga">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                </form>
                                            </td>

                                            <td class="p-4 text-right">
                                                <form action="{{ route('admin.catalogs.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini secara permanen?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-lg transition" title="Hapus Kategori">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-8 text-center text-gray-500 border-dashed border-2 border-gray-100">
                                                <i class="fa-solid fa-tags text-4xl mb-3 text-gray-300 block"></i>
                                                Katalog harga masih kosong. Tambahkan kategori baru di panel sebelah kiri.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>