<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="bg-gray-900 p-2 rounded-xl">
                <i class="fa-solid fa-truck-fast text-white"></i>
            </div>
            {{ __('Kelola Penjemputan') }}
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

            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-black text-gray-900">Daftar Permintaan Masuk</h3>
                    <div class="bg-white px-4 py-2 border border-gray-200 rounded-lg text-sm font-bold text-gray-600 shadow-sm">
                        Total: {{ $pickups->count() }} Data
                    </div>
                </div>

                <div class="overflow-x-auto pb-32">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-900 text-white text-sm uppercase tracking-wider">
                                <th class="p-4 font-bold">ID & Tanggal</th>
                                <th class="p-4 font-bold">Pengguna / Klien</th>
                                <th class="p-4 font-bold">Status Saat Ini</th>
                                <th class="p-4 font-bold">Aksi Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pickups as $pickup)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="p-4">
                                        <div class="font-black text-gray-900">#{{ str_pad($pickup->id, 5, '0', STR_PAD_LEFT) }}</div>
                                        <div class="text-sm text-gray-500 mt-1"><i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($pickup->pickup_date)->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 flex items-center gap-2">
                                            {{ $pickup->user->name }}
                                            @if($pickup->user->role === 'b2b_user')
                                                <span class="bg-teal-100 text-teal-700 text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider">B2B</span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500 mt-1"><i class="fa-solid fa-map-pin mr-1"></i> {{ Str::limit($pickup->user->address ?? 'Alamat belum diisi', 30) }}</div>
                                    </td>
                                    <td class="p-4">
                                        @if($pickup->status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide border border-yellow-200"><i class="fa-solid fa-hourglass-half mr-1"></i> Menunggu</span>
                                        @elseif($pickup->status == 'on_the_way')
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide border border-blue-200"><i class="fa-solid fa-truck-fast mr-1"></i> Di Jalan</span>
                                        @elseif($pickup->status == 'completed')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide border border-green-200"><i class="fa-solid fa-check mr-1"></i> Selesai (+{{ $pickup->total_points_earned }})</span>
                                        @elseif($pickup->status == 'cancelled')
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide border border-red-200"><i class="fa-solid fa-xmark mr-1"></i> Batal</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <form action="{{ route('admin.pickups.update', $pickup->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-3">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="relative custom-select-wrapper w-44">
                                                <input type="hidden" name="status" value="{{ $pickup->status }}">
                                                
                                                <button type="button" class="select-button w-full flex items-center justify-between border border-gray-200 rounded-lg px-3 py-2 text-sm font-bold text-gray-700 transition focus:ring-2 focus:ring-gray-900 focus:outline-none {{ $pickup->status == 'completed' ? 'bg-gray-100 opacity-70 cursor-not-allowed' : 'bg-white hover:bg-gray-50 shadow-sm cursor-pointer' }}" {{ $pickup->status == 'completed' ? 'disabled' : '' }}>
                                                    <span class="selected-text flex items-center gap-2">
                                                        @if($pickup->status == 'pending') 
                                                            <i class="fa-solid fa-hourglass-half text-yellow-500 w-4 text-center"></i> Menunggu
                                                        @elseif($pickup->status == 'on_the_way') 
                                                            <i class="fa-solid fa-truck-fast text-blue-500 w-4 text-center"></i> Armada Di Jalan
                                                        @elseif($pickup->status == 'completed') 
                                                            <i class="fa-solid fa-check text-green-500 w-4 text-center"></i> Selesai
                                                        @elseif($pickup->status == 'cancelled') 
                                                            <i class="fa-solid fa-xmark text-red-500 w-4 text-center"></i> Batalkan
                                                        @endif
                                                    </span>
                                                    <i class="fa-solid fa-chevron-down text-xs text-gray-400 chevron-icon transition-transform"></i>
                                                </button>

                                                <div class="select-menu absolute z-50 left-0 w-full mt-1 bg-white border border-gray-100 rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] opacity-0 invisible transform -translate-y-2 transition-all duration-200 overflow-hidden">
                                                    <ul class="py-1 text-sm font-bold text-gray-600">
                                                        <li class="px-3 py-2.5 hover:bg-yellow-50 hover:text-yellow-700 cursor-pointer flex items-center gap-2 transition option-item" data-value="pending">
                                                            <i class="fa-solid fa-hourglass-half text-yellow-500 w-4 text-center"></i> Menunggu
                                                        </li>
                                                        <li class="px-3 py-2.5 hover:bg-blue-50 hover:text-blue-700 cursor-pointer flex items-center gap-2 transition option-item" data-value="on_the_way">
                                                            <i class="fa-solid fa-truck-fast text-blue-500 w-4 text-center"></i> Armada Di Jalan
                                                        </li>
                                                        <li class="px-3 py-2.5 hover:bg-green-50 hover:text-green-700 cursor-pointer flex items-center gap-2 transition option-item" data-value="completed">
                                                            <i class="fa-solid fa-check text-green-500 w-4 text-center"></i> Selesai
                                                        </li>
                                                        <li class="px-3 py-2.5 hover:bg-red-50 hover:text-red-700 cursor-pointer flex items-center gap-2 transition option-item" data-value="cancelled">
                                                            <i class="fa-solid fa-xmark text-red-500 w-4 text-center"></i> Batalkan
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @if($pickup->status !== 'completed')
                                                <button type="submit" class="bg-gray-900 hover:bg-black text-white px-3 py-2 rounded-lg font-bold text-sm transition shadow-md shrink-0 flex items-center gap-1.5">
                                                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-500">
                                        <i class="fa-solid fa-inbox text-4xl mb-3 text-gray-300 block"></i>
                                        Belum ada data permintaan penjemputan sampah.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrappers = document.querySelectorAll('.custom-select-wrapper');

            wrappers.forEach(wrapper => {
                const btn = wrapper.querySelector('.select-button');
                const menu = wrapper.querySelector('.select-menu');
                const chevron = wrapper.querySelector('.chevron-icon');
                const input = wrapper.querySelector('input[name="status"]');
                const selectedText = wrapper.querySelector('.selected-text');
                const options = wrapper.querySelectorAll('.option-item');

                // Jika tombol di-disable (karena status Selesai), abaikan script
                if(btn.disabled) return;

                btn.addEventListener('click', (e) => {
                    e.preventDefault(); 
                    e.stopPropagation();
                    
                    // Tutup semua menu dropdown lain yang sedang terbuka di tabel
                    document.querySelectorAll('.select-menu').forEach(m => {
                        if (m !== menu) {
                            m.classList.remove('opacity-100', 'visible', 'translate-y-0');
                            m.classList.add('opacity-0', 'invisible', '-translate-y-2');
                        }
                    });
                    document.querySelectorAll('.chevron-icon').forEach(c => {
                        if (c !== chevron) c.classList.remove('rotate-180');
                    });

                    // Buka/Tutup menu dropdown baris ini
                    const isExpanded = menu.classList.contains('opacity-100');
                    if(isExpanded) {
                        menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                        menu.classList.add('opacity-0', 'invisible', '-translate-y-2');
                        chevron.classList.remove('rotate-180');
                    } else {
                        menu.classList.add('opacity-100', 'visible', 'translate-y-0');
                        menu.classList.remove('opacity-0', 'invisible', '-translate-y-2');
                        chevron.classList.add('rotate-180');
                    }
                });

                // Logika ketika salah satu opsi dipilih
                options.forEach(option => {
                    option.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const val = option.getAttribute('data-value');
                        const html = option.innerHTML;

                        // Perbarui nilai input form tersembunyi
                        input.value = val;
                        
                        // Perbarui tampilan teks & ikon tombol utama
                        selectedText.innerHTML = html;

                        // Tutup menu kembali
                        menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                        menu.classList.add('opacity-0', 'invisible', '-translate-y-2');
                        chevron.classList.remove('rotate-180');
                    });
                });
            });

            // Tutup dropdown jika Admin mengklik di luar area menu
            document.addEventListener('click', () => {
                document.querySelectorAll('.select-menu').forEach(m => {
                    m.classList.remove('opacity-100', 'visible', 'translate-y-0');
                    m.classList.add('opacity-0', 'invisible', '-translate-y-2');
                });
                document.querySelectorAll('.chevron-icon').forEach(c => {
                    c.classList.remove('rotate-180');
                });
            });
        });
    </script>
</x-app-layout>