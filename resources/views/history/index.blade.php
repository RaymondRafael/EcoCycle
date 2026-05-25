<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <div class="{{ Auth::user()->role === 'b2b_user' ? 'bg-teal-100' : 'bg-green-100' }} p-2 rounded-xl">
                <i class="fa-solid fa-clock-rotate-left {{ Auth::user()->role === 'b2b_user' ? 'text-teal-600' : 'text-green-600' }}"></i>
            </div>
            {{ Auth::user()->role === 'b2b_user' ? __('Riwayat Logistik') : __('Riwayat Penjemputan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <p class="text-gray-500">
                    {{ Auth::user()->role === 'b2b_user' ? 'Pantau status armada logistik dan total pendapatan limbah bisnismu.' : 'Pantau status penjemputan dan total poin yang telah kamu kumpulkan.' }}
                </p>
            </div>

            <div class="space-y-4">
                @forelse ($pickups as $pickup)
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        
                        <div class="flex items-start sm:items-center gap-4">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center shrink-0 
                                {{ $pickup->status == 'completed' ? 'bg-green-50 text-green-600 border border-green-100' : '' }}
                                {{ $pickup->status == 'pending' ? 'bg-yellow-50 text-yellow-600 border border-yellow-100' : '' }}
                                {{ $pickup->status == 'on_the_way' ? 'bg-blue-50 text-blue-600 border border-blue-100' : '' }}
                                {{ $pickup->status == 'cancelled' ? 'bg-red-50 text-red-600 border border-red-100' : '' }}
                            ">
                                @if($pickup->status == 'completed') <i class="fa-solid fa-check-circle text-2xl"></i>
                                @elseif($pickup->status == 'pending') <i class="fa-solid fa-hourglass-half text-xl"></i>
                                @elseif($pickup->status == 'on_the_way') <i class="fa-solid fa-truck-fast text-xl"></i>
                                @else <i class="fa-solid fa-xmark-circle text-2xl"></i>
                                @endif
                            </div>

                            <div>
                                <p class="text-sm text-gray-500 font-medium mb-1">
                                    <i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($pickup->pickup_date)->format('d M Y • H:i') }}
                                </p>
                                <h4 class="font-bold text-gray-900 text-lg">
                                    {{ Auth::user()->role === 'b2b_user' ? 'ID Logistik' : 'ID Penjemputan' }}: #{{ str_pad($pickup->id, 5, '0', STR_PAD_LEFT) }}
                                </h4>
                            </div>
                        </div>

                        <div class="flex flex-col sm:items-end gap-2 w-full sm:w-auto mt-2 sm:mt-0 pt-4 sm:pt-0 border-t sm:border-0 border-gray-50">
                            @if($pickup->status == 'pending')
                                <span class="bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide">Menunggu Konfirmasi</span>
                            @elseif($pickup->status == 'on_the_way')
                                <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide">
                                    {{ Auth::user()->role === 'b2b_user' ? 'Armada Menuju Lokasi' : 'Mitra Menuju Lokasi' }}
                                </span>
                            @elseif($pickup->status == 'completed')
                                <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide">Selesai</span>
                            @elseif($pickup->status == 'cancelled')
                                <span class="bg-red-50 text-red-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide">Dibatalkan</span>
                            @endif

                            @if($pickup->total_points_earned > 0)
                                <p class="font-black {{ Auth::user()->role === 'b2b_user' ? 'text-teal-600' : 'text-green-600' }} text-lg">
                                    {{ Auth::user()->role === 'b2b_user' ? '+Rp ' . number_format($pickup->total_points_earned, 0, ',', '.') : '+' . number_format($pickup->total_points_earned, 0, ',', '.') . ' Poin' }}
                                </p>
                            @else
                                <p class="font-medium text-gray-400 text-sm">
                                    {{ Auth::user()->role === 'b2b_user' ? 'Pendapatan belum dihitung' : 'Poin belum dihitung' }}
                                </p>
                            @endif
                        </div>
                        
                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-12 shadow-sm border border-gray-100 text-center">
                        <div class="w-24 h-24 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-6">
                            <i class="fa-solid fa-receipt text-5xl text-gray-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            {{ Auth::user()->role === 'b2b_user' ? 'Belum ada riwayat logistik' : 'Belum ada riwayat penjemputan' }}
                        </h3>
                        <p class="text-gray-500 max-w-sm mx-auto mb-6">
                            {{ Auth::user()->role === 'b2b_user' ? 'Perusahaanmu belum pernah melakukan permintaan armada logistik. Jadwalkan sekarang untuk mulai berkontribusi!' : 'Kamu belum pernah melakukan permintaan penjemputan sampah. Yuk, mulai kumpulkan sekarang!' }}
                        </p>
                        <a href="{{ route('dashboard') }}" class="inline-block {{ Auth::user()->role === 'b2b_user' ? 'bg-teal-600 hover:bg-teal-700 shadow-teal-600/30' : 'bg-green-600 hover:bg-green-700 shadow-green-600/30' }} text-white px-8 py-3 rounded-xl font-bold transition shadow-lg">
                            Kembali ke Dashboard
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>