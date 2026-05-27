<x-app-layout>
    <div class="min-h-screen bg-gray-50 pb-12">
        <div class="bg-gradient-to-r from-blue-700 to-indigo-900 pb-24 pt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-black text-white tracking-tight">
                            Driver Panel EcoCycle 🚛
                        </h2>
                        <p class="text-blue-200 mt-1">Halo {{ Auth::user()->name }}, mari bersihkan lingkungan hari ini!</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10">
            @if(session('success'))
                <div class="mb-6 bg-green-500 text-white p-4 rounded-2xl font-bold shadow-lg flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-500 text-white p-4 rounded-2xl font-bold shadow-lg flex items-center gap-3">
                    <i class="fa-solid fa-circle-xmark text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-sm">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Jadwal Tugas Saya</h3>
                            <p class="text-gray-500 text-sm">Penjemputan aktif yang Anda tangani</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($myPickups as $pickup)
                            <div onclick="window.location='{{ route('driver.detail', $pickup->id) }}'" class="border border-gray-100 rounded-2xl p-5 hover:shadow-md transition bg-gradient-to-br from-white to-gray-50/50 cursor-pointer">
                                <div class="flex justify-between items-start mb-3">
                                    <span class="text-xs font-bold px-3 py-1 rounded-full 
                                        {{ $pickup->status == 'on_the_way' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-yellow-100 text-yellow-700 border border-yellow-200' }}">
                                        {{ $pickup->status == 'on_the_way' ? 'Sedang Menuju Lokasi' : 'Tugas Diambil' }}
                                    </span>
                                    <span class="text-xs text-gray-500 font-medium">
                                        <i class="fa-regular fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($pickup->pickup_date)->format('d M Y, H:i') }}
                                    </span>
                                </div>

                                <h4 class="font-extrabold text-gray-900 text-lg mb-1">{{ $pickup->user->name }}</h4>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    <i class="fa-solid fa-location-dot text-red-500 mr-1.5 shrink-0"></i> {{ $pickup->pickup_address }}
                                </p>

                                <div class="flex flex-wrap gap-3">
                                    @if($pickup->status == 'pending')
                                        <form action="{{ route('driver.start', $pickup->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" onclick="event.stopPropagation()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 shadow-md shadow-blue-200">
                                                <i class="fa-solid fa-truck-fast"></i> Mulai Menuju Lokasi
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('driver.detail', $pickup->id) }}" onclick="event.stopPropagation()" class="bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                                        <i class="fa-solid fa-scale-balanced text-blue-600"></i> Detail & Timbang
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="w-20 h-20 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-clipboard-list text-3xl text-gray-300"></i>
                                </div>
                                <h4 class="font-bold text-gray-900">Belum ada tugas aktif</h4>
                                <p class="text-gray-500 text-sm max-w-xs mx-auto mt-1">Silakan ambil tugas penjemputan baru yang tersedia di sisi kanan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-xl shadow-sm">
                            <i class="fa-solid fa-truck-ramp-box"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900">Tugas Baru Tersedia</h3>
                            <p class="text-gray-500 text-sm">Ambil permintaan penjemputan sampah dari user</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($availablePickups as $pickup)
                            <div onclick="window.location='{{ route('driver.detail', $pickup->id) }}'" class="border border-gray-100 rounded-2xl p-5 hover:shadow-md transition bg-gradient-to-br from-white to-gray-50/50 cursor-pointer relative">
                                <div class="flex justify-between items-start mb-3">
                                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-green-100 text-green-700 border border-green-200">
                                        Menunggu Driver
                                    </span>
                                    <span class="text-xs text-gray-500 font-medium">
                                        <i class="fa-regular fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($pickup->pickup_date)->format('d M Y, H:i') }}
                                    </span>
                                </div>

                                <h4 class="font-extrabold text-gray-900 text-lg mb-1">
                                    {{ $pickup->user->name }}
                                    <span class="ml-2 text-xs font-semibold px-2 py-0.5 rounded-full {{ $pickup->user->role === 'b2b_user' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $pickup->user->role === 'b2b_user' ? 'B2B/Bisnis' : 'B2C/Ritel' }}
                                    </span>
                                </h4>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    <i class="fa-solid fa-location-dot text-red-500 mr-1.5 shrink-0"></i> {{ $pickup->pickup_address }}
                                </p>

                                <form action="{{ route('driver.claim', $pickup->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="event.stopPropagation()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold text-xs py-3 rounded-xl transition flex items-center justify-center gap-1.5 shadow-md shadow-green-100">
                                        <i class="fa-solid fa-hand-holding-hand"></i> Ambil Tugas Penjemputan
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="w-20 h-20 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-circle-check text-3xl text-gray-300"></i>
                                </div>
                                <h4 class="font-bold text-gray-900">Semua bersih!</h4>
                                <p class="text-gray-500 text-sm max-w-xs mx-auto mt-1">Tidak ada permintaan penjemputan baru yang mengantre saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
