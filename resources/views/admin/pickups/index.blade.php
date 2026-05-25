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

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-900 text-white text-sm uppercase tracking-wider">
                                <th class="p-4 font-bold">ID & Tanggal</th>
                                <th class="p-4 font-bold">Pengguna / Klien</th>
                                <th class="p-4 font-bold">Status Saat Ini</th>
                                <th class="p-4 font-bold">Aksi & Beri Poin</th>
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
                                        <form action="{{ route('admin.pickups.update', $pickup->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            
                                            <select name="status" class="text-sm border-gray-200 rounded-lg focus:ring-gray-900 focus:border-gray-900 {{ $pickup->status == 'completed' ? 'bg-gray-100 cursor-not-allowed' : '' }}" {{ $pickup->status == 'completed' ? 'disabled' : '' }}>
                                                <option value="pending" {{ $pickup->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="on_the_way" {{ $pickup->status == 'on_the_way' ? 'selected' : '' }}>Armada Di Jalan</option>
                                                <option value="completed" {{ $pickup->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                <option value="cancelled" {{ $pickup->status == 'cancelled' ? 'selected' : '' }}>Batalkan</option>
                                            </select>

                                            <input type="number" name="points" value="{{ $pickup->total_points_earned > 0 ? $pickup->total_points_earned : '' }}" placeholder="Jml Poin / Rp" class="text-sm border-gray-200 rounded-lg w-28 focus:ring-green-500 focus:border-green-500 {{ $pickup->status == 'completed' ? 'bg-gray-100 cursor-not-allowed' : '' }}" {{ $pickup->status == 'completed' ? 'disabled' : '' }}>

                                            @if($pickup->status !== 'completed')
                                                <button type="submit" class="bg-gray-900 hover:bg-black text-white px-3 py-2 rounded-lg font-bold text-sm transition shadow-md">
                                                    <i class="fa-solid fa-floppy-disk"></i>
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
</x-app-layout>