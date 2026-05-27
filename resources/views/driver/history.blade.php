<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="bg-gradient-to-r from-blue-700 to-indigo-900 pb-24 pt-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <a href="{{ route('driver.dashboard') }}" class="bg-white/10 hover:bg-white/20 text-white w-10 h-10 rounded-full flex items-center justify-center transition border border-white/15">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h2 class="text-3xl font-black text-white tracking-tight">
                            Riwayat Kerja Driver 📦
                        </h2>
                        <p class="text-blue-200 mt-1">Daftar rekapitulasi penjemputan sampah yang telah Anda selesaikan</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10">
            <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-gray-900">Rekap Tugas Harian/Bulanan</h3>
                    <span class="text-xs font-bold bg-blue-50 text-blue-600 px-3 py-1 rounded-full border border-blue-100">
                        Total Selesai: {{ $history->where('status', 'completed')->count() }} Tugas
                    </span>
                </div>

                <div class="space-y-6">
                    @forelse($history as $item)
                        <div class="border border-gray-100 rounded-3xl p-6 hover:shadow-md transition bg-gradient-to-br from-white to-gray-50/50 flex flex-col md:flex-row justify-between gap-6">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-3 mb-3">
                                    <span class="text-xs font-black px-3 py-1 rounded-full 
                                        {{ $item->status == 'completed' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200' }}">
                                        {{ strtoupper($item->status) }}
                                    </span>
                                    <span class="text-xs text-gray-400 font-semibold">
                                        <i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y, H:i') }}
                                    </span>
                                </div>

                                <h4 class="font-extrabold text-gray-900 text-lg mb-1">{{ $item->user->name }}</h4>
                                <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                                    <i class="fa-solid fa-location-dot text-red-500 mr-1shrink-0"></i> {{ $item->pickup_address }}
                                </p>

                                @if($item->driver_notes)
                                    <div class="bg-gray-100 rounded-2xl p-4 mb-4 text-xs font-semibold text-gray-600 border border-gray-200">
                                        <i class="fa-solid fa-note-sticky text-blue-500 mr-1.5 text-sm"></i>
                                        <span>Catatan Driver: {{ $item->driver_notes }}</span>
                                    </div>
                                @endif

                                @if($item->status == 'completed')
                                    <div class="bg-blue-50/40 rounded-2xl p-4 border border-blue-100/50">
                                        <h5 class="text-xs font-black text-blue-800 uppercase tracking-wider mb-2">Sampah Daur Ulang</h5>
                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                                            @foreach($item->details as $detail)
                                                <div>
                                                    <p class="text-gray-400 font-bold">{{ $detail->wasteCategory->name }}</p>
                                                    <p class="text-gray-800 font-black text-sm">{{ number_format($detail->weight_kg, 2) }} Kg</p>
                                                    <p class="text-green-600 font-bold">+{{ number_format($detail->subtotal_points) }} Pts</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="w-full md:w-48 flex flex-col items-center md:items-end justify-between gap-4 border-t md:border-t-0 md:border-l border-gray-100 pt-6 md:pt-0 md:pl-6 shrink-0">
                                <div class="text-center md:text-right w-full">
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-0.5">Total Hadiah Poin</p>
                                    @if($item->status == 'completed')
                                        <h3 class="text-3xl font-black text-green-600">+{{ number_format($item->total_points_earned) }} <span class="text-xs text-gray-400 font-medium">Pts</span></h3>
                                    @else
                                        <h3 class="text-xl font-extrabold text-red-600">0 Pts</h3>
                                    @endif
                                </div>

                                @if($item->photo)
                                    <div class="w-full h-32 rounded-2xl overflow-hidden shadow-sm relative group cursor-pointer border border-gray-200">
                                        <img src="{{ asset($item->photo) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" alt="Bukti Foto">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold">
                                            <i class="fa-solid fa-expand text-lg"></i>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div class="w-24 h-24 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fa-solid fa-clock-rotate-left text-4xl text-gray-300"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">Riwayat tugas masih kosong</h4>
                            <p class="text-gray-500 max-w-sm mx-auto">Anda belum menyelesaikan atau membatalkan tugas penjemputan sampah apa pun.</p>
                            <a href="{{ route('driver.dashboard') }}" class="inline-block mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold transition shadow-md shadow-blue-100">
                                Ambil Tugas Baru
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
